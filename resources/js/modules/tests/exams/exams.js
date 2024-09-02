import { createApp } from "vue";
import TestsExams from "../../../VueComponents/modules/exams/exam-container.vue";
import PrimeVue from "primevue/config";

$(function(){
    const test_exam = createApp({})
        .component("exam-container", TestsExams)
        .use(PrimeVue)
        .mount("#exam-container");
})


