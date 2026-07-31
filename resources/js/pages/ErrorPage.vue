<script setup>
import { computed } from 'vue';

const props = defineProps({ status: Number });

const title = computed(() => {
    return {
        503: '503: Service Unavailable',
        500: '500: Server Error',
        404: '404: Pagina non trovata',
        403: '403: Forbidden',
    }[props.status];
});

const description = computed(() => {
    return {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Mi dispiace, la pagina che stai cercando non può essere trovata.',
        403: 'Sorry, you are forbidden from accessing this page.',
    }[props.status];
});
</script>

<template>
    <UApp>
        <UError
            :clear="{
                size: 'xl',
                icon: 'i-lucide-arrow-left',
                label: 'Indietro',
                to: '/',
            }"
            :error="{
                statusCode: status,
                statusMessage: title,
                message: description,
            }"
        />
        <UFooter />
    </UApp>
</template>
