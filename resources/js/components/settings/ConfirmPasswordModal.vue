<script setup lang="ts">
import { useHttp } from '@inertiajs/vue3';
import { store as confirmPassword } from '@/actions/Laravel/Fortify/Http/Controllers/ConfirmablePasswordController';

const emit = defineEmits<{ close: [boolean] }>();

const form = useHttp({ password: '' });

async function submit(): Promise<void> {
    await form
        .post(confirmPassword.url(), {
            onSuccess: () => emit('close', true),
        })
        .catch(() => null);
}
</script>

<template>
    <UModal
        title="Conferma la password"
        description="Per la tua sicurezza, conferma la password prima di modificare queste impostazioni."
        :dismissible="false"
        :close="{ onClick: () => emit('close', false) }"
    >
        <template #body>
            <form id="confirm-password-form" @submit.prevent="submit">
                <UFormField label="Password" :error="form.errors.password">
                    <UInput
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        icon="i-lucide-lock"
                        placeholder="La tua password attuale"
                        autofocus
                        class="w-full"
                    />
                </UFormField>
            </form>
        </template>

        <template #footer>
            <div class="flex w-full justify-end gap-2">
                <UButton label="Annulla" color="neutral" variant="ghost" @click="emit('close', false)" />
                <UButton label="Conferma" type="submit" form="confirm-password-form" :loading="form.processing" />
            </div>
        </template>
    </UModal>
</template>
