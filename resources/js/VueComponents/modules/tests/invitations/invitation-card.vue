<template>
    <div
        :class="[
            viewName === 'bars'
                ? 'all_container'
                : 'fluid card fluid_container',
        ]"
    >
        <div class="item">
            <div class="ui grid stackable decription_container">
                <div :class="[viewName === 'bars' ? '' : 'image']">
                    <img
                        :src="invit.test_session.test.thumbnail"
                        alt=""
                        class="test_img"
                    />
                </div>
                <div :class="[viewName === 'bars' ? '' : 'content']">
                    <h2 class="header">{{ invit.test_session.test.title }}</h2>
                    <div :class="[viewName === 'bars' ? '' : 'meta']">
                        <div class="desc">
                            <p>{{ trans("tests.Passing Date") }}:</p>
                            <span>{{ invit.test_session.start_at }}</span>
                        </div>
                        <div class="desc">
                            <p>{{ trans("tests.Miniumum Score") }}:</p>
                            <span
                                >{{
                                    invit.test_session.test.passing_score
                                }}pt</span
                            >
                        </div>
                        <div class="desc" v-show="invit.status !== 'Pending'">
                            <p>
                                {{
                                    invit.status === "Accepted"
                                        ? trans("tests.accepted_at")
                                        : trans("tests.declined_at")
                                }}:
                            </p>
                            <span>{{ invit?.treated_at }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <label-component
                :cls="'ui top right attached label'"
                :text="invit.status"
                :font_size="'15px'"
                :bgColor="[
                    invit.status === 'Declined'
                        ? '#ff4242'
                        : invit.status === 'Accepted'
                        ? 'var(--project-primary-color)'
                        : '#ff8b5b',
                ]"
                :textColor="'white'"
                :btn_width="'95px'"
            />
        </div>

        <div v-show="tabName === 'Participated'" class="btns">
            <btn
                :text="trans('common.rejected')"
                :bgColor="'#ff4242'"
                :textColor="'white'"
                :cls="'rej btn'"
                :font_Weight="'600'"
                @click="updateStatus('DECLINED')"
            />
            <btn
                :text="trans('common.accepted')"
                :bgColor="'#00b16e'"
                :textColor="'white'"
                :cls="'acc btn'"
                :font_Weight="'600'"
                @click="updateStatus('ACCEPTED')"
            />
        </div>
        <div v-show="tabName !== 'Participated'" class="btns">
            <btn
                :text="trans('tests.delete')"
                :bgColor="'#ff4242'"
                :textColor="'white'"
                :cls="'rej btn'"
                :font_Weight="'600'"
                @click="deleteInvitation"
            />
            <btn
                v-if="invit.status === 'Pending'"
                :text="trans('tests.resend')"
                :bgColor="'#135d70'"
                :textColor="'white'"
                :cls="'res btn'"
                :font_Weight="'600'"
                @click="resendEmail"
            />
            <div class="modal">
                <modal-component
                    :emails="invit.email"
                    :title="invit?.test_session?.test?.title"
                />
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import btn from "../tests-components/btn.vue";
import LabelComponent from "../tests-components/label-component.vue";
import ModalComponent from "../tests-components/modal-component.vue";
export default {
    components: { btn, LabelComponent, ModalComponent },

    name: "invitation-card",

    props: ["tabName", "invit", "viewName", "fetchInvit"],

    emits: ["loading"],

    data() {
        return {
            isLoading: false,
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },
        updateLoading() {
            this.$emit("loading", this.isLoading);
        },
        async updateStatus(status) {
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
                        .put(`/api/tests/invitations/${this.invit.id}`, {
                            status: status,
                        })
                        .then((response) => {
                            this.event_types_list = response.data.data;

                            return new Promise((resolve) => {
                                setTimeout(() => {
                                    this.fetchInvit();
                                    this.isLoading = false;
                                    this.updateLoading();
                                    resolve();
                                }, 1000);
                            });
                        })
                        .then(() => {
                            toast.fire({
                                icon: "success",
                                title: trans("common.status"),
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

        async deleteInvitation() {
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
                        .delete(`/api/tests/invitations/${this.invit.id}`)
                        .then((response) => {
                            this.event_types_list = response.data.data;

                            return new Promise((resolve) => {
                                setTimeout(() => {
                                    this.fetchInvit();
                                    this.isLoading = false;
                                    this.updateLoading();
                                    resolve();
                                }, 1000);
                            });
                        })
                        .then(() => {
                            toast.fire({
                                icon: "success",
                                title: trans("tests.deleteInvit"),
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

        async resendEmail() {
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
                        .post(`/api/tests/invitations/${this.invit.id}`)
                        .then((response) => {
                            this.event_types_list = response.data.data;

                            return new Promise((resolve) => {
                                setTimeout(() => {
                                    this.isLoading = false;
                                    this.updateLoading();
                                    resolve();
                                }, 1000);
                            });
                        })
                        .then(() => {
                            toast.fire({
                                icon: "success",
                                title: trans("tests.resendEmail"),
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
    },
};
</script>

<style scoped>
.modal {
    display: inline-block;
}
.image {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.image img {
    object-fit: cover;
    margin: 15px 0;
}
.content {
    text-align: center;
    width: 100%;
}

.fluid_container {
    margin-bottom: 30px !important;
    padding: 10px !important;
    border: 1px solid transparent !important;
    cursor: pointer;
}

.fluid_container:hover {
    border: 1px solid var(--project-primary-color) !important;
}
.all_container {
    margin: 20px 0;
    background-color: white !important;
    width: 100%;
    max-width: 100%;
    position: relative;
    border: 1px solid transparent;
    cursor: pointer;
    padding-bottom: 20px;
}
.all_container:hover {
    border: 1px solid var(--project-primary-color);
}

.decription_container {
    display: flex;
    padding: 30px 10px !important;
}

.desc {
    display: flex;
}

.desc p {
    margin: 4px 0;
    margin-right: 5px;
    font-weight: 600 !important;
    font-size: 16px;
    color: black !important;
}

.test_img {
    width: 200px;
    object-fit: cover;
}

span {
    margin: 4px 0;
    font-weight: 500;
    font-size: 16px;
    color: black !important;
}
.btns {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
.btn {
    min-width: 80px;
    margin-right: 10px !important;
    border: none;
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
.res {
    min-width: 100px;
}
.res:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid #135d70;
    color: black !important;
}
</style>
