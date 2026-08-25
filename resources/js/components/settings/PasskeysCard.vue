<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { usePasskeyRegister } from '@laravel/passkeys/vue';
import { useToast } from '@nuxt/ui/runtime/composables/useToast.js';
import { ref } from 'vue';
import { destroy as destroyPasskey } from '@/actions/Laravel/Passkeys/Http/Controllers/PasskeyRegistrationController';
import { useConfirmPassword } from '@/composables/useConfirmPassword';

defineProps<{
    passkeys: App.Data.PasskeyData[];
}>();

const toast = useToast();
const { ensurePasswordConfirmed } = useConfirmPassword();

const name = ref('');
const adding = ref(false);

const { register, isLoading, isSupported } = usePasskeyRegister({
    onSuccess: () => {
        name.value = '';
        adding.value = false;
        router.reload({ only: ['passkeys'] });
        toast.add({ title: 'Passkey aggiunta', icon: 'i-lucide-circle-check', color: 'success' });
    },
    onError: (error) => {
        toast.add({ title: 'Passkey non aggiunta', description: error.message, color: 'error' });
    },
});

async function startRegistration(): Promise<void> {
    if (!(await ensurePasswordConfirmed())) {
        return;
    }

    await register(name.value.trim() || 'Questo dispositivo');
}

async function remove(passkey: App.Data.PasskeyData): Promise<void> {
    if (!(await ensurePasswordConfirmed())) {
        return;
    }

    router.delete(destroyPasskey.url(passkey.id), {
        preserveScroll: true,
        onSuccess: () => toast.add({ title: 'Passkey rimossa', icon: 'i-lucide-trash-2', color: 'success' }),
    });
}

function formatDate(value: string | null): string {
    return value ? new Date(value).toLocaleDateString('it-IT', { dateStyle: 'medium' }) : 'mai';
}
</script>

<template>
    <UPageCard
        icon="i-lucide-fingerprint"
        title="Passkey"
        description="Accedi con Face ID, Touch ID o una chiave di sicurezza, senza password."
        variant="subtle"
        :ui="{ container: 'gap-4' }"
    >
        <UAlert
            v-if="!isSupported"
            color="warning"
            variant="subtle"
            icon="i-lucide-triangle-alert"
            title="Questo browser non supporta le passkey."
        />

        <ul v-if="passkeys.length" class="divide-y divide-default rounded-lg ring ring-default">
            <li v-for="passkey in passkeys" :key="passkey.id" class="flex items-center gap-3 p-3">
                <UIcon name="i-lucide-key-round" class="size-5 shrink-0 text-muted" />

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium">{{ passkey.name }}</p>
                    <p class="text-xs text-muted">
                        {{ passkey.authenticator ?? 'Autenticatore sconosciuto' }} · ultimo utilizzo:
                        {{ formatDate(passkey.last_used_at) }}
                    </p>
                </div>

                <UButton
                    icon="i-lucide-trash-2"
                    color="error"
                    variant="ghost"
                    aria-label="Rimuovi passkey"
                    @click="remove(passkey)"
                />
            </li>
        </ul>

        <p v-else class="text-sm text-muted">Non hai ancora registrato nessuna passkey.</p>

        <form v-if="adding" class="flex items-start gap-2" @submit.prevent="startRegistration">
            <UInput
                v-model="name"
                placeholder="Nome del dispositivo (es. MacBook Pro)"
                icon="i-lucide-laptop"
                autofocus
                class="flex-1"
            />

            <UButton type="submit" label="Registra" :loading="isLoading" />
            <UButton label="Annulla" color="neutral" variant="ghost" @click="adding = false" />
        </form>

        <div v-else>
            <UButton
                label="Aggiungi passkey"
                icon="i-lucide-plus"
                color="neutral"
                variant="outline"
                :disabled="!isSupported"
                @click="adding = true"
            />
        </div>
    </UPageCard>
</template>
