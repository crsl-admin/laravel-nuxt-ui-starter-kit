<script setup lang="ts">
import { Form, Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import ProfileInformationController from '@/actions/Laravel/Fortify/Http/Controllers/ProfileInformationController';
import { useInitials } from '@/composables/useInitials';
import AuthLayout from '@/layouts/AuthLayout.vue';
import SettingsLayout from '@/layouts/SettingsLayout.vue';

defineOptions({
    layout: [[AuthLayout, { title: 'Impostazioni' }], SettingsLayout],
});

const page = usePage<{ auth: { user: App.Data.UserData } }>();
const { getInitials } = useInitials();

const user = computed(() => page.props.auth.user);
const avatar = ref<File | null>(null);
const avatarPreview = computed(() => (avatar.value ? URL.createObjectURL(avatar.value) : user.value.avatar_url));

</script>

<template>
    <Head title="Profilo" />

    <UPageCard
        icon="i-lucide-user"
        title="Informazioni personali"
        variant="subtle"
        :ui="{ container: 'gap-4' }"
    >
        <Form
            v-bind="ProfileInformationController.update.form()"
            v-slot="{ errors, processing }"
            preserve-scroll
            class="flex w-full flex-col gap-6"
        >
            <UFormField
                name="avatar"
                :error="errors.avatar"
                label="Immagine del profilo"
                description="JPG, PNG o WEBP. Massimo 2MB."
                class="flex items-start justify-between gap-4 max-sm:flex-col"
            >
                <UFileUpload v-slot="{ open }" v-model="avatar" name="avatar" accept="image/*">
                    <div class="flex items-center gap-3">
                        <UAvatar :src="avatarPreview ?? undefined" :text="getInitials(user.full_name)" size="3xl" />

                        <UButton
                            label="Scegli immagine"
                            icon="i-lucide-upload"
                            color="neutral"
                            variant="outline"
                            @click="open()"
                        />
                    </div>
                </UFileUpload>
            </UFormField>

            <USeparator />

            <UFormField
                name="first_name"
                :error="errors.first_name"
                label="Nome"
                class="flex items-start justify-between gap-4 max-sm:flex-col"
            >
                <UInput
                    :default-value="user.first_name"
                    autocomplete="given-name"
                    icon="i-lucide-user"
                    placeholder="Inserisci il tuo nome"
                />
            </UFormField>

            <USeparator />

            <UFormField
                name="last_name"
                :error="errors.last_name"
                label="Cognome"
                class="flex items-start justify-between gap-4 max-sm:flex-col"
            >
                <UInput
                    :default-value="user.last_name"
                    autocomplete="family-name"
                    icon="i-lucide-user"
                    placeholder="Inserisci il tuo cognome"
                />
            </UFormField>

            <USeparator />

            <UFormField
                name="email"
                :error="errors.email"
                label="Email"
                class="flex items-start justify-between gap-4 max-sm:flex-col"
            >
                <UInput
                    type="email"
                    :default-value="user.email"
                    autocomplete="email"
                    icon="i-lucide-mail"
                    placeholder="Inserisci la tua email"
                />
            </UFormField>

            <USeparator />

            <div class="flex justify-end">
                <UButton :loading="processing" type="submit" label="Salva modifiche" />
            </div>
        </Form>
    </UPageCard>
</template>
