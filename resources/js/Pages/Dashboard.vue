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



        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="your-link-1" class="w-full h-40 flex items-center justify-center rounded-lg border border-black">
                <div class="w-3/4 h-3/4 flex items-center justify-center bg-white rounded-lg">
                    <span class="material-symbols-outlined text-black text-4xl">quiz</span>
                </div>
            </a>
            <a href="your-link-2" class="w-full h-40 flex items-center justify-center rounded-lg border border-black">
                <div class="w-3/4 h-3/4 flex items-center justify-center bg-white rounded-lg">
                    <span class="material-symbols-outlined text-black text-4xl">star</span>
                </div>
            </a>
        </div>



        

    </AuthenticatedLayout>
</template>
