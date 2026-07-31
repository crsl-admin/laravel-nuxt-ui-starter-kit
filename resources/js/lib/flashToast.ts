import { router } from '@inertiajs/vue3';
import { useToast } from '@nuxt/ui/runtime/composables/useToast.js';
import type { FlashToast, ToastColor } from '@/types/ui';

const toast = useToast();

const iconForColor: Record<ToastColor, string> = {
    primary: 'i-lucide-circle',
    secondary: 'i-lucide-circle',
    success: 'i-lucide-circle-check',
    info: 'i-lucide-info',
    warning: 'i-lucide-triangle-alert',
    error: 'i-lucide-circle-x',
    neutral: 'i-lucide-circle',
};

export function initializeFlashToast(): void {
    router.on('flash', (event) => {
        const flash = (event as CustomEvent).detail?.flash;
        const data = flash?.toast as FlashToast | undefined;

        if (!data) {
            return;
        }

        const color = data.color ?? data.type ?? 'success';

        toast.add({
            color,
            title: data.message,
            description: data.body,
            icon: data.icon ?? iconForColor[color],
        })
    });
}
