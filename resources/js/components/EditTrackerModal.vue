<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import TrackerController from '@/actions/App/Http/Controllers/TrackerController';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import Input from '@/components/ui/input/Input.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectGroup from '@/components/ui/select/SelectGroup.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import type { Category, Tracker } from '@/types/tracker';

defineProps<{
    tracker: Tracker;
    categories: Category[];
}>();

const isOpen = defineModel<boolean>('isOpen');
</script>

<template>
    <Dialog :open="isOpen" @update:open="isOpen = $event">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>Edit Tracker</DialogTitle>
            </DialogHeader>
            <Form
                :action="TrackerController.update(tracker.id)"
                method="put"
                class="flex flex-col gap-4"
                #default="{ errors }"
                @success="isOpen = false"
            >
                <div v-if="errors.name" class="text-red-500">
                    {{ errors.name }}
                </div>
                <Input
                    type="text"
                    name="name"
                    :default-value="tracker.name"
                    placeholder="Tracker name"
                />
                <div class="flex flex-col gap-1">
                    <label for="next_appointment_at" class="text-sm">Next appointment (optional)</label>
                    <Input
                        type="datetime-local"
                        name="next_appointment_at"
                        id="next_appointment_at"
                        :default-value="tracker.next_appointment_at?.replace(' ', 'T') ?? undefined"
                    />
                </div>
                <Select name="category" :default-value="tracker.category.id">
                    <SelectTrigger>
                        <SelectValue placeholder="Select category" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Button type="submit" class="cursor-pointer">Save</Button>
            </Form>
        </DialogContent>
    </Dialog>
</template>
