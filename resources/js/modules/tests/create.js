import { createApp } from "vue";
import TestForm from "../../VueComponents/modules/tests/test-form.vue";
import PrimeVue from "primevue/config";
import ToastService from 'primevue/toastservice';
import router from '../../router';


$(function(){
    const app = createApp({
        components: {
            TestForm
        }
    });

    app.use(PrimeVue);
    app.use(ToastService);
    app.use(router);
    app.mount("#test-form");
});
