<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PasskeysCard from '@/components/settings/PasskeysCard.vue';
import TwoFactorCard from '@/components/settings/TwoFactorCard.vue';
import UpdatePasswordCard from '@/components/settings/UpdatePasswordCard.vue';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/SettingsLayout.vue';

defineOptions({
    layout: [
        [AuthLayout, { title: 'Impostazioni' }],
        SettingsLayout
    ],
});

defineProps<{
    twoFactorEnabled: boolean;
    twoFactorConfirmed: boolean;
    qrCodeSvg: string | null;
    setupKey: string | null;
    recoveryCodes?: string[];
    passkeys: App.Data.PasskeyData[];
}>();
</script>

<template>
    <Head title="Sicurezza" />

    <div class="flex flex-col gap-6">
        <UpdatePasswordCard />

        <TwoFactorCard
            :enabled="twoFactorEnabled"
            :confirmed="twoFactorConfirmed"
            :qr-code-svg="qrCodeSvg"
            :setup-key="setupKey"
            :recovery-codes="recoveryCodes"
        />

        <PasskeysCard :passkeys="passkeys" />
    </div>
</template>
