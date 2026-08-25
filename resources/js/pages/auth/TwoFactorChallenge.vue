<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { store as twoFactorLogin } from '@/actions/Laravel/Fortify/Http/Controllers/TwoFactorAuthenticatedSessionController';
import GuestLayout from '@/layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });

const useRecoveryCode = ref(false);

const form = useForm({ code: [] as number[], recovery_code: '' });

function submit(): void {
    form.transform((data) =>
        useRecoveryCode.value ? { recovery_code: data.recovery_code } : { code: data.code.join('') },
    ).post(twoFactorLogin.url());
}

function toggleMode(): void {
    useRecoveryCode.value = !useRecoveryCode.value;
    form.clearErrors();
    form.reset();
}
</script>

<template>
    <Head title="Verifica in due passaggi" />

    <div class="flex w-full flex-col items-center justify-center gap-4 p-4">
        <UPageCard
            class="w-full max-w-md"
            icon="i-lucide-shield-check"
            title="Verifica in due passaggi"
            :description="
                useRecoveryCode
                    ? 'Inserisci uno dei codici di recupero che hai salvato.'
                    : 'Inserisci il codice a 6 cifre generato dalla tua app di autenticazione.'
            "
        >
            <form class="flex flex-col gap-4" @submit.prevent="submit">
                <UFormField v-if="useRecoveryCode" name="recovery_code" :error="form.errors.recovery_code">
                    <UInput
                        v-model="form.recovery_code"
                        placeholder="Codice di recupero"
                        icon="i-lucide-key-round"
                        autocomplete="one-time-code"
                        autofocus
                        class="w-full font-mono"
                    />
                </UFormField>

                <UFormField v-else name="code" :error="form.errors.code" class="flex justify-center">
                    <UPinInput v-model="form.code" :length="6" otp type="number" autofocus @complete="submit" />
                </UFormField>

                <UButton type="submit" block label="Verifica" :loading="form.processing" />

                <UButton
                    type="button"
                    color="neutral"
                    variant="link"
                    block
                    :label="useRecoveryCode ? 'Usa un codice dell\'app' : 'Usa un codice di recupero'"
                    @click="toggleMode"
                />
            </form>
        </UPageCard>
    </div>
</template>
