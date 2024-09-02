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
                        :text="trans('subscription_plans.add')"
                        :textColor="'white'"
                        :bgColor="'#00b16e'"
                        :font_Weight="600"
                        @click="switchScreen('add')"
                    />
                    <btn
                        v-if="screen"
                        :cls="'btn'"
                        :text="trans('subscription_plans.plans')"
                        :textColor="'white'"
                        :bgColor="'#00b16e'"
                        :font_Weight="600"
                        @click="screen = ''"
                    />
                </div>
            </div>
        </div>

        <div
            v-if="!screen"
            :class="[
                plans ? 'ui items' : 'ui active centered medium loader green',
            ]"
        >
            <plan-card
                v-for="plan in plans?.data"
                :key="plan.id"
                :plan="plan"
                :switchScreen="switchScreen"
                @getThePlan="getSubPlan"
                @loading="changeLoading"
                :fetchAllPlans="allSubscriptionPlans"
            />
        </div>

        <div v-else>
            <add_plan
                :screenName="screen"
                :onePlan="onePlan"
                @changeScreen="TestScreen"
            />
        </div>

        <div
            v-if="plans?.data?.length === 0 && !screen"
            class="notFound_contaienr"
        >
            <not-found
                :title="trans('subscription_plans.no_plan')"
                :img="'/images/modules/tests/tests-components/not-found.jpg'"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import NotFound from "../modules/tests/tests-components/not-found.vue";
import Btn from "../modules/tests/tests-components/btn.vue";
import Add_plan from "./add_plan.vue";
import PlanCard from "./plan-card.vue";

export default {
    components: {
        Btn,
        NotFound,
        Add_plan,
        PlanCard,
    },

    name: "tests-session-index",

    data() {
        return {
            screen: "",
            onePlan: "",
            isLoading: "",
            plans: "",
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },
        TestScreen() {
            this.screen = "";
        },
        changeLoading(loading) {
            this.isLoading = loading;
        },
        switchScreen(name) {
            this.screen = name;
        },
        getSubPlan(data) {
            this.onePlan = data;
        },

        async allSubscriptionPlans() {
            const { data } = await axios.get("/api/plans/fetch");
            console.log(data);
            this.plans = data;
        },
    },

    mounted() {
        this.allSubscriptionPlans();
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
