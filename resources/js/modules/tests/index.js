import { createApp } from "vue";
import TestsIndex from "../../VueComponents/modules/tests/tests-index.vue";
import PrimeVue from "primevue/config";
import router from '../../router';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import ConfirmDialog from 'primevue/confirmdialog';
import Toast from 'primevue/toast';


$(function () {
    const app = createApp(TestsIndex)
        .use(PrimeVue)
        .use(router)
        .use(ConfirmationService)
        .use(ToastService);

    app.component('ConfirmDialog', ConfirmDialog);
    app.component('Toast', Toast);

    app.mount("#tests-index");
});
