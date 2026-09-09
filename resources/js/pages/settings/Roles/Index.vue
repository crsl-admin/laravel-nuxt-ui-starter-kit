<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import RolesController from '@/actions/App/Http/Controllers/Settings/RolesController';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/SettingsLayout.vue';

defineOptions({
    layout: [[AuthLayout, { title: 'Impostazioni' }], SettingsLayout],
});

defineProps<{
    roles: Array<{
        id: number;
        name: string;
        users_count: number;
    }>;
}>();
</script>

<template>
    <Head title="Ruoli" />

    <UPageCard variant="subtle" :ui="{ header: 'w-full' }">
        <template #header>
            <div class="flex w-full items-center justify-between gap-4">
                <div>
                    <h2 class="text-base font-semibold text-highlighted">Ruoli</h2>
                    <p class="mt-1 text-sm text-muted">Gestisci i ruoli disponibili nell'applicazione.</p>
                </div>

                <UButton :to="RolesController.create.url()" icon="i-lucide-plus" label="Crea ruolo" />
            </div>
        </template>

        <div class="overflow-hidden rounded-lg border border-default">
            <table class="w-full text-left text-sm">
                <thead class="bg-elevated text-muted">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nome ruolo</th>
                        <th class="px-4 py-3 text-right font-medium">Utenti</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    <tr v-for="role in roles" :key="role.id">
                        <td class="px-4 py-3 font-medium text-highlighted">{{ role.name }}</td>
                        <td class="px-4 py-3 text-right text-muted">{{ role.users_count }}</td>
                    </tr>
                    <tr v-if="roles.length === 0">
                        <td colspan="2" class="px-4 py-8 text-center text-muted">Nessun ruolo disponibile.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </UPageCard>
</template>
