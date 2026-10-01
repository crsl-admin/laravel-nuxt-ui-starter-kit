<script setup lang="ts">
import { usePage, Link } from '@inertiajs/vue3';
import type { NavigationMenuItem } from '@nuxt/ui';
import { defineShortcuts } from '@nuxt/ui/composables/defineShortcuts';
import { computed, ref } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import NotificationsMenu from '@/components/sidebar/NotificationsMenu.vue';
// import TeamsMenu from '@/components/sidebar/TeamsMenu.vue';
import UserMenu from '@/components/sidebar/UserMenu.vue';

defineProps<{
    breadcrumbItems?: NavigationMenuItem[];
    title: string;
}>();

const { url } = usePage();

const open = ref(false);
const collapsed = ref(false);

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
            label: 'Customers',
            icon: 'i-lucide-users',
            to: route('customers'),
            onSelect: () => {
                open.value = false;
            },
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

const settings = [
    {
        label: 'Impostazioni',
        icon: 'i-lucide-settings',
        type: 'trigger',
        children: [
            { label: 'Generale', to: route('settings.profile'), exact: true, onSelect: close },
            { label: 'Sicurezza', to: route('settings.security'), onSelect: close },
        ],
    },
] satisfies NavigationMenuItem[];

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

const toaster = {
    max: 5,
    expand: false,
};

defineShortcuts({
    m: () => {
        collapsed.value = !collapsed.value;
    },
});
</script>

<template>
    <UApp :toaster>
        <UDashboardGroup unit="rem" storage="local">
            <UDashboardSidebar
                id="default"
                v-model:open="open"
                v-model:collapsed="collapsed"
                collapsible
                resizable
                class="bg-elevated/25"
                :ui="{ footer: 'lg:border-t lg:border-default' }"
            >
                <template #header="{ collapsed }">
<!--                    <TeamsMenu :collapsed="collapsed" />-->
                    <Link href="/dashboard" class="flex w-full items-center" :class="collapsed && 'justify-center'">
                        <AppLogo
                            :variant="collapsed ? 'monogramma' : 'orizzontale'"
                            :class="collapsed ? 'h-6 w-8 object-contain' : 'h-12 w-auto'"
                        />
                    </Link>
                </template>

                <template #default="{ collapsed }">
                    <UDashboardSearchButton label="Cerca" :collapsed="collapsed" class="bg-transparent ring-default" />

                    <UNavigationMenu
                        highlight
                        :collapsed="collapsed"
                        :items="links[0]"
                        orientation="vertical"
                        tooltip
                        popover
                    />

                    <UNavigationMenu
                        :collapsed="collapsed"
                        :items="settings"
                        orientation="vertical"
                        tooltip
                        popover
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
                            <UDashboardSidebarCollapse icon="i-lucide-panel-left" as="button" />
                        </template>
                        <template #right>
                            <NotificationsMenu />
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
