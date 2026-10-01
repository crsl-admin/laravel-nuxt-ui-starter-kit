<script setup lang="ts">
defineOptions({ inheritAttrs: false })

type Variant = 'orizzontale' | 'logo' | 'logo-completo' | 'monogramma'

const props = withDefaults(defineProps<{
    variant?: Variant
    /** 'auto' segue il dark mode */
    tone?: 'auto' | 'light' | 'dark' | 'mono'
    alt?: string
}>(), {
    variant: 'orizzontale',
    tone: 'auto',
    alt: 'CRSLaghi',
})

const file = (suffix = '') =>
    `/brand/${props.variant === 'orizzontale' ? 'logo-orizzontale' : props.variant}${suffix}.svg`
</script>

<template>
    <UColorModeImage v-if="tone === 'auto'" :light="file()" :dark="file('-dark')" :alt="alt" v-bind="$attrs" />
    <img v-else :src="file(tone === 'light' ? '' : `-${tone}`)" :alt="alt" v-bind="$attrs">
</template>
