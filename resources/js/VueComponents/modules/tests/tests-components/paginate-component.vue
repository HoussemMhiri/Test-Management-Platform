<template>
    <div class="card paginator-wrapper">
        <div class="paginator-left">
            {{ trans("tests.element") }}:
            {{ sessions.per_page }}
        </div>
        <Paginator
            :rows="sessions.per_page"
            :totalRecords="sessions.total"
            :rowsPerPageOptions="[10, 20, 30]"
            @page="handlePageChange"
        ></Paginator>
        <div class="paginator-right">
            {{ sessions.to }} {{ trans("tests.of") }} {{ sessions.total }}
            {{ trans("tests.elements") }}
        </div>
    </div>
</template>

<script>
import Paginator from "primevue/paginator";

export default {
    name: "paginate-component",

    components: { Paginator },

    props: ["sessions"],

    emits: ["pageChange"],
    methods: {
        trans(key) {
            return trans(key);
        },
        handlePageChange(e) {
            this.$emit("pageChange", e);
        },
    },
};
</script>

<style>
.paginator-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: white;
}

.paginator-left,
.paginator-right {
    padding: 10px;
    color: gray;
}

.paginator-left {
    margin-right: 10px;
}

.paginator-right {
    margin-left: 10px;
}
.card .p-paginator .p-paginator-page.p-highlight {
    background-color: var(--project-primary-color) !important;
    border-color: var(--project-primary-color) !important;
    color: white !important;
}

.card .p-paginator .p-paginator-page:hover {
    background-color: var(--project-primary-color-hover) !important;
    color: white !important;
}
.card .p-paginator .p-paginator-page:focus {
    box-shadow: none !important;
}

.card .p-dropdown:hover {
    border-color: var(--project-primary-color) !important;
}
</style>
