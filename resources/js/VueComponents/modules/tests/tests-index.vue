<template>
    <div class="right_content">
        <div class="ui stackable grid">
            <div class="eight wide column">
                <a href="tests/create">
                    <btn
                        :text="trans('app-side.create_new_test')"
                        :textColor="'white'"
                        :bgColor="'#00b16e'"
                        :font_Weight="600"
                        :cls="'btn'"
                    />
                </a>
            </div>
            <div class="eight wide column search">
                <search-input @searchFilter="filterTestSearch" />
            </div>
        </div>

        <div
            :class="[
                allTests
                    ? 'ui stackable four cards cards_container'
                    : 'ui active centered medium loader green',
            ]"
        >
            <TestCard
                v-for="test in allTests.data"
                :key="test.id"
                :test="test"
            />
        </div>
        <div v-if="allTests?.data?.length > 0" class="pagination_container">
            <paginate-component
                :sessions="allTests"
                @pageChange="fetchAllTests"
            />
        </div>

        <div v-if="allTests?.data?.length === 0" class="notFound_contaienr">
            <not-found
                :title="trans('tests.emptyTests')"
                :img="'/images/modules/tests/tests-components/not-found.jpg'"
            />
        </div>
    </div>
</template>

<script>
import TestCard from "./test-card/test-card.vue";
import SearchInput from "./tests-components/search-input.vue";
import Dropdown from "primevue/dropdown";
import Btn from "./tests-components/btn.vue";
import PaginateComponent from "./tests-components/paginate-component.vue";
import NotFound from "./tests-components/not-found.vue";

export default {
    name: "tests-index",

    components: {
        TestCard,
        SearchInput,
        Dropdown,
        Btn,
        PaginateComponent,
        NotFound,
    },

    data() {
        return {
            allTests: "",
            query: "",
        };
    },

    methods: {
        filterTestSearch(q) {
            this.query = q;
        },
        async fetchAllTests(e = { page: 0, rows: 0 }) {
            const { data } = await axios.get(`/api/tests/fetch`, {
                params: {
                    q: this.query,
                    page: e.page + 1,
                    perPage: e.rows || 10,
                },
            });

            this.allTests = data.tests;
            console.log(this.allTests);
        },

        trans(key) {
            return trans(key);
        },
    },

    watch: {
        query: {
            handler: "fetchAllTests",
        },
    },

    mounted() {
        this.fetchAllTests();
    },
};
</script>

<style scoped>
.btn {
    width: 150px;
    letter-spacing: 0.8px !important;
    transition: all 0.2s ease-in-out;
    margin-right: 10px;
}
.btn:hover {
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}
.cards_container {
    padding-top: 30px !important;
}
.right_content {
    background-color: #f5f5f5;
}

.pagination_container {
    margin-top: 20px;
}

.notFound_contaienr {
    margin-top: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
