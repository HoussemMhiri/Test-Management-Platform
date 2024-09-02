<template>
    <div>
        <div v-if="loading" class="loading-overlay">
            <div class="ui active centered medium loader green"></div>
        </div>

        <form
            @submit.prevent="sendInvitations"
            class="ui form all_invit_container"
        >
            <div class="field drop">
                <Message v-if="errMsg" severity="error">{{ errMsg }}</Message>
                <label>{{ trans("tests.Select_Test") }}:</label>

                <Dropdown
                    v-model="selectedTest"
                    :options="allTests"
                    filter
                    optionLabel="title"
                    :placeholder="trans('tests.Select_Test')"
                    class="w-full md:w-14rem menu"
                >
                    <template #value="slotProps">
                        <div
                            v-if="slotProps.value"
                            class="flex align-items-center"
                        >
                            <div>{{ slotProps.value.title }}</div>
                        </div>
                        <span v-else>
                            {{ slotProps.placeholder }}
                        </span>
                    </template>
                    <template #option="slotProps">
                        <div class="flex align-items-center">
                            <div>{{ slotProps.option.title }}</div>
                        </div>
                    </template>
                </Dropdown>
            </div>
            <div class="field drop">
                <label>{{ trans("tests.sessions") }}:</label>

                <Dropdown
                    v-model="selectedSession"
                    :options="filteredSessions"
                    optionLabel="test.title"
                    :placeholder="trans('tests.sessions')"
                    class="w-full md:w-14rem"
                />
            </div>

            <div class="field p-fluid chip">
                <label>{{ trans("tests.add_emails") }}</label>
                <Message severity="warn">
                    {{ trans("common.email_warning") }}
                    .</Message
                >
                <Chips v-model="value" separator="," @add="onAdd" />
            </div>

            <div class="btn_container">
                <btn
                    bgColor="var(--project-primary-color)"
                    :text="trans('common.submit')"
                    textColor="white"
                    font_Weight="600"
                    btn_width="800px"
                    cls="theBtn"
                />
            </div>
        </form>
    </div>
</template>

<script>
import Dropdown from "primevue/dropdown";
import Chips from "primevue/chips";
import Btn from "./btn.vue";

import Message from "primevue/message";
import axios from "axios";

export default {
    name: "send-invitation",

    components: { Dropdown, Chips, Btn, Message },

    props: ["fetchTestInvitations"],

    emits: ["changeInvitBoolean"],

    data() {
        return {
            allTests: "",
            sessions: "",

            selectedTest: "",
            selectedSession: "",
            value: [],

            errMsg: "",
            loading: false,
        };
    },
    computed: {
        filteredSessions() {
            if (!this.selectedTest) {
                return this.sessions;
            }
            return this.sessions?.filter(
                (session) => session.test.id === this.selectedTest.id
            );
        },
    },
    methods: {
        trans(key) {
            return trans(key);
        },
        async sendInvitations() {
            this.loading = true;
            let invitationData = {
                email: this.value,
                status: "PENDING",
                test_session_id: this.selectedSession?.id,
            };
            try {
                if (this.value.length !== 0 && this.selectedSession.id) {
                    const { data } = await axios.post(
                        "/api/tests/invitations",
                        invitationData
                    );

                    for (let key in invitationData) {
                        invitationData[key] = "";
                    }

                    this.loading = false;
                    this.$emit("changeInvitBoolean", false);
                    await this.fetchTestInvitations();
                    await toast.fire({
                        icon: "success",
                        title: trans("tests.success_inivitation"),
                        timer: 3000,
                    });
                } else {
                    this.errMsg = "All The Fields Are Required";
                }
            } catch (error) {
                this.errMsg = "You already sent an invitation to this email";
            }
        },

        async fetchAllTests() {
            const { data } = await axios.get(`/api/tests/fetch?paginate=false`);
            this.allTests = data.tests;
            console.log(this.allTests);
        },

        async fetchAllTestsSession() {
            try {
                const { data } = await axios.get(
                    `/api/testsSession/fetch?paginate=false`
                );

                this.sessions = data.sessions;
                console.log(this.sessions);
            } catch (error) {
                console.log(error);
            }
        },

        validateEmail(email) {
            const emailPattern =
                /^[a-zA-Z0-9._%+-]+@(gmail|outlook|yahoo|protonmail|icloud|zoho|aol|yandex)\.(com|org|net)$/i;
            return email.every((el) => emailPattern.test(el));
        },
        checkForDuplicates(emails) {
            return emails.every((email, i) => emails.indexOf(email) === i);
        },

        onAdd(event) {
            const email = event.value;
            (this.validateEmail(email) && this.checkForDuplicates(email)) ===
            false
                ? this.value.pop()
                : "";
        },
    },
    watch: {
        selectedTest() {
            this.filteredSessions;
        },
    },

    mounted() {
        this.fetchAllTests();
        this.fetchAllTestsSession();
    },
};
</script>

<style scoped>
.all_invit_container {
    background-color: white;
    width: 100%;
    margin: 0 auto;
    margin-top: 50px;
    min-height: 500px;
    box-shadow: 0 2px 4px rgba(0, 177, 110, 0.5);
    border-radius: 5px;
    padding: 20px;
    position: relative;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.ui.loader {
    margin: auto;
}

label {
    font-size: 20px !important;
    margin: 15px 0 !important;
}

.drop {
    margin-bottom: 30px !important;
}

.p {
    margin-bottom: 15px;
}

.drop .p-dropdown {
    box-shadow: none !important;
    border: 1px solid #ced4da !important;
    width: 100%;
    font-size: 18px;
}

.drop .p-dropdown:hover,
.drop .p-dropdown:focus {
    border-color: var(--project-primary-color) !important;
}

.btn_container {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}

.theBtn:hover {
    background-color: white !important;
    color: var(--project-primary-color) !important;
    border: 1px solid var(--project-primary-color) !important;
    transition: all 0.1s ease-in;
}
</style>

<style>
.p-chips .p-inputtext .p-chips-input-token input {
    border: none !important;
}
</style>
