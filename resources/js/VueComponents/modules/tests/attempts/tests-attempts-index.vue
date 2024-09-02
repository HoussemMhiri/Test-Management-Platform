<template>
    <div class="all_container">
        <div v-if="!testAttempts">
            <div class="ui active centered medium loader green theLoad"></div>
        </div>
        <div class="ui stackable grid search_tabs">
            <div class="ui grid row">
                <div class="ui grid btn_tabs">
                    <tabs class="mr-5" />
                    <view-mode @toggleTab="viewTab" />
                </div>
                <div class="three wide column">
                    <search-input @searchFilter="filterSearch" />
                </div>
            </div>
        </div>
        <div v-if="testAttempts?.data?.length !== 0">
            <div
                :class="[
                    viewMode === 'bars'
                        ? 'ui items'
                        : 'ui stackable three cards',
                ]"
            >
                <attempts-segment
                    v-for="item in testAttempts?.data"
                    :viewName="viewMode"
                    :key="item.id"
                    :item="item"
                />
            </div>
            <div>
                <paginate-component
                    v-if="testAttempts?.data?.length > 0"
                    :sessions="testAttempts"
                    @pageChange="fetchTestsAttempts"
                />
            </div>
        </div>

        <div v-else class="notFound_contaienr">
            <not-found :title="trans('tests.attempt_notFound')" />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import AttemptsSegment from "./attempts-segment.vue";
import Btn from "../tests-components/btn.vue";
import Tabs from "../tests-components/tabs.vue";
import ViewMode from "../tests-components/view-mode.vue";
import SearchInput from "../tests-components/search-input.vue";
import PaginateComponent from "../tests-components/paginate-component.vue";
import NotFound from "../tests-components/not-found.vue";

export default {
    name: "tests-attempts-index",

    components: {
        AttemptsSegment,
        Btn,
        Tabs,
        ViewMode,
        SearchInput,
        PaginateComponent,
        NotFound,
    },

    data() {
        return {
            selectedMenu: "",
            viewMode: "",
            invitation: false,
            query: "",
            testAttempts: "",
            isLoading: "",
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },
        viewTab(e) {
            this.viewMode = e;
        },
        filterSearch(q) {
            this.query = q;
        },

        async fetchTestsAttempts(e = { page: 0, rows: 0 }) {
            const { data } = await axios.get(`/api/tests/attempts/fetch`, {
                params: {
                    q: this.query,
                    page: e.page + 1,
                    perPage: e.rows || 10,
                },
            });
            this.testAttempts = data.data;

            console.log(this.testAttempts);
        },
    },

    watch: {
        query: {
            handler: "fetchTestsAttempts",
        },
    },

    mounted() {
        this.fetchTestsAttempts();
    },
};
</script>

<style scoped>
.search_tabs {
    display: flex;
    justify-content: space-between;
    position: relative;
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

.notFound_contaienr {
    margin-top: 20px;
}
</style>
