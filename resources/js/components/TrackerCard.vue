<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import DeleteTrackerController from '@/actions/App/Http/Controllers/Tracker/DeleteTrackerController';
import ShowTrackerController from '@/actions/App/Http/Controllers/Tracker/ShowTrackerController';
import EditTrackerModal from '@/components/EditTrackerModal.vue';
import type { Category, Tracker, TrackerAppointment } from '@/types/tracker';

const props = defineProps<{
    tracker: Tracker;
    categories: Category[];
}>();

const isEditOpen = ref(false);

const nextAppointment = computed<TrackerAppointment | null>(() => {
    const now = new Date();
    const upcoming = props.tracker.appointments
        .filter((a) => new Date(a.appointment_at) > now)
        .sort((a, b) => new Date(a.appointment_at).getTime() - new Date(b.appointment_at).getTime());

    return upcoming[0] ?? null;
});

function formatDate(dateString: string): string {
    return new Date(dateString).toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}
</script>

<template>
    <div class="flex justify-between rounded border p-4 dark:bg-slate-800/20">
        <div>
            <Link
                :href="ShowTrackerController(tracker.id).url"
                class="text-xl hover:underline"
            >{{ tracker.name }}</Link>
            <p class="text-sm">{{ tracker.category.name }}</p>
            <p
                v-if="nextAppointment"
                class="mt-1 text-sm text-muted-foreground"
            >
                Next appointment: {{ formatDate(nextAppointment.appointment_at) }}
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
            <Form :action="DeleteTrackerController(tracker.id)" method="delete">
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
