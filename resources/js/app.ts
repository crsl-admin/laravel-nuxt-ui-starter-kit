import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import ui from '@nuxt/ui/vue-plugin';
import { ZiggyVue } from 'ziggy-js';
import Layout from '@/layouts/AuthLayout.vue';
import { initializeFlashToast } from '@/lib/flashToast';
import { route } from '@/lib/route';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    progress: {
        color: '#4B5563',
    },
    layout: () => Layout,
    withApp(app) {
        app
            .use(ui)
            .use(ZiggyVue)

        // Override Ziggy's global `route` in templates with the relative-by-default wrapper.
        app.config.globalProperties.route = route;
    },
});

initializeFlashToast();
