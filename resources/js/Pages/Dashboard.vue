<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <Head title="Tablero" />

    <AuthenticatedLayout>

        <Link :href="route('Tests')">
        <div class="w-1/5 h-40 flex items-center justify-center text-white border-black-2">
            <span class="material-symbols-outlined">
                quiz
            </span>
        </div>
        </Link>


    </AuthenticatedLayout>
</template>
