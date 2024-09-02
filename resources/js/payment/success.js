import { createApp } from "vue";
import Success from "../VueComponents/payment/success.vue";
import PrimeVue from "primevue/config";

$(function () {
    const app = createApp({})
        .component("success", Success)
        .use(PrimeVue)
        .mount("#success");
});
