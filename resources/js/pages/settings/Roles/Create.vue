<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import RolesController from '@/actions/App/Http/Controllers/Settings/RolesController';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/SettingsLayout.vue';

defineOptions({
    layout: [[AuthLayout, { title: 'Impostazioni' }], SettingsLayout],
});
</script>

<template>
    <Head title="Crea ruolo" />

    <UPageCard title="Crea ruolo" description="Aggiungi un nuovo ruolo all'applicazione." variant="subtle">
        <Form v-bind="RolesController.store.form()" v-slot="{ errors, processing }" class="flex flex-col gap-6">
            <UFormField name="name" label="Nome ruolo" :error="errors.name" required>
                <UInput name="name" autocomplete="off" placeholder="Inserisci il nome del ruolo" class="w-full" />
            </UFormField>

            <div class="flex justify-end gap-3">
                <UButton :to="RolesController.index.url()" label="Annulla" color="neutral" variant="outline" />
                <UButton type="submit" label="Crea ruolo" :loading="processing" />
            </div>
        </Form>
    </UPageCard>
</template>
