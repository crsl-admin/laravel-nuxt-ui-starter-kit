<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import type { NavigationMenuItem } from '@nuxt/ui';
// import { useToast } from '@nuxt/ui/runtime/composables/useToast.js';
import { computed, ref } from 'vue';
import TeamsMenu from '@/components/sidebar/TeamsMenu.vue';
import UserMenu from '@/components/sidebar/UserMenu.vue';

defineProps<{
    breadcrumbItems?: NavigationMenuItem[];
    title: string;
}>();

const { url } = usePage();
// const toast = useToast();

const open = ref(false);

const links = [
    [
        {
            label: 'Home',
            icon: 'i-lucide-house',
            to: '/dashboard',
            onSelect: () => {
                open.value = false;
            },
        },
        {
            label: 'Inbox',
            icon: 'i-lucide-inbox',
            to: '/inbox',
            badge: '4',
            onSelect: () => {
                open.value = false;
            },
        },
        {
            label: 'Customers',
            icon: 'i-lucide-users',
            to: '/customers',
            onSelect: () => {
                open.value = false;
            },
        },
        {
            label: 'Settings',
            to: '/settings',
            icon: 'i-lucide-settings',
            defaultOpen: true,
            type: 'trigger',
            children: [
                {
                    label: 'Profile',
                    to: '/settings/profile',
                    exact: true,
                    onSelect: () => {
                        open.value = false;
                    },
                },
                {
                    label: 'Members',
                    to: '/settings/members',
                    onSelect: () => {
                        open.value = false;
                    },
                },
                {
                    label: 'Notifications',
                    to: '/settings/notifications',
                    onSelect: () => {
                        open.value = false;
                    },
                },
                {
                    label: 'Security',
                    to: '/settings/security',
                    onSelect: () => {
                        open.value = false;
                    },
                },
            ],
        },
    ],
    [
        {
            label: 'Feedback',
            icon: 'i-lucide-message-circle',
            to: 'https://github.com/nuxt-ui-pro/dashboard-vue',
            target: '_blank',
        },
        {
            label: 'Help & Support',
            icon: 'i-lucide-info',
            to: 'https://github.com/nuxt/ui-pro',
            target: '_blank',
        },
    ],
] satisfies NavigationMenuItem[][];

const groups = computed(() => [
    {
        id: 'links',
        label: 'Vai a',
        items: links.flat(),
    },
    {
        id: 'code',
        label: 'Code',
        items: [
            {
                id: 'source',
                label: 'View page source',
                icon: 'simple-icons:github',
                to: `https://github.com/nuxt-ui-pro/dashboard-vue/blob/main/src/pages${url === '/' ? '/index' : url}.vue`,
                target: '_blank',
            },
        ],
    },
]);

const value = ref('');
</script>

<template>
    <UApp>
        <UDashboardGroup unit="rem" storage="local">
            <UDashboardSidebar
                id="default"
                v-model:open="open"
                collapsible
                resizable
                class="bg-elevated/25"
                :ui="{ footer: 'lg:border-t lg:border-default' }"
            >
                <template #header="{ collapsed }">
                    <TeamsMenu :collapsed="collapsed" />
                </template>

                <template #default="{ collapsed }">
                    <UDashboardSearchButton label="Cerca" :collapsed="collapsed" class="bg-transparent ring-default" />

                    <UNavigationMenu :collapsed="collapsed" :items="links[0]" orientation="vertical" tooltip popover />

                    <UNavigationMenu
                        :collapsed="collapsed"
                        :items="links[1]"
                        orientation="vertical"
                        tooltip
                        class="mt-auto"
                    />
                </template>

                <template #footer="{ collapsed }">
                    <UserMenu :collapsed="collapsed" />
                </template>
            </UDashboardSidebar>

            <UDashboardSearch v-model="value" placeholder="Cerca qualcosa" :colorMode="false" :groups="groups" />

            <UDashboardPanel :id="title">
                <template #header>
                    <UDashboardNavbar :title>
                        <template #leading>
                            <UDashboardSidebarCollapse icon="i-lucide-panel-left" as="button" :disabled="false" />
                        </template>
                    </UDashboardNavbar>
                </template>

                <template #body>
                    <slot />
                </template>
            </UDashboardPanel>

            <!--            <NotificationsSlideover />-->
        </UDashboardGroup>
    </UApp>
</template>

<style scoped></style>
