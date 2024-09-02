import { createApp } from "vue";
import TestsInvitationsIndex from "../../../VueComponents/modules/tests/tests-invitations-index.vue";
import PrimeVue from "primevue/config";

$(function () {
    const test_invit = createApp({})
        .use(PrimeVue)
        .component("tests-invitations", TestsInvitationsIndex)
        .mount("#tests-invitations");
});
