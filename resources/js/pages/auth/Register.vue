<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import RegisteredUserController from '@/actions/Laravel/Fortify/Http/Controllers/RegisteredUserController';
import UPasswordStrengthIndicator from '@/components/input/UPasswordStrengthIndicator.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });
</script>

<template>
    <Head title="Register" />

    <div class="flex w-full flex-col items-center justify-center gap-4 p-4">
        <UPageCard
            class="w-full max-w-2xl"
            title="Registrati"
            description="Crea un nuovo account."
            icon="i-lucide-user"
            :spotlight="true"
        >
            <Form
                v-bind="RegisteredUserController.store.form()"
                :reset-on-success="['password', 'password_confirmation']"
                v-slot="{ errors, processing }"
                class="flex flex-col gap-6"
            >
                <UFormField name="first_name" :error="errors.first_name" label="Nome">
                    <UInput
                        type="first_name"
                        class="w-full"
                        autocomplete="first_name"
                        icon="i-lucide-user"
                        placeholder="Inserisci il tuo nome"
                    />
                </UFormField>

                <UFormField name="last_name" :error="errors.last_name" label="Cognome">
                    <UInput
                        type="last_name"
                        class="w-full"
                        autocomplete="last_name"
                        icon="i-lucide-user"
                        placeholder="Inserisci il tuo cognome"
                    />
                </UFormField>

                <UFormField name="email" :error="errors.email" label="Email">
                    <UInput
                        type="email"
                        class="w-full"
                        autocomplete="email"
                        icon="i-lucide-mail"
                        placeholder="Inserisci la tua email"
                    />
                </UFormField>

                <UFormField name="password" :error="errors.password" label="Password">
                    <UPasswordStrengthIndicator name="password" placeholder="Password" autofocus required />
                </UFormField>

                <UFormField
                    name="password_confirmation"
                    :error="errors.password_confirmation"
                    label="Conferma password"
                >
                    <UPasswordStrengthIndicator
                        name="password_confirmation"
                        placeholder="Conferma la password"
                        :show-strength="false"
                        required
                    />
                </UFormField>

                <UButton :loading="processing" type="submit" block> Registrati </UButton>
            </Form>
        </UPageCard>
    </div>
</template>
