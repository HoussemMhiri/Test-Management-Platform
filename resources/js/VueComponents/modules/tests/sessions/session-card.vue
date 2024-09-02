<template>
    <div class="item item_container">
        <div class="image">
            <img
                :src="
                    session.test.thumbnail
                        ? session.test.thumbnail
                        : 'https://www.brainchecker.in/assets/front/images/psychometrictest.jpg'
                "
                class="TestSession_img"
            />
        </div>
        <div class="content">
            <div class="header">{{ session.test.title }}</div>
            <div class="description">
                <div>
                    <span class="span_title"
                        >{{ trans("tests.start_at") }}:</span
                    >
                    <span>{{ session.start_at }}</span>
                </div>
                <div>
                    <span class="span_title">{{ trans("tests.end_at") }}:</span>
                    <span>{{ session.end_at }}</span>
                </div>
                <div>
                    <span class="span_title"
                        >{{ trans("tests.invitation_number") }}:</span
                    >
                    <span>{{ session.invitations_count }}</span>
                </div>
                <div>
                    <span class="span_title"
                        >{{ trans("tests.accepted_invitations_number") }}:</span
                    >
                    <span
                        >{{ session.accepted_invitations_count }} /
                        {{ session.invitations_count }}
                    </span>
                </div>
                <div v-if="showParticipationInfo">
                    <span class="span_title"
                        >{{ trans("tests.participated_number") }}:</span
                    >
                    <span>
                        {{ session.user_test_attempts_count }} /
                        {{ session.accepted_invitations_count }}
                    </span>
                </div>
            </div>
            <div class="extra">
                <div class="ui right floated">
                    <btn
                        :text="trans('tests.edit')"
                        :bgColor="'#00b16e'"
                        :textColor="'white'"
                        :cls="'acc btn'"
                        :font_Weight="'600'"
                        @click="getOneSession"
                    />
                    <btn
                        :text="trans('tests.delete')"
                        :bgColor="'#ff4242'"
                        :textColor="'white'"
                        :cls="'rej btn'"
                        :font_Weight="'600'"
                        @click="deleteSession"
                    />
                </div>
            </div>
            <label-component
                :cls="'ui top right attached label'"
                :text="trans('tests.upcoming')"
                :font_size="'15px'"
                :bgColor="'#ff8b5b'"
                :textColor="'white'"
                :btn_width="'118px'"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import btn from "../tests-components/btn.vue";
import labelComponent from "../tests-components/label-component.vue";
export default {
    name: "session-card",

    components: { labelComponent, btn },

    props: ["switchScreen", "session", "fetchSession"],

    emits: ["getTheSession", "loading"],

    data() {
        return {
            isLoading: false,
        };
    },

    computed: {
        showParticipationInfo() {
            const today = new Date();
            const endAtDate = new Date(this.session.end_at);
            return endAtDate < today;
        },
    },

    methods: {
        trans(key) {
            return trans(key);
        },
        updateLoading() {
            this.$emit("loading", this.isLoading);
        },
        async deleteSession() {
            swal.fire({
                title: trans("common.are_you_sure"),
                text: trans("common.revert_back_is_impossible"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4481eb",
                cancelButtonColor: "#d33",
                confirmButtonText: trans("common.confirm"),
                cancelButtonText: trans("common.cancel"),
            }).then((result) => {
                if (result.isConfirmed) {
                    this.isLoading = true;
                    this.updateLoading();

                    axios
                        .delete(`/api/testsSession/${this.session.id}`)
                        .then((response) => {
                            this.event_types_list = response.data.data;

                            return new Promise((res) => {
                                setTimeout(() => {
                                    this.fetchSession();
                                    this.isLoading = false;
                                    this.updateLoading();
                                    res();
                                }, 500);
                            });
                        })
                        .then(() => {
                            toast.fire({
                                icon: "success",
                                title: trans("common.delete"),
                                timer: 2000,
                            });
                        })
                        .catch((error) => {
                            this.isLoading = false;
                            handleLaravelAxiosErrorResponse(error);
                        });
                }
            });
        },

        async getOneSession() {
            const { data } = await axios.get(
                `/api/testsSession/${this.session.id}`
            );

            this.switchScreen("edit");
            this.$emit("getTheSession", data.session);
        },
    },
};
</script>

<style scoped>
.item_container {
    background-color: white !important;
    width: 100% !important;
    border: 1px solid transparent !important;
    cursor: pointer;
    padding: 20px 10px 10px 20px !important;
    position: relative;
}
.item_container:hover {
    border: 1px solid var(--project-primary-color) !important;
}

.header {
    font-size: 25px !important;
}

.TestSession_img {
    width: 200px !important;
    object-fit: cover;
}

.content {
    margin-left: 30px !important;
}

.description span {
    font-size: 15px !important;
}
.description div {
    margin: 10px 0;
}
.span_title {
    margin-right: 10px !important;
    font-size: 16px !important;
    font-weight: bold;
}

.btn {
    width: 80px;
    margin-right: 10px !important;
    border: none;
    margin-top: 10px;
}

.rej:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid #ff4242;
    color: black !important;
}
.acc:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}
</style>
