<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({ status: { type: Number, required: true } });

const title = computed(() => {
    return {
        503: '503: Servizio non disponibile',
        500: '500: Errore del server',
        404: '404: Pagina non trovata',
        403: '403: Accesso negato',
    }[props.status];
});

const description = computed(() => {
    return {
        503: 'Stiamo effettuando una manutenzione. Per favore, riprova più tardi.',
        500: 'Mi dispiace, si è verificato un errore sul nostro server.',
        404: 'Mi dispiace, la pagina che stai cercando non può essere trovata.',
        403: 'Non hai il permesso di accedere a questa pagina.',
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
