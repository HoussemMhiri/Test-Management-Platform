import { createApp } from "vue";
import AcceptInvitation from "../VueComponents/accept_invitation/accept_invitation.vue";
import PrimeVue from "primevue/config";

$(function () {
    const app = createApp({})
        .component("accept_invitation", AcceptInvitation)
        .use(PrimeVue)
        .mount("#accept_invitation");
});
