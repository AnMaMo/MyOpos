<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Definimos el array que llega desde el constructor
const props = defineProps({
    preguntas: Array // Definir el tipo de prop
});

</script>

<template>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <Head title="Preguntes" />

    <AuthenticatedLayout>

        <table class="border-collapse border border-gray-800 w-full">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="border border-gray-600 p-2">Id</th>
                    <th class="border border-gray-600 p-2">Enunciado</th>
                    <th class="border border-gray-600 p-2"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(pregunta, index) in preguntas" :key="index">
                    <td class="border border-gray-600 p-2">{{ pregunta.Id }}</td>
                    <td class="border border-gray-600 p-2">{{ pregunta.enunciado }}</td>
                    <td class="border border-gray-600 p-2">EDITAR | ELIMINAR</td>
                </tr>
            </tbody>
        </table>



    </AuthenticatedLayout>
</template>