<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Mejorar Licencia" />

        <h1 class="text-left m-5 text-2xl">MyOpos</h1>
        <p class="m-5">Has alcanzado el maximo de preguntas diarias en la licencia de uso gratuito, espera 24h.</p>
    </AuthenticatedLayout>
</template>
