<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import TrackerController from '@/actions/App/Http/Controllers/TrackerController';
import Button from './ui/button/Button.vue';
import Input from './ui/input/Input.vue';
import Select from './ui/select/Select.vue';
import SelectContent from './ui/select/SelectContent.vue';
import SelectGroup from './ui/select/SelectGroup.vue';
import SelectItem from './ui/select/SelectItem.vue';
import SelectTrigger from './ui/select/SelectTrigger.vue';
import SelectValue from './ui/select/SelectValue.vue';
defineProps<{
    categories: Array<{ id: number; name: string }>;
}>();
</script>

<template>
    <Form
        :action="TrackerController.store()"
        method="post"
        class="flex flex-col gap-4"
        #default="{ errors }"
        reset-on-success
    >
        <div v-if="errors.name" class="text-red-500">
            {{ errors.name }}
        </div>
        <Input type="text" name="name" placeholder="Tracker name" />
        <Select name="category">
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
        <Button type="submit" class="cursor-pointer">Add Tracker</Button>
    </Form>
</template>
