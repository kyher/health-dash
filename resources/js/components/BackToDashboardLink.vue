<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { MoveLeft } from 'lucide-vue-next';
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';
</script>

<template>
    <Link :href="DashboardController()" class="mx-3 flex gap-2">
        <MoveLeft /> Back to dashboard
    </Link>
</template>
