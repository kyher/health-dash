<script setup lang="ts">
import { Form, Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import DeleteTrackerAppointmentController from '@/actions/App/Http/Controllers/Tracker/DeleteTrackerAppointmentController';
import DeleteTrackerController from '@/actions/App/Http/Controllers/Tracker/DeleteTrackerController';
import StoreTrackerAppointmentController from '@/actions/App/Http/Controllers/Tracker/StoreTrackerAppointmentController';
import StoreTrackerNoteController from '@/actions/App/Http/Controllers/Tracker/StoreTrackerNoteController';
import BackToDashboardLink from '@/components/BackToDashboardLink.vue';
import EditTrackerModal from '@/components/EditTrackerModal.vue';
import { Toast } from '@/components/ui/toast';
import type { Category, Tracker, TrackerAppointment } from '@/types/tracker';

const props = defineProps<{
    tracker: Tracker;
    categories: Category[];
}>();

const page = usePage();
const isEditOpen = ref(false);

const NOTE_MAX_LENGTH = 1000;

const noteForm = useForm({
    content: '',
});

const appointmentForm = useForm({
    appointment_at: '',
});

const nextAppointment = computed<TrackerAppointment | null>(() => {
    const now = new Date();
    const upcoming = props.tracker.appointments
        .filter((a) => new Date(a.appointment_at) > now)
        .sort((a, b) => new Date(a.appointment_at).getTime() - new Date(b.appointment_at).getTime());

    return upcoming[0] ?? null;
});

function submitNote(trackerId: number) {
    noteForm.post(StoreTrackerNoteController(trackerId).url, {
        onSuccess: () => noteForm.reset(),
    });
}

function submitAppointment(trackerId: number) {
    appointmentForm.post(StoreTrackerAppointmentController(trackerId).url, {
        onSuccess: () => appointmentForm.reset(),
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
                        v-if="nextAppointment"
                        class="text-sm text-muted-foreground"
                    >
                        Next appointment: {{ formatDate(nextAppointment.appointment_at) }}
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
            <h2 class="mb-4 text-lg font-semibold">Appointments</h2>

            <form
                class="mb-6 flex flex-col gap-2"
                @submit.prevent="submitAppointment(tracker.id)"
            >
                <div class="flex flex-col gap-1">
                    <label for="appointment_at" class="text-sm">Appointment date & time</label>
                    <input
                        v-model="appointmentForm.appointment_at"
                        type="datetime-local"
                        id="appointment_at"
                        name="appointment_at"
                        class="w-max rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                    />
                    <p v-if="appointmentForm.errors.appointment_at" class="text-sm text-red-500">
                        {{ appointmentForm.errors.appointment_at }}
                    </p>
                </div>
                <button
                    type="submit"
                    :disabled="appointmentForm.processing || appointmentForm.appointment_at.trim().length === 0"
                    class="w-max cursor-pointer rounded bg-blue-500 px-4 py-2 text-sm hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Add Appointment
                </button>
            </form>

            <div v-if="tracker.appointments.length === 0" class="text-sm text-muted-foreground">
                No appointments scheduled.
            </div>
            <ul v-else class="flex flex-col gap-3">
                <li
                    v-for="appointment in tracker.appointments"
                    :key="appointment.id"
                    class="flex items-center justify-between rounded-md border border-sidebar-border/70 p-3 text-sm dark:border-sidebar-border"
                >
                    <span>{{ formatDate(appointment.appointment_at) }}</span>
                    <Form
                        :action="DeleteTrackerAppointmentController({ tracker: tracker.id, appointment: appointment.id })"
                        method="delete"
                    >
                        <button
                            type="submit"
                            class="cursor-pointer rounded bg-red-500 px-2 py-1 text-xs hover:bg-red-700"
                        >
                            Remove
                        </button>
                    </Form>
                </li>
            </ul>
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
