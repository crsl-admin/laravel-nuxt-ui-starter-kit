<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import PasswordController from '@/actions/Laravel/Fortify/Http/Controllers/PasswordController';
import UPasswordStrengthIndicator from '@/components/input/UPasswordStrengthIndicator.vue';
</script>

<template>
    <UPageCard
        title="Password"
        description="Usa una password lunga e casuale per mantenere il tuo account al sicuro."
        variant="subtle"
    >
        <Form
            v-bind="PasswordController.update.form()"
            v-slot="{ errors, processing }"
            :reset-on-success="['current_password', 'password', 'password_confirmation']"
            preserve-scroll
            class="flex w-full flex-col gap-4"
        >
            <UFormField name="current_password" :error="errors.current_password" label="Password attuale">
                <UInput
                    type="password"
                    name="current_password"
                    autocomplete="current-password"
                    icon="i-lucide-lock"
                    placeholder="La tua password attuale"
                    class="w-full"
                />
            </UFormField>

            <UFormField name="password" :error="errors.password" label="Nuova password">
                <UPasswordStrengthIndicator name="password" placeholder="Nuova password" required />
            </UFormField>

            <UFormField
                name="password_confirmation"
                :error="errors.password_confirmation"
                label="Conferma nuova password"
            >
                <UPasswordStrengthIndicator
                    name="password_confirmation"
                    placeholder="Conferma la nuova password"
                    :show-strength="false"
                    required
                />
            </UFormField>

            <div class="flex justify-end">
                <UButton :loading="processing" type="submit" label="Aggiorna password" />
            </div>
        </Form>
    </UPageCard>
</template>
