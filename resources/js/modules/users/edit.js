import { createApp } from "vue";
import UsersForm from "../../VueComponents/modules/users/users-form.vue";
import PrimeVue from "primevue/config";

$(function () {
    const app = createApp({})
        .component("users-form", UsersForm)
        .use(PrimeVue)
        .mount("#users-form");
});
