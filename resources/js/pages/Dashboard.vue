<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import AddTrackerForm from '@/components/AddTrackerForm.vue';
import { Category, Tracker } from '@/types/tracker';

defineProps<{
    categories: Category[];
    trackers: Tracker[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <div
                class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
            >
                <h2>Add tracker</h2>
                <AddTrackerForm :categories="categories" />
            </div>
        </div>
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
        >
            <h2 class="text-lg font-medium">Your Trackers</h2>
            <ul>
                <li v-for="tracker in trackers" :key="tracker.id">
                    {{ tracker.name }} - {{ tracker.category.name }}
                </li>
            </ul>
        </div>
    </div>
</template>
