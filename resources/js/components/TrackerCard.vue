<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import TrackerController from '@/actions/App/Http/Controllers/TrackerController';
import EditTrackerModal from '@/components/EditTrackerModal.vue';
import type { Category, Tracker } from '@/types/tracker';

defineProps<{
    tracker: Tracker;
    categories: Category[];
}>();

const isEditOpen = ref(false);
</script>

<template>
    <div class="flex justify-between rounded border p-4 dark:bg-slate-800/20">
        <div>
            <h3 class="text-xl">{{ tracker.name }}</h3>
            <p class="text-sm">{{ tracker.category.name }}</p>
            <p
                v-if="tracker.next_appointment_at"
                class="mt-1 text-sm text-muted-foreground"
            >
                Next appointment: {{ tracker.next_appointment_at }}
            </p>
        </div>
        <div class="flex gap-2">
            <button
                type="button"
                class="size-max cursor-pointer rounded bg-blue-500 p-2 hover:bg-blue-700"
                @click="isEditOpen = true"
            >
                Edit
            </button>
            <Form
                :action="TrackerController.destroy(tracker.id)"
                method="delete"
            >
                <button
                    type="submit"
                    class="size-max cursor-pointer rounded bg-red-500 p-2 hover:bg-red-700"
                >
                    Delete
                </button>
            </Form>
        </div>
    </div>
    <EditTrackerModal
        v-model:is-open="isEditOpen"
        :tracker="tracker"
        :categories="categories"
    />
</template>
