require("./bootstrap");
// import { createApp } from 'vue'
// import test from './VueComponents/test.vue';

/*=================== PrimeVue3 ===================*/
import PrimeVue from "primevue/config";
import "primevue/resources/themes/saga-blue/theme.css"; //theme
import "primevue/resources/primevue.min.css"; //core css
import "primeicons/primeicons.css";

/* ================================Sweet Alert start */
import swal from "sweetalert2";
window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", swal.stopTimer);
        toast.addEventListener("mouseleave", swal.resumeTimer);
    },
});

window.toast = toast;

// html attribute usage
// swal.bindClickHandler()
// toast.bindClickHandler('data-swal-toast-template')

window.showToast = function (title, text, icon, timer = 3000) {
    toast.fire({
        icon: icon,
        title: title,
        timer: timer,
        text: text,
    });
};

window.showDialog = function (title, text, icon, timer = 3000) {
    swal.fire({
        icon: icon,
        title: title,
        timer: timer,
        text: text,
    });
};

//you can accept callback and use if (result.isConfirmed)
window.DangerConfirmation = function (
    icon = "warning",
    withCancelBtn = true,
    title = "Are you sure?'",
    text = "You won't be able to revert this!",
    confirmButtonText = "confirm",
    cancelButtonText = "cancel"
) {
    return swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: withCancelBtn,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
    });
};

function alertAxiosResponseErrors(errors) {
    //console.log(errors.join('\n'));
    swal.fire({
        title: trans("common.error"),
        html: errors.join("<br>"),
        icon: "error",
        confirmButtonText: trans("errors.understood"),
    });
}

function getAxiosResponseErrorsArray(errors) {
    let flatErrors = [];

    for (let k in errors) {
        for (let index in errors[k]) {
            flatErrors.push(errors[k][index]);
        }
    }
    return flatErrors;
}

window.handleLaravelAxiosErrorResponse = function (error) {
    if (error.response.status == 422) {
        alertAxiosResponseErrors(
            getAxiosResponseErrorsArray(error.response.data.errors)
        );
    }
};

/* ================================LANG start */
import Lang from "lang.js";
import messages from "./messages";

const lang = new Lang({
    messages: messages,
});

lang.setLocale("en");
lang.setFallback("fr");

window.trans = function (key) {
    return lang.get(key);
};
window.trans_choice = function (key, index) {
    return lang.choice(key, index);
};
window.trans_set_locale = function (locale) {
    lang.setLocale(locale);
};
window.trans_get_locale = function (locale) {
    return lang.getLocale();
};
window.trans_set_locale_fallback = function (locale) {
    lang.setFallback(locale);
};
window.trans_get_locale_fallback = function (locale) {
    return lang.getFallback(locale);
};

//command : php artisan lang:js resources/js/messages.js --no-lib

// import Vue from 'vue';

// const app = createApp({})
// app.component('test', test)
// app.use(PrimeVue) //to use primevue
// app.mount('#app')

import { createApp } from "vue";
// import PrimeVue from "primevue/config";
import TestsIndex from "./VueComponents/modules/tests/tests-index";

const app = createApp({})
    .component("tests-index", TestsIndex)
    .use(PrimeVue)
    .mount("#app");
