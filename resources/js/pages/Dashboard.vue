<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

defineOptions({
    layout: () => ({ title: 'Dashboard' }),
});

const sendNotification = () => {
    router.get('/notify');
};
</script>

<template>
    <Head title="Dashboard" />
    <UButton label="Click me" class="m-2" @click="sendNotification" />
</template>
