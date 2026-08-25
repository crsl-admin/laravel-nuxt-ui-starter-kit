<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui';
import { computed } from 'vue';

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
]);
</script>

<template>
    <div class="mx-auto flex w-full max-w-3xl flex-col gap-6">
        <UNavigationMenu :items="tabs" highlight class="border-b border-default" />

        <slot />
    </div>
</template>
