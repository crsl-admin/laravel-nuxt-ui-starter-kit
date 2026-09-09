import type { App } from 'vue';
import { useAuthorization } from '@/composables/useAuthorization';

export default {
    install(app: App): void {
        app.config.globalProperties.can = (permissions: string | string[]): boolean => {
            const { can } = useAuthorization();

            return can(permissions);
        };
    },
};
