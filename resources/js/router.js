import { createRouter, createWebHistory } from 'vue-router';
import TestForm from './VueComponents/modules/tests/test-form.vue';
import TestIndex from './VueComponents/modules/tests/tests-index.vue';

const routes = [
    { path: '/tests/create', component: TestForm },
    { path: '/tests', component: TestIndex },
    { path: '/tests/edit/:id', name: 'edit-test', component: TestForm, props: true },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
