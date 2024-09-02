<template>
    <div class="card">
        <div class="tab">
            <btn
                @click="active"
                :cls="'btn'"
                :text="trans('tests.Hosted')"
                :textColor="'black'"
                :bgColor="'white'"
                :font_Weight="600"
                :class="{ active: activeTab === 'Hosted' && !isInvitActive }"
            />
            <btn
                @click="desactive"
                :cls="'btn'"
                :text="trans('tests.Participated')"
                :textColor="'black'"
                :bgColor="'white'"
                :font_Weight="600"
                :class="{
                    active: activeTab === 'Participated' && !isInvitActive,
                }"
            />
        </div>
    </div>
</template>

<script>
import btn from "./btn.vue";
export default {
    components: { btn },

    name: "tabs",

    emits: ["menuName"],

    props: ["isInvitActive"],

    data() {
        return {
            activeTab: "Hosted",
        };
    },
    methods: {
        active() {
            this.activeTab = "Hosted";
            this.activeMenu();
        },
        desactive() {
            this.activeTab = "Participated";
            this.activeMenu();
        },
        activeMenu() {
            this.$emit("menuName", this.activeTab);
        },

        trans(key) {
            return trans(key);
        },
    },
};
</script>

<style scoped>
.tab {
    display: flex;
    width: 120%;
    display: flex;
    justify-content: space-between;
}

.btn {
    flex: 1;
    margin-right: 5px;
    border: 1px solid var(--project-primary-color);
}

.active {
    background-color: var(--project-primary-color) !important;
    color: white !important;
    pointer-events: none;
}
</style>
