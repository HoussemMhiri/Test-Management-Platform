<template>
    <div class="all_container">
        <h1 class="ui center aligned header">
            {{ trans("upgrade_plans.title") }}
        </h1>
        <p class="ui center aligned header parag">
            {{ trans("upgrade_plans.parag") }}.
        </p>
        <div class="ui stackable three column grid">
            <div v-for="plan in allPlans" :key="plan.id" class="column">
                <div
                    class="ui raised segment pricing-card"
                    :class="[plan.is_user_plan ? 'userPlan' : '']"
                >
                    <div
                        :class="[
                            plan.name === 'Basic'
                                ? 'ui teal ribbon label'
                                : plan.name === 'Standard'
                                ? 'ui blue ribbon label'
                                : 'ui red ribbon label',
                        ]"
                    >
                        {{ plan.name }} Plan
                    </div>
                    <h2 class="ui center aligned header">
                        ${{ formatPrice(plan.monthly_price) }}/
                        {{ trans("upgrade_plans.month") }}
                    </h2>
                    <div class="content">
                        <h3 class="ui dividing header">
                            {{ trans("subscription_plans.description") }}
                        </h3>
                        <p>
                            {{ plan.description }}
                        </p>
                        <h3 class="ui dividing header">
                            {{ trans("subscription_plans.features") }}
                        </h3>
                        <ul class="ui list">
                            <li
                                v-for="(feature, i) in getFeaturesArray(
                                    plan.features
                                )"
                                :key="i"
                            >
                                {{ feature }}
                            </li>
                        </ul>
                        <h3 class="ui dividing header">
                            {{ trans("upgrade_plans.price") }}
                        </h3>
                        <ul class="ui list">
                            <li class="item">
                                <span
                                    >{{
                                        trans("subscription_plans.annual")
                                    }}:</span
                                >
                                ${{ formatPrice(plan.annual_price) }}
                            </li>
                            <li class="item">
                                <span
                                    >{{
                                        trans("subscription_plans.individual")
                                    }}:</span
                                >
                                ${{
                                    formatPrice(plan.individual_template_price)
                                }}
                            </li>
                            <li class="item">
                                <span
                                    >{{
                                        trans("subscription_plans.type")
                                    }}:</span
                                >
                                {{ plan.plan_limitation_type }}
                            </li>
                            <li class="item" v-if="plan.max_templates_number">
                                <span
                                    >{{
                                        trans("subscription_plans.max")
                                    }}:</span
                                >
                                {{ plan.max_templates_number }}
                            </li>
                        </ul>
                    </div>
                    <div class="extra content center aligned btn_container">
                        <btn
                            v-if="plan.is_user_plan"
                            :text="trans('upgrade_plans.planBtn')"
                            :bgColor="'white'"
                            :textColor="'black'"
                            :cls="' btn_p'"
                            :font_Weight="'600'"
                        />
                        <a :href="`/payment/${plan.id}`" v-else>
                            <btn
                                :text="trans('upgrade_plans.choosePlan')"
                                :bgColor="'#00b16e'"
                                :textColor="'white'"
                                :cls="'acc btn_c'"
                                :font_Weight="'600'"
                            />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="confirm_btn">
            <a href="/app"
                ><btn
                    :text="trans('accept_invitation.dashboard')"
                    :bgColor="'white'"
                    :textColor="'#00b16e'"
                    :cls="'acc btn_c'"
                    :font_Weight="'600'"
                />
            </a>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Btn from "../modules/tests/tests-components/btn.vue";
export default {
    name: "upgrade_plans",

    components: { Btn },

    data() {
        return {
            allPlans: "",
        };
    },

    methods: {
        trans(key) {
            return trans(key);
        },

        async getAllPlans() {
            const { data } = await axios.get("/api/upgrade_plans/fetch");
            console.log(data);
            this.allPlans = data?.data;
        },

        getFeaturesArray(featuresString) {
            return featuresString.split(",").map((feature) => feature.trim());
        },
        formatPrice(price) {
            const priceNumber = parseFloat(price);

            if (!isNaN(priceNumber)) {
                if (priceNumber % 1 === 0) {
                    return priceNumber.toFixed(0);
                }
                return priceNumber.toFixed(2);
            }
            return price;
        },
    },

    mounted() {
        this.getAllPlans();
    },
};
</script>

<style scoped>
.userPlan {
    border: 2px solid #00b16e !important;
    box-shadow: 0 12px 22px #d9eddf !important;
    transition: all 0.3s ease;
}

.all_container {
    background-color: #3bcd88;
    min-height: 100vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

h1 {
    color: white !important;
    font-size: 40px !important;
}

span {
    font-weight: 600;
}

.parag {
    color: wheat !important;
    letter-spacing: 0.3px;
}

.pricing-card {
    background-color: white !important;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    position: relative;
    font-size: 15px;
    letter-spacing: 0.3px;
    min-height: 637px;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
}

.ui.header {
    margin-bottom: 20px;
}

.ui.ribbon.label {
    margin-bottom: 10px;
    position: absolute;
    top: 10px;
    left: -18px;
    font-size: 15px;
}

.ui.list .item {
    margin-bottom: 5px;
}

.ui.dividing.header {
    margin-top: 20px;
}

.btn_container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: auto;
}

.btn_c {
    width: 150px;
    border: none;
    letter-spacing: 0.6px;
}
.btn_p {
    width: 150px;
    border: 1px solid var(--project-primary-color) !important;
    letter-spacing: 0.6px;
    pointer-events: none;
}
.acc:hover {
    transition: all 0.2s ease;
    background-color: white !important;
    border: 1px solid var(--project-primary-color);
    color: black !important;
}

.confirm_btn {
    margin-top: 30px;
}
</style>
