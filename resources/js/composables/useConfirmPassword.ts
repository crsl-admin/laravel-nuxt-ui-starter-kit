import { useOverlay } from '@nuxt/ui/runtime/composables/useOverlay.js';
import { show as confirmedPasswordStatus } from '@/actions/Laravel/Fortify/Http/Controllers/ConfirmedPasswordStatusController';
import ConfirmPasswordModal from '@/components/settings/ConfirmPasswordModal.vue';

export type UseConfirmPasswordReturn = {
    /**
     * Resolves to true once the session counts as password confirmed, asking
     * the user for their password through a modal only when it is required.
     */
    ensurePasswordConfirmed: () => Promise<boolean>;
};

async function isPasswordConfirmed(): Promise<boolean> {
    const response = await fetch(confirmedPasswordStatus.url(), {
        headers: { Accept: 'application/json' },
    });

    if (!response.ok) {
        return false;
    }

    return (await response.json()).confirmed === true;
}

export function useConfirmPassword(): UseConfirmPasswordReturn {
    const modal = useOverlay().create(ConfirmPasswordModal);

    async function ensurePasswordConfirmed(): Promise<boolean> {
        if (await isPasswordConfirmed()) {
            return true;
        }

        return (await modal.open().result);
    }

    return { ensurePasswordConfirmed };
}
