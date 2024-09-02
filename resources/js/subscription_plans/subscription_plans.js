import { createApp } from "vue";
import SubscriptionPlans from "../VueComponents/subscription_plans/subscription_plans.vue";
import PrimeVue from "primevue/config";

$(function () {
    const app = createApp({})
        .component("subscription_plans", SubscriptionPlans)
        .use(PrimeVue)
        .mount("#subscription_plans");
});
