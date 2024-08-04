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

        <!--         <Link :href="route('Tests')">
        <div class="w-1/5 h-40 flex items-center justify-center text-white border-black-2">
            <span class="material-symbols-outlined">
                quiz
            </span>
        </div>
        </Link> -->



        <div class="flex h-screen">
            <a href="/Tests" class="m-10 text-center">
                <span class="material-symbols-outlined text-black" style="font-size: 100px;">quiz</span>
                <h3 class="text-center">Tests</h3>
            </a>
        </div>





    </AuthenticatedLayout>
</template>
