import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy/dist/vue.m';
import { createPinia } from 'pinia';
import ToastPlugin from "vue-toast-notification";
import 'vue-toast-notification/dist/theme-bootstrap.css';

const appName = import.meta.env.VITE_APP_NAME || 'FoodforThought';
const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(ToastPlugin)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
