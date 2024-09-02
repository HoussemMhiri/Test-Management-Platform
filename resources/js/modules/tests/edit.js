import { createApp } from "vue";
import PrimeVue from "primevue/config";
import TestForm from "../../VueComponents/modules/tests/test-form.vue";
import router from '../../router';


const app = createApp({})
    .component("test-form", TestForm)
    .use(PrimeVue)
    .use(router)
    .mount("#test-form");
