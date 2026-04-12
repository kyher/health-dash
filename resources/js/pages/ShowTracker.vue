<script setup lang="ts">
import { Form, Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import DeleteTrackerController from '@/actions/App/Http/Controllers/Tracker/DeleteTrackerController';
import EditTrackerModal from '@/components/EditTrackerModal.vue';
import { Toast } from '@/components/ui/toast';
import type { Category, Tracker } from '@/types/tracker';
import BackToDashboardLink from '@/components/BackToDashboardLink.vue';

defineProps<{
    tracker: Tracker;
    categories: Category[];
}>();

const page = usePage();
const isEditOpen = ref(false);
</script>

<template>
    <Head :title="tracker.name" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <BackToDashboardLink />
        <div
            class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
        >
            <div class="flex items-start justify-between">
                <div class="flex flex-col gap-2">
                    <h1 class="text-2xl font-semibold">{{ tracker.name }}</h1>
                    <p class="text-muted-foreground">
                        {{ tracker.category.name }}
                    </p>
                    <p
                        v-if="tracker.next_appointment_at"
                        class="text-sm text-muted-foreground"
                    >
                        Next appointment: {{ tracker.next_appointment_at }}
                    </p>
                    <p v-else class="text-sm text-muted-foreground">
                        No upcoming appointment scheduled.
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
                        :action="DeleteTrackerController(tracker.id)"
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
        </div>
    </div>

    <EditTrackerModal
        v-model:is-open="isEditOpen"
        :tracker="tracker"
        :categories="categories"
    />

    <Toast
        :message="page.flash.toast?.message"
        :type="page.flash.toast?.type"
    />
</template>
