<script setup lang="ts"></script>

<template>
    <UApp>
        <UMain>
            <UContainer>
                <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
                    <slot />
                </div>
            </UContainer>
        </UMain>
    </UApp>
</template>

<style scoped></style>
