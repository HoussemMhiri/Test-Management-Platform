import { createApp } from "vue";
import TestsSessionIndex from "../../../VueComponents/modules/tests/sessions/tests-session-index.vue";
import PrimeVue from "primevue/config";

$(function () {
    const test_session = createApp({})
        .use(PrimeVue)
        .component("tests-session-index", TestsSessionIndex)
        .mount("#tests-session");
});
