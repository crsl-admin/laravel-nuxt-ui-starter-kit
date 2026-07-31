<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import NewPasswordController from '@/actions/Laravel/Fortify/Http/Controllers/NewPasswordController';
import UPasswordStrengthIndicator from '@/components/input/UPasswordStrengthIndicator.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';

defineOptions({ layout: GuestLayout });

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <Head title="Reimposta password" />

    <UPageCard
        class="w-full max-w-md"
        title="Reimposta la password"
        description="Inserisci qui sotto la tua nuova password."
        icon="i-lucide-lock-keyhole"
        :spotlight="true"
    >
        <Form
            v-bind="NewPasswordController.store.form()"
            :transform="(data) => ({ ...data, token, email })"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <UFormField name="email" :error="errors.email" label="Email">
                <UInput
                    type="email"
                    class="w-full"
                    autocomplete="email"
                    icon="i-lucide-mail"
                    readonly="true"
                    v-model="inputEmail"
                />
            </UFormField>

            <UFormField name="password" :error="errors.password" label="Password">
                <UPasswordStrengthIndicator name="password" placeholder="Nuova password" autofocus required />
            </UFormField>

            <UFormField name="password_confirmation" :error="errors.password_confirmation" label="Conferma password">
                <UPasswordStrengthIndicator
                    name="password_confirmation"
                    placeholder="Conferma la password"
                    :show-strength="false"
                    required
                />
            </UFormField>

            <UButton :loading="processing" type="submit" block> Reimposta password </UButton>
        </Form>
    </UPageCard>
</template>
