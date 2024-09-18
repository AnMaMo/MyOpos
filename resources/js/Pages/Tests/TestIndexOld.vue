<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head } from '@inertiajs/vue3';

// Crear un array con 10 elementos
const items = Array.from({ length: 5 });

// Función para redirigir a una URL
const redirectTo = (url) => {
    window.location.href = url;
};


</script>

<template>

    <Head title="Tests" />

    <GuestLayout>

        <!--Div principal-->
        <div class="w-3/4 mt-5 m-auto">
            <div class="flex justify-between">
                <PrimaryButton @click="redirectTo('/TestActivo')">Iniciar Test</PrimaryButton>
                <PrimaryButton @click="redirectTo('/Preguntas')">Administrar preguntas</PrimaryButton>
            </div>

            <h2 class="mt-5 mb-5 text-2xl">Testos Realitzats</h2>

            <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200">Data i Hora</th>
                    <th class="py-2 px-4 bg-gray-200">Nota</th>
                    <th class="py-2 px-4 bg-gray-200"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">2023-07-25 14:30</td>
                    <td class="border px-4 py-2">Apte</td>
                    <td class="border px-4 py-2 text-center"><PrimaryButton class="">Visualizar</PrimaryButton></td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">2023-08-03 09:15</td>
                    <td class="border px-4 py-2">No Apte</td>
                    <td class="border px-4 py-2 text-center"><PrimaryButton class="">Visualizar</PrimaryButton></td>                </tr>
                <tr>
                    <td class="border px-4 py-2">2023-06-12 18:45</td>
                    <td class="border px-4 py-2">Apte</td>
                    <td class="border px-4 py-2 text-center"><PrimaryButton class="">Visualizar</PrimaryButton></td>                </tr>
            </tbody>
        </table>

        </div>

    </GuestLayout   >
</template>