<template>
    <div class="tabs">
        <btn
            :icon="'pi pi-bars'"
            :bgColor="'white'"
            :textColor="'var(--project-primary-color)'"
            :btn_width="'50px'"
            :btn_border="'1px solid var(--project-primary-color)'"
            :cls="{ activeMenu: activeTab === 'bars' && !isInvitActive }"
            @click="changeTab('bars')"
        />
        <btn
            :icon="'pi pi-microsoft'"
            :bgColor="'white'"
            :textColor="'var(--project-primary-color)'"
            :btn_width="'50px'"
            :btn_border="'1px solid var(--project-primary-color)'"
            :cls="{ activeMenu: activeTab === 'micro' && !isInvitActive }"
            @click="changeTab('micro')"
        />
    </div>
</template>

<script>
import btn from "./btn.vue";
export default {
    name: "view-mode",

    components: { btn },

    emits: ["toggleTab"],

    props: ["isInvitActive"],

    data() {
        return {
            activeTab: "bars",
        };
    },

    methods: {
        changeTab(name) {
            this.activeTab = name;
            this.emitTab();
        },

        emitTab() {
            this.$emit("toggleTab", this.activeTab);
        },
    },

    created() {
        this.emitTab();
    },
};
</script>

<style scoped>
.tabs {
    display: flex;
    justify-content: space-between;
    width: 135px;
}

.activeMenu {
    background-color: var(--project-primary-color) !important;
    color: white !important;
    pointer-events: none;
}
</style>
