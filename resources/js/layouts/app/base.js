import { createApp } from "vue";
import PrimeVue from "primevue/config";
import OverlayPanel from 'primevue/overlaypanel';
import AppNavBar from "../../VueComponents/layouts/app/app-nav-bar";
import 'primevue/resources/themes/saga-blue/theme.css' //theme
import 'primevue/resources/primevue.min.css' //core css
import 'primeicons/primeicons.css'

$(function(){
    const nav_bar = createApp({})
        .component("app-nav-bar", AppNavBar)
        .component('OverlayPanel', OverlayPanel)
        .use(PrimeVue)
        .mount("#app-nav-bar");
})
