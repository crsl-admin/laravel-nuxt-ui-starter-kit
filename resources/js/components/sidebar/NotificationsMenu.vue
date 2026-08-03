<script setup lang="ts">
import { defineShortcuts } from '@nuxt/ui/runtime/composables/defineShortcuts.js';
import { ref } from 'vue';

const isNotificationsSlideoverOpen = ref(false);

const hasNotifications = ref(false);

defineShortcuts({
    n: () => {
        isNotificationsSlideoverOpen.value = !isNotificationsSlideoverOpen.value;
    },
});
</script>

<template>
    <USlideover title="Notifiche" v-model:open="isNotificationsSlideoverOpen">
        <UTooltip text="Notifiche" :shortcuts="['N']">
            <UButton color="neutral" variant="ghost" square @click="isNotificationsSlideoverOpen = true">
                <UChip color="error" inset v-if="hasNotifications">
                    <UIcon name="i-lucide-bell" class="size-5 shrink-0" />
                </UChip>
                <UIcon v-else name="i-lucide-bell" class="size-5 shrink-0" />
            </UButton>
        </UTooltip>

        <template #body>
            <div class="flex flex-col items-center justify-center gap-2 py-12 text-center">
                <UIcon name="i-lucide-bell-off" class="size-8 text-dimmed" />
                <p class="text-sm font-medium text-highlighted">Nessuna notifica</p>
                <p class="text-sm text-muted">Al momento non hai notifiche. Ti avviseremo quando ci saranno novità.</p>
            </div>
        </template>
    </USlideover>
</template>
