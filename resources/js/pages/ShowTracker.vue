<script setup lang="ts">
import { Form, Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import DeleteTrackerController from '@/actions/App/Http/Controllers/Tracker/DeleteTrackerController';
import StoreTrackerNoteController from '@/actions/App/Http/Controllers/Tracker/StoreTrackerNoteController';
import BackToDashboardLink from '@/components/BackToDashboardLink.vue';
import EditTrackerModal from '@/components/EditTrackerModal.vue';
import { Toast } from '@/components/ui/toast';
import type { Category, Tracker } from '@/types/tracker';

defineProps<{
    tracker: Tracker;
    categories: Category[];
}>();

const page = usePage();
const isEditOpen = ref(false);

const NOTE_MAX_LENGTH = 1000;

const noteForm = useForm({
    content: '',
});

function submitNote(trackerId: number) {
    noteForm.post(StoreTrackerNoteController(trackerId).url, {
        onSuccess: () => noteForm.reset(),
    });
}

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

        <div
            class="relative overflow-hidden rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
        >
            <h2 class="mb-4 text-lg font-semibold">Notes</h2>

            <form
                class="mb-6 flex flex-col gap-2"
                @submit.prevent="submitNote(tracker.id)"
            >
                <div class="flex flex-col gap-1">
                    <textarea
                        v-model="noteForm.content"
                        name="content"
                        rows="3"
                        :maxlength="NOTE_MAX_LENGTH"
                        placeholder="Add a note..."
                        class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                    />
                    <div class="flex items-center justify-between">
                        <p v-if="noteForm.errors.content" class="text-sm text-red-500">
                            {{ noteForm.errors.content }}
                        </p>
                        <p class="ml-auto text-xs text-muted-foreground">
                            {{ noteForm.content.length }}/{{ NOTE_MAX_LENGTH }}
                        </p>
                    </div>
                </div>
                <button
                    type="submit"
                    :disabled="noteForm.processing || noteForm.content.trim().length === 0"
                    class="w-max cursor-pointer rounded bg-blue-500 px-4 py-2 text-sm hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Add Note
                </button>
            </form>

            <div v-if="tracker.notes.length === 0" class="text-sm text-muted-foreground">
                No notes yet.
            </div>
            <ul v-else class="flex flex-col gap-3">
                <li
                    v-for="note in tracker.notes"
                    :key="note.id"
                    class="rounded-md border border-sidebar-border/70 p-3 text-sm dark:border-sidebar-border"
                >
                    <p class="whitespace-pre-wrap">{{ note.content }}</p>
                    <p class="mt-1 text-xs text-muted-foreground">
                        {{ formatDate(note.created_at) }}
                    </p>
                </li>
            </ul>
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
