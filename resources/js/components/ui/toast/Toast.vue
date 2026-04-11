<script setup lang="ts">
import { ref, watch } from 'vue';
import { ToastClose, ToastDescription, ToastProvider, ToastRoot, ToastViewport } from 'reka-ui';

const props = defineProps<{
    message?: string;
    type?: 'success' | 'error';
}>();

const open = ref(false);

watch(
    () => props.message,
    (value) => {
        if (value) open.value = true;
    },
    { immediate: true },
);
</script>

<template>
    <ToastProvider>
        <ToastRoot
            v-model:open="open"
            :duration="4000"
            class="flex items-center justify-between gap-4 rounded-lg border px-4 py-3 shadow-lg data-[state=closed]:animate-out data-[state=closed]:fade-out data-[state=open]:animate-in data-[state=open]:fade-in"
            :class="{
                'border-green-500/30 bg-green-50 text-green-900 dark:bg-green-950 dark:text-green-100': type === 'success',
                'border-red-500/30 bg-red-50 text-red-900 dark:bg-red-950 dark:text-red-100': type === 'error',
                'border-sidebar-border bg-background text-foreground': !type,
            }"
        >
            <ToastDescription>{{ message }}</ToastDescription>
            <ToastClose class="shrink-0 opacity-50 transition-opacity hover:opacity-100">
                <span class="sr-only">Close</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </ToastClose>
        </ToastRoot>

        <ToastViewport class="fixed top-4 right-4 z-50 flex w-80 flex-col gap-2" />
    </ToastProvider>
</template>
