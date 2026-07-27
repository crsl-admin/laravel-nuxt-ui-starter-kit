<script setup lang="ts">
import { computed, ref, useId } from 'vue';

withDefaults(
    defineProps<{
        name?: string;
        placeholder?: string;
        autocomplete?: string;
        autofocus?: boolean;
        required?: boolean;
        showStrength?: boolean;
    }>(),
    {
        autocomplete: 'new-password',
        showStrength: true,
    },
);

const password = defineModel<string>({ default: '' });
const show = ref(false);
const strengthId = useId();

const requirements = [
    { regex: /.{8,}/, text: 'Almeno 8 caratteri' },
    { regex: /\d/, text: 'Almeno 1 numero' },
    { regex: /[a-z]/, text: 'Almeno 1 lettera minuscola' },
    { regex: /[A-Z]/, text: 'Almeno 1 lettera maiuscola' },
];

const strength = computed(() =>
    requirements.map((req) => ({
        met: req.regex.test(password.value),
        text: req.text,
    })),
);
const score = computed(() => strength.value.filter((req) => req.met).length);

const color = computed(() => {
    if (score.value === 0) {
        return 'neutral';
    }

    if (score.value <= 1) {
        return 'error';
    }

    if (score.value <= 3) {
        return 'warning';
    }

    return 'success';
});

const text = computed(() => {
    if (score.value === 0) {
        return 'Inserisci la password';
    }

    if (score.value <= 2) {
        return 'Password debole';
    }

    if (score.value === 3) {
        return 'Password mediocre';
    }

    return 'Password forte';
});
</script>

<template>
    <div class="space-y-2">
        <UInput
            v-model="password"
            :name="name"
            :placeholder="placeholder"
            :autocomplete="autocomplete"
            :autofocus="autofocus"
            :required="required"
            :color="showStrength ? color : undefined"
            :type="show ? 'text' : 'password'"
            :aria-describedby="showStrength ? strengthId : undefined"
            :ui="{ trailing: 'pe-1' }"
            class="w-full"
            icon="i-lucide-lock"
        >
            <template #trailing>
                <UButton
                    color="neutral"
                    variant="link"
                    size="sm"
                    :icon="show ? 'i-lucide-eye-off' : 'i-lucide-eye'"
                    :aria-label="show ? 'Nascondi password' : 'Mostra password'"
                    :aria-pressed="show"
                    @click="show = !show"
                />
            </template>
        </UInput>

        <template v-if="showStrength">
            <UProgress
                :color="color"
                :indicator="text"
                :model-value="score"
                :max="4"
                size="sm"
            />

            <p :id="strengthId" class="text-sm font-medium">
                {{ text }}. Deve contenere:
            </p>

            <ul class="space-y-1" aria-label="Requisiti password">
                <li
                    v-for="(req, index) in strength"
                    :key="index"
                    class="flex items-center gap-0.5"
                    :class="req.met ? 'text-success' : 'text-muted'"
                >
                    <UIcon
                        :name="req.met ? 'i-lucide-circle-check' : 'i-lucide-circle-x'"
                        class="size-4 shrink-0"
                    />
                    <span class="text-xs font-light">
                        {{ req.text }}
                        <span class="sr-only">
                            {{ req.met ? ' - Requisito soddisfatto' : ' - Requisito non soddisfatto' }}
                        </span>
                    </span>
                </li>
            </ul>
        </template>
    </div>
</template>
