import { createApp } from "vue";
import AccessCode from "../VueComponents/access_code/access-code.vue";
import PrimeVue from "primevue/config";

$(function () {
    const app = createApp({})
        .component("access-code", AccessCode)
        .use(PrimeVue)
        .mount("#access-code");
});
