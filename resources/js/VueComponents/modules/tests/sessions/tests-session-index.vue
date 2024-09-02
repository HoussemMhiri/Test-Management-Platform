<template>
    <div class="all_container">
        <div v-if="isLoading" class="loading-overlay">
            <div class="ui active centered medium loader green theLoad"></div>
        </div>
        <div>
            <div class="ui stackable grid">
                <div class="eight wide column">
                    <btn
                        v-if="!screen"
                        :cls="'btn'"
                        :text="trans('tests.add_session')"
                        :textColor="'white'"
                        :bgColor="'#00b16e'"
                        :font_Weight="600"
                        @click="switchScreen('add')"
                    />
                    <btn
                        v-if="screen"
                        :cls="'btn'"
                        :text="trans('tests.sessions')"
                        :textColor="'white'"
                        :bgColor="'#00b16e'"
                        :font_Weight="600"
                        @click="screen = ''"
                    />
                </div>
                <div class="eight wide column search">
                    <search-input v-if="!screen" @searchFilter="filterSearch" />
                </div>
            </div>
        </div>

        <div
            v-if="!screen"
            :class="[
                sessions
                    ? 'ui items'
                    : 'ui active centered medium loader green',
            ]"
        >
            <session-card
                v-for="session in sessions?.data"
                :key="session.id"
                :switchScreen="switchScreen"
                :session="session"
                @getTheSession="getTestSession"
                :fetchSession="fetchAllTestsSession"
                @loading="changeLoading"
            />

            <paginate-component
                v-if="sessions?.data.length > 0"
                :sessions="sessions"
                @pageChange="fetchAllTestsSession"
            />
        </div>

        <div v-else class="ui container session_container">
            <tests-session-form
                :screenName="screen"
                :oneSession="oneSession"
                @changeScreen="TestScreen"
                :fetchAllTestsSession="fetchAllTestsSession"
            />
        </div>

        <div
            v-if="sessions?.data?.length === 0 && !screen"
            class="notFound_contaienr"
        >
            <not-found
                :title="trans('tests.emptySession')"
                :img="'/images/modules/tests/tests-components/not-found.jpg'"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Btn from "../tests-components/btn.vue";
import SearchInput from "../tests-components/search-input.vue";
import sessionCard from "./session-card.vue";
import TestsSessionForm from "./tests-session-form.vue";
import PaginateComponent from "../tests-components/paginate-component.vue";
import NotFound from "../tests-components/not-found.vue";
export default {
    components: {
        sessionCard,
        SearchInput,
        Btn,
        TestsSessionForm,
        PaginateComponent,
        NotFound,
    },

    name: "tests-session-index",

    data() {
        return {
            screen: "",

            sessions: null,
            oneSession: null,
            query: "",
            isLoading: "",
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },
        TestScreen() {
            this.screen = "";
        },
        filterSearch(q) {
            this.query = q;
        },
        changeLoading(loading) {
            this.isLoading = loading;
        },
        switchScreen(name) {
            this.screen = name;
        },
        getTestSession(data) {
            this.oneSession = data;
        },

        async fetchAllTestsSession(e = { page: 0, rows: 0 }) {
            try {
                const { data } = await axios.get(`/api/testsSession/fetch`, {
                    params: {
                        q: this.query,
                        page: e.page + 1,
                        perPage: e.rows || 10,
                    },
                });
                this.sessions = data.sessions;
                console.log(this.sessions);
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
        query: {
            handler: "fetchAllTestsSession",
        },
    },

    mounted() {
        this.fetchAllTestsSession();
    },
};
</script>

<style scoped>
.items {
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
    margin-top: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.session_container {
    width: 100% !important;
}
.btn {
    width: 120px;
    letter-spacing: 0.8px !important;
    transition: all 0.2s ease-in-out;
    margin-right: 10px;
}
.btn:hover {
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}
</style>
