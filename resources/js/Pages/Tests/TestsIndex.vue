<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// Crear un array con 10 elementos
const items = Array.from({ length: 32 });

// Función para redirigir a una URL
const redirectTo = (url) => {
    window.location.href = url;
};



</script>

<template>

    <Head title="Tests" />

    <AuthenticatedLayout>

        <!--Div principal-->
        <div class="w-3/4 mt-5 m-auto">
            <div class="flex justify-between">
                <PrimaryButton @click="redirectTo('/TestActivo')">Iniciar Test</PrimaryButton>
                <PrimaryButton>Admin</PrimaryButton>
            </div>

            <h2 class="mt-5 text-xl">Llistat de testos fets</h2>

            <div v-for="(item, index) in items" :key="index">



                <span>Test numero {{ index + 1 }}</span>
            </div>

        </div>

    </AuthenticatedLayout>
</template>