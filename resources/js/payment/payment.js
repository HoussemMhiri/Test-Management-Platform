import { createApp } from "vue";
import Payment from "../VueComponents/payment/payment.vue";
import PrimeVue from "primevue/config";

$(function () {
    const app = createApp({})
        .component("payment", Payment)
        .use(PrimeVue)
        .mount("#payment");
});
