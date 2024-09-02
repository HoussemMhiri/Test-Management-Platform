<template>
    <div class="all_container">
        <div v-if="isLoading" class="loading-overlay">
            <div class="ui active centered medium loader green theLoad"></div>
        </div>

        <div class="ui stackable grid search_tabs">
            <div class="ui grid row">
                <div class="ui grid btn_tabs">
                    <btn
                        :text="trans('tests.send_invitation')"
                        :bgColor="'white'"
                        :textColor="'black'"
                        :font_Weight="'600'"
                        :btn_border="'1px solid #135d70'"
                        :cls="[invitation ? 'activeInvit' : 'invit']"
                        @click="invitActive"
                    />
                    <tabs
                        @menuName="selectMenu"
                        class="mr-5"
                        @click="invitation = false"
                        :isInvitActive="invitation"
                    />
                    <view-mode
                        v-if="!invitation"
                        @toggleTab="viewTab"
                        @click="invitation = false"
                        :isInvitActive="invitation"
                    />
                </div>
                <div class="three wide column">
                    <search-input
                        v-if="!invitation"
                        @searchFilter="filterSearch"
                    />
                </div>
            </div>
        </div>

        <div v-if="!TestInvitations && !invitation">
            <div class="ui active centered medium loader green"></div>
        </div>
        <div v-else>
            <div
                v-if="TestInvitations?.data?.data?.length === 0 && !invitation"
                class="notFound_contaienr"
            >
                <not-found :title="trans('tests.invit_notFound')" />
            </div>
            <div
                v-else-if="!invitation"
                :class="[
                    viewMode === 'bars'
                        ? 'ui items'
                        : 'ui stackable three cards',
                ]"
            >
                <invitation-card
                    v-for="invit in TestInvitations.data.data"
                    :key="invit.id"
                    :invit="invit"
                    :tabName="selectedMenu"
                    :viewName="viewMode"
                    :fetchInvit="fetchTestInvitations"
                    @loading="changeLoading"
                />
            </div>

            <div v-else>
                <send-invitation
                    @changeInvitBoolean="trueInvit"
                    :fetchTestInvitations="fetchTestInvitations"
                />
            </div>

            <div>
                <paginate-component
                    v-if="TestInvitations?.data?.data.length > 0 && !invitation"
                    :sessions="TestInvitations.data"
                    @pageChange="fetchTestInvitations"
                />
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import InvitationCard from "./invitations/invitation-card.vue";
import btn from "./tests-components/btn.vue";
import SearchInput from "./tests-components/search-input.vue";
import SendInvitation from "./tests-components/send-invitation.vue";
import tabs from "./tests-components/tabs.vue";
import ViewMode from "./tests-components/view-mode.vue";
import NotFound from "./tests-components/not-found.vue";
import PaginateComponent from "./tests-components/paginate-component.vue";
export default {
    name: "tests-invitations-index",

    components: {
        tabs,
        SearchInput,
        InvitationCard,
        btn,
        ViewMode,
        SendInvitation,
        NotFound,
        PaginateComponent,
    },

    data() {
        return {
            selectedMenu: "",
            viewMode: "",
            invitation: false,
            TestInvitations: "",
            query: "",
            isLoading: "",
        };
    },
    methods: {
        trans(key) {
            return trans(key);
        },

        trueInvit(bol) {
            this.invitation = bol;
        },
        changeLoading(loading) {
            this.isLoading = loading;
        },
        selectMenu(e) {
            this.selectedMenu = e;
        },
        filterSearch(q) {
            this.query = q;
        },

        viewTab(e) {
            this.viewMode = e;
        },

        invitActive() {
            this.invitation = true;
        },

        async fetchTestInvitations(e = { page: 0, rows: 0 }) {
            try {
                const { data } = await axios.get(
                    `/api/tests/invitations/fetch`,
                    {
                        params: {
                            q: this.query,
                            page: e.page + 1,
                            perPage: e.rows || 10,
                        },
                    }
                );

                this.TestInvitations = data;
                console.log(this.TestInvitations);
            } catch (error) {
                console.log(error);
            }
        },
    },

    watch: {
        query: {
            handler: "fetchTestInvitations",
        },
    },

    mounted() {
        this.fetchTestInvitations();
    },
};
</script>

<style scoped>
.search_tabs {
    display: flex;
    justify-content: space-between;
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

.notFound_contaienr {
    margin-top: 30px;
}
.cards {
    margin-top: 20px !important;
}
.btn_tabs {
    margin-left: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mr-5 {
    margin-right: 3rem;
}

.invit {
    letter-spacing: 0.3px;
    margin-right: 8px;
}

.activeInvit {
    background-color: #135d70 !important;
    color: white !important;
    pointer-events: none;
}
</style>
