<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import TrackerController from '@/actions/App/Http/Controllers/TrackerController';
import type { Tracker } from '@/types/tracker';

defineProps<{
    tracker: Tracker;
}>();
</script>

<template>
    <div class="flex justify-between rounded border p-4 dark:bg-slate-800/20">
        <div>
            <h3 class="text-xl">{{ tracker.name }}</h3>
            <p class="text-sm">{{ tracker.category.name }}</p>
        </div>
        <Form :action="TrackerController.destroy(tracker.id)" method="delete">
            <button
                type="submit"
                class="cursor-pointer rounded bg-red-500 p-2 hover:bg-red-700"
            >
                Delete
            </button>
        </Form>
    </div>
</template>
