<script setup lang="ts">
import { Head, useHttp } from '@inertiajs/vue3';
import type { TableColumn } from '@nuxt/ui';
import { computed, h, onMounted, ref, resolveComponent, watch } from 'vue';
import { users as getDemoUsers } from '@/actions/App/Http/Controllers/DemoTableController';

interface DemoUser {
    id: number;
    user: string;
    email: string;
    role: string;
    active: boolean;
}

interface DemoUsersResponse {
    users: DemoUser[];
}

type SortableColumn = 'user' | 'email' | 'role' | 'active';
type SortDirection = 'asc' | 'desc';

defineOptions({
    layout: () => ({ title: 'Demo table' }),
});

const Badge = resolveComponent('UBadge');
const Button = resolveComponent('UButton');
const itemsPerPage = 10;
const page = ref(1);
const search = ref('');
const sortColumn = ref<SortableColumn>('user');
const sortDirection = ref<SortDirection>('asc');
const users = ref<DemoUser[]>([]);
const usersRequest = useHttp<Record<string, never>, DemoUsersResponse>({});

function toggleSorting(column: SortableColumn): void {
    if (sortColumn.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column;
        sortDirection.value = 'asc';
    }

    page.value = 1;
}

function sortableHeader(column: SortableColumn, label: string) {
    const icon =
        sortColumn.value === column
            ? sortDirection.value === 'asc'
                ? 'i-lucide-arrow-up'
                : 'i-lucide-arrow-down'
            : 'i-lucide-arrow-up-down';

    return h(Button, {
        color: 'neutral',
        variant: 'ghost',
        label,
        icon,
        onClick: () => toggleSorting(column),
    });
}

const columns: TableColumn<DemoUser>[] = [
    { accessorKey: 'user', header: () => sortableHeader('user', 'Utente') },
    { accessorKey: 'email', header: () => sortableHeader('email', 'Email') },
    { accessorKey: 'role', header: () => sortableHeader('role', 'Ruolo') },
    {
        accessorKey: 'active',
        header: () => sortableHeader('active', 'Stato'),
        cell: ({ row }) =>
            h(
                Badge,
                {
                    color: row.original.active ? 'success' : 'neutral',
                    variant: 'subtle',
                },
                () => (row.original.active ? 'Attivo' : 'Non attivo'),
            ),
    },
];

const filteredUsers = computed(() => {
    const normalizedSearch = search.value.trim().toLocaleLowerCase('it-IT');

    if (!normalizedSearch) {
        return users.value;
    }

    return users.value.filter(({ user, email, role, active }) => {
        const searchableValues = [user, email, role, active ? 'attivo' : 'non attivo'];

        return searchableValues.some((value) => value.toLocaleLowerCase('it-IT').includes(normalizedSearch));
    });
});

const sortedUsers = computed(() => {
    const direction = sortDirection.value === 'asc' ? 1 : -1;

    return [...filteredUsers.value].sort((firstUser, secondUser) => {
        const firstValue = firstUser[sortColumn.value];
        const secondValue = secondUser[sortColumn.value];

        if (typeof firstValue === 'boolean' && typeof secondValue === 'boolean') {
            return (Number(firstValue) - Number(secondValue)) * direction;
        }

        return String(firstValue).localeCompare(String(secondValue), 'it-IT', { sensitivity: 'base' }) * direction;
    });
});

const paginatedUsers = computed(() => {
    const firstItemIndex = (page.value - 1) * itemsPerPage;

    return sortedUsers.value.slice(firstItemIndex, firstItemIndex + itemsPerPage);
});

watch(search, () => {
    page.value = 1;
});

onMounted(async () => {
    const response = await usersRequest.get(getDemoUsers.url());

    users.value = response.users;
});
</script>

<template>
    <div class="flex flex-col gap-4">
        <Head title="Demo table" />

        <div class="flex items-center justify-between gap-4 max-sm:flex-col max-sm:items-stretch">
            <div>
                <h1 class="text-xl font-semibold text-highlighted">Dati utenti fake</h1>
                <p class="text-sm text-muted">Elenco dimostrativo con utenti.</p>
            </div>

            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Cerca utente, email, ruolo o stato"
                class="w-full sm:max-w-sm"
            >
                <template v-if="search" #trailing>
                    <UButton
                        aria-label="Svuota la ricerca"
                        icon="i-lucide-x"
                        color="neutral"
                        variant="link"
                        size="sm"
                        class="cursor-pointer"
                        @click="search = ''"
                    />
                </template>
            </UInput>
        </div>

        <UCard :ui="{ body: 'p-0 sm:p-0' }">
            <UTable
                :data="paginatedUsers"
                :columns="columns"
                :loading="usersRequest.processing"
                empty="Nessun utente trovato."
            />
        </UCard>

        <UPagination
            v-if="sortedUsers.length > itemsPerPage"
            v-model:page="page"
            :total="sortedUsers.length"
            :items-per-page="itemsPerPage"
            class="justify-end"
        />
    </div>
</template>
