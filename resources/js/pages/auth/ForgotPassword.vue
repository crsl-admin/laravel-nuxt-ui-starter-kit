<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import authenticatedSessionController from '@/actions/Laravel/Fortify/Http/Controllers/AuthenticatedSessionController';
import passwordResetLinkController from '@/actions/Laravel/Fortify/Http/Controllers/PasswordResetLinkController';
import GuestLayout from '@/layouts/GuestLayout.vue';
</script>

<template>
    <GuestLayout>
        <Head title="Recupera password" />

        <UPageCard
            class="w-full max-w-md"
            title="Password dimenticata?"
            description="Inserisci il tuo indirizzo email e ti invieremo un link per reimpostare la password."
            icon="i-lucide-key-round"
            :spotlight="true"
        >
            <Form
                v-bind="passwordResetLinkController.store.form()"
                v-slot="{ errors, processing }"
                class="flex flex-col gap-6"
            >
                <UFormField name="email" :error="errors.email" label="Email">
                    <UInput
                        type="email"
                        class="w-full"
                        autocomplete="off"
                        placeholder="Inserisci la tua e-mail"
                        icon="i-lucide-mail"
                        autofocus
                        required
                    />
                </UFormField>

                <UButton :loading="processing" type="submit" block>
                    Invia link per reimpostare la password
                </UButton>
            </Form>

            <div class="mt-6 text-center text-sm text-muted">
                <span>Oppure, vai alla pagina di</span>
                <ULink
                    :to="authenticatedSessionController.create().url"
                    class="font-medium text-primary"
                >
                    Login
                </ULink>
            </div>
        </UPageCard>
    </GuestLayout>
</template>
