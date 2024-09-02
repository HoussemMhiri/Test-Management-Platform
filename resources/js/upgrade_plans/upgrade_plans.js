import { createApp } from "vue";
import UpgradePlans from "../VueComponents/upgrade_plans/upgrade_plans.vue";
import PrimeVue from "primevue/config";

$(function () {
    const app = createApp({})
        .component("upgrade_plans", UpgradePlans)
        .use(PrimeVue)
        .mount("#upgrade_plans");
});
