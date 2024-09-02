<template>
    <div>
        <div v-if="loading" class="loading-overlay">
            <div class="ui active centered medium loader green"></div>
        </div>

        <form
            class="ui equal width large form form_container"
            @submit.prevent="
                screenName === 'add' ? addSession() : updateSession()
            "
        >
            <h1 class="ui dividing header">
                {{
                    screenName === "add"
                        ? trans("tests.add_session")
                        : trans("tests.edit_session")
                }}
            </h1>
            <Message v-if="errMsg" severity="error">{{ errMsg }}</Message>
            <div class="field">
                <label>{{ trans("tests.select_test") }}</label>
                <select
                    v-model="sessionForm.test_id"
                    class="ui dropdown"
                    name="test"
                >
                    <option value="">{{ trans("tests.select_test") }}</option>
                    <option
                        v-for="test in allTests"
                        :key="test.id"
                        :value="test.id"
                    >
                        {{ test.title }}
                    </option>
                </select>
            </div>
            <div class="fields">
                <div class="field">
                    <label>{{ trans("tests.start_at") }}:</label>
                    <Calendar
                        v-model="sessionForm.start_at"
                        id="calendar-12h"
                        showTime
                        hourFormat="24"
                        :onDateSelect="calculateEndAt"
                    />
                </div>
                <div class="field">
                    <label>{{ trans("tests.end_at") }}:</label>
                    <Calendar
                        v-model="sessionForm.end_at"
                        id="calendar-12h"
                        showTime
                        hourFormat="24"
                    />
                </div>
            </div>

            <div>
                <btn
                    :text="trans('common.submit')"
                    :bgColor="'#00b16e'"
                    :textColor="'white'"
                    :cls="'acc btn'"
                    :font_Weight="'600'"
                />
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import btn from "../tests-components/btn.vue";
import Message from "primevue/message";
import Calendar from "primevue/calendar";
import dayjs from "dayjs";

export default {
    components: { btn, Message, Calendar },

    name: "tests-session-form",

    props: ["screenName", "oneSession", "fetchAllTestsSession"],

    emits: ["changeScreen"],

    data() {
        return {
            allTests: null,
            sessionForm: {
                test_id:
                    this.screenName === "edit" ? this.oneSession.test_id : "",
                start_at:
                    this.screenName === "edit" ? this.oneSession.start_at : "",
                end_at:
                    this.screenName === "edit" ? this.oneSession.end_at : "",
                status: "Upcoming",
            },

            errMsg: "",
            loading: false,
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },

        async fetchAllTests() {
            const { data } = await axios.get(`/api/tests/fetch?paginate=false`);
            this.allTests = data.tests;
            console.log(this.allTests);
        },

        calculateEndAt() {
            if (
                this.sessionForm.start_at &&
                this.sessionForm.test_id &&
                this.allTests
            ) {
                const selectedTest = this.allTests.find(
                    (test) => test.id === this.sessionForm.test_id
                );
                if (selectedTest) {
                    const startAt = new Date(this.sessionForm.start_at);
                    const durationInMinutes = parseInt(selectedTest.duration);
                    const endAt = new Date(
                        startAt.getTime() + durationInMinutes * 60000
                    );

                    this.sessionForm.end_at = endAt;
                }
            }
        },

        formatDate(date) {
            return dayjs(date).format("YYYY-MM-DD HH:mm:ss");
        },

        async addSession() {
            console.log(this.sessionForm);
            try {
                this.loading = true;
                const allFieldsFilled = Object.values(this.sessionForm).every(
                    (value) => value
                );
                if (allFieldsFilled) {
                    this.errMsg = "";

                    this.sessionForm.start_at = this.formatDate(
                        this.sessionForm.start_at
                    );
                    this.sessionForm.end_at = this.formatDate(
                        this.sessionForm.end_at
                    );

                    const { data } = await axios.post(
                        "/api/testsSession",
                        this.sessionForm
                    );

                    for (let key in this.sessionForm) {
                        this.sessionForm[key] = "";
                    }

                    await this.fetchAllTestsSession();
                    this.loading = false;
                    this.$emit("changeScreen");

                    await toast.fire({
                        icon: "success",
                        title: trans("common.success"),
                        timer: 2000,
                    });
                } else {
                    this.errMsg = "All The Fields Are Required";
                }
            } catch (error) {
                console.log(error);
            }
        },

        async updateSession() {
            try {
                this.loading = true;
                this.sessionForm.start_at = this.formatDate(
                    this.sessionForm.start_at
                );
                this.sessionForm.end_at = this.formatDate(
                    this.sessionForm.end_at
                );

                const { data } = await axios.put(
                    `/api/testsSession/${this.oneSession.id}`,
                    this.sessionForm
                );
                console.log(data);
                for (let key in this.sessionForm) {
                    this.sessionForm[key] = "";
                }

                await this.fetchAllTestsSession();
                this.loading = false;
                this.$emit("changeScreen");
                await toast.fire({
                    icon: "success",
                    title: trans("common.update"),
                    timer: 2000,
                });
            } catch (error) {
                console.log(error);
            }
        },
    },

    mounted() {
        this.fetchAllTests();
    },
};
</script>

<style scoped>
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

#calendar-12h {
    width: 100% !important;
}
input:hover,
input:focus,
select:hover,
select:focus {
    border: 1px solid var(--project-primary-color) !important;
}
.form_container {
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 177, 110, 0.5);
    border-radius: 5px;
    padding: 30px;
    margin-top: 30px;
}

h1 {
    color: var(--project-primary-color) !important;
}

.field {
    margin-top: 25px !important;
}

.btn {
    width: 100px;
    border: none;
    margin-top: 25px;
}
.acc:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}
</style>
