<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AddTrackerForm from '@/components/AddTrackerForm.vue';
import TrackerCard from '@/components/TrackerCard.vue';
import { dashboard } from '@/routes';
import type { Category, Tracker } from '@/types/tracker';
import { Toast } from '@/components/ui/toast';

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
const page = usePage();
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
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-2 md:min-h-min dark:border-sidebar-border"
        >
            <h2 class="text-lg font-medium">Your Trackers</h2>
            <ul class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <li v-for="tracker in trackers" :key="tracker.id">
                    <TrackerCard :tracker="tracker" :categories="categories" />
                </li>
            </ul>
        </div>
    </div>

    <Toast
        v-if="page.flash.toast"
        :message="page.flash.toast.message"
        :type="page.flash.toast.type"
    />
</template>
