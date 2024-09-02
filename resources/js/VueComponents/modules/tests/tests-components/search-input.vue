<template>
    <div class="item">
        <div class="ui icon input">
            <input
                type="text"
                v-model="search"
                :placeholder="trans('common.search')"
                class="search_inp"
                data-sider-insert-id="912d5f91-1310-4fec-a169-f96e163b4788"
                data-sider-select-id="5fecf719-ee52-468a-972f-2b6886c49bf0"
                @input="searchQuery"
            />
            <i class="search link icon"></i>
        </div>
    </div>
</template>

<script>
export default {
    name: "search-input",

    emits: ["searchFilter"],

    data() {
        return {
            search: "",
        };
    },
    methods: {
        trans(key) {
            return trans(key);
        },
        searchQuery() {
            this.$emit("searchFilter", this.search.trim());
        },
    },
};
</script>

<style scoped>
.item {
    text-align: end;
}
.search_inp {
    padding: 0 10px !important;
    height: 38px;
    max-width: 100%;
    width: 214px;
}
.search_inp:focus {
    position: relative;
    border: 1px solid #00b16e !important;
}
</style>
