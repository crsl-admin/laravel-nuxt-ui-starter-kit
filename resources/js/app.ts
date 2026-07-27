import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import ui from '@nuxt/ui/vue-plugin';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    progress: {
        color: '#4B5563',
    },
    withApp(app) {
        app.use(ui);
    },
});
