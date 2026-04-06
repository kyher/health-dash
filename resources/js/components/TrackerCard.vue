<script setup lang="ts">
defineProps<{
    name: string;
    category: string;
}>();
</script>

<template>
    <div class="rounded border p-4 dark:bg-slate-800/20">
        <h3 class="text-xl">{{ name }}</h3>
        <p class="text-sm">{{ category }}</p>
    </div>
</template>
