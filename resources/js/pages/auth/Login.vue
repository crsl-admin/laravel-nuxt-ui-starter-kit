<script setup lang="ts">
import type { FormSubmitEvent, AuthFormField } from '@nuxt/ui';
import { useToast } from '@nuxt/ui/runtime/composables/useToast.js';
import passwordResetLinkController from '@/actions/Laravel/Fortify/Http/Controllers/PasswordResetLinkController';
import GuestLayout from '@/layouts/GuestLayout.vue';

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
        icon: 'i-simple-icons-google',
        onClick: () => {
            toast.add({ title: 'Google', description: 'Login with Google' });
        },
    },
    {
        label: 'GitHub',
        icon: 'i-simple-icons-github',
        onClick: () => {
            toast.add({ title: 'GitHub', description: 'Login with GitHub' });
        },
    },
];

/*const schema = z.object({
    email: z.email('Invalid email'),
    password: z
        .string('Password is required')
        .min(8, 'Must be at least 8 characters'),
});

type Schema = z.output<typeof schema>;*/

function onSubmit(payload: FormSubmitEvent<any>) {
    console.log('Submitted', payload);
}
</script>

<template>
    <GuestLayout>
        <div class="flex flex-col items-center justify-center gap-4 p-4">
            <UPageCard class="w-full max-w-md">
                <UAuthForm
                    title="Login"
                    description="Enter your credentials to access your account."
                    icon="i-lucide-user"
                    :fields="fields"
                    :providers="providers"
                    @submit="onSubmit"
                >
                    <template #password-hint>
                        <ULink
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
