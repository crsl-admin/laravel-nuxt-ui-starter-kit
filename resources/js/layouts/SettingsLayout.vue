<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui';
import { computed } from 'vue';
import { useAuthorization } from '@/composables/useAuthorization';

const { can } = useAuthorization();

const tabs = computed<NavigationMenuItem[]>(() => [
    {
        label: 'Generale',
        icon: 'i-lucide-user',
        to: route('settings.profile'),
    },
    {
        label: 'Sicurezza',
        icon: 'i-lucide-shield-check',
        to: route('settings.security'),
    },
    ...(can('manage_role')
        ? [
              {
                  label: 'Ruoli',
                  icon: 'i-lucide-shield-user',
                  to: route('settings.roles.index'),
              },
          ]
        : []),
]);
</script>

<template>
    <div class="mx-auto flex w-full max-w-3xl flex-col gap-6">
        <UNavigationMenu :items="tabs" highlight class="border-b border-default" />

        <slot />
    </div>
</template>
