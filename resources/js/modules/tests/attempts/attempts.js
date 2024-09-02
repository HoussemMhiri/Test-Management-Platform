import { createApp } from "vue";
import TestsAttemptsIndex from "../../../VueComponents/modules/tests/attempts/tests-attempts-index.vue";
import PrimeVue from "primevue/config";

$(function () {
    const test_attempt = createApp({})
        .component("tests-attempts-index", TestsAttemptsIndex)
        .use(PrimeVue)
        .mount("#tests-attempts");
});
