<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import type { FormSubmitEvent, AuthFormField } from '@nuxt/ui';
import { useToast } from '@nuxt/ui/runtime/composables/useToast.js';
import { store } from '@/actions/Laravel/Fortify/Http/Controllers/AuthenticatedSessionController';
import passwordResetLinkController from '@/actions/Laravel/Fortify/Http/Controllers/PasswordResetLinkController';
import RegisteredUserController from '@/actions/Laravel/Fortify/Http/Controllers/RegisteredUserController';
import GuestLayout from '@/layouts/GuestLayout.vue';

defineProps<{
    canResetPassword: boolean;
    canRegister: boolean;
}>();

const toast = useToast();

const fields: AuthFormField[] = [
    {
        name: 'email',
        type: 'email',
        label: 'Email',
        placeholder: 'Enter your email',
        required: true,
    },
    {
        name: 'password',
        label: 'Password',
        type: 'password',
        placeholder: 'Enter your password',
        required: true,
    },
    {
        name: 'remember',
        label: 'Remember me',
        type: 'checkbox',
    },
];

const providers = [
    {
        label: 'Google',
        icon: 'material-icon-theme:google',
        onClick: () => {
            toast.add({ title: 'Google', description: 'Login with Google' });
        },
    },
    {
        label: 'Microsfot',
        icon: 'logos:microsoft-icon',
        onClick: () => {
            toast.add({ title: 'GitHub', description: 'Login with GitHub' });
        },
    },
];

const form = useForm({
    email: '',
    password: '',
    remember: '',
});

function onSubmit(payload: FormSubmitEvent<any>) {
    form.email = payload.data.email;
    form.password = payload.data.password;
    form.remember = payload.data.remember;

    form.submit(store());
}
</script>

<template>
    <GuestLayout>
        <div class="flex w-full flex-col items-center justify-center gap-4 p-4">
            <UPageCard class="w-full max-w-md">
                <UAuthForm
                    title="Login"
                    icon="i-lucide-user"
                    :fields="fields"
                    :providers="providers"
                    separator="oppure"
                    @submit="onSubmit"
                    :submit="{ label: 'Accedi' }"
                    :loading="form.processing"
                >
                    <template #description v-if="canRegister">
                        Non hai ancora un account?
                        <ULink :to="RegisteredUserController.create().url" class="font-medium text-primary"
                            >Registrati!</ULink
                        >
                    </template>
                    <template #description v-else> Inserisci le tue credenziali per accedere al tuo account </template>

                    <template #validation v-if="form.hasErrors">
                        <UAlert color="error" icon="i-lucide-info" :title="form.errors.email || form.errors.password" />
                    </template>

                    <template #password-hint>
                        <ULink
                            v-if="canResetPassword"
                            :to="passwordResetLinkController.create().url"
                            target="_self"
                            class="font-medium text-primary"
                            tabindex="-1"
                            >Password dimenticata?</ULink
                        >
                    </template>
                </UAuthForm>
            </UPageCard>
        </div>
    </GuestLayout>
</template>
