<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

// Definimos el array que llega desde el constructor
const props = defineProps({
    preguntas: Array // Definir el tipo de prop
});

// Creamos un array de respuestas reactivo
const respuestas = ref([]);

// Funcion que añade una respuesta al array reactivo 
function añadirRespuesta() {

    // se cojen los campos de los input
    var respuesta = document.getElementById("respuesta").value;
    var correcta = document.getElementById("correcta").checked;

    // Añadir al array de respuestas de forma reactiva
    respuestas.value.push({
        respuesta: respuesta,
        correcta: correcta ? 1 : 0
    });
}

// Funcion usada para añadir una pregunta a la BBDD
function añadirPregunta() {
    var enunciado = document.getElementById("enunciado").value;
    var explicacion = document.getElementById("explicacion").value;

    var datos = {
        enunciado: enunciado,
        explicacion: explicacion,
        respuestas: respuestas.value
    };

    $.ajax({
        url: '/crear-pregunta', // Cambia esta ruta a la ruta correcta para tu controlador
        type: 'POST',
        contentType: 'application/json', // Indica que los datos están en formato JSON
        data: JSON.stringify(datos), // Convierte los datos a JSON
        success: function (response) {
            window.location.reload();
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

// Funcion para eliminar una pregunta
function EliminarPregunta(idpregunta) {

    $.ajax({
        url: '/eliminar-pregunta', // Cambia esta ruta a la ruta correcta para tu controlador
        type: 'POST',
        contentType: 'application/json', // Indica que los datos están en formato JSON
        data: JSON.stringify({ id: idpregunta }), // Convierte los datos a JSON
        success: function (response) {
            window.location.reload();
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });

}

</script>
<template>

    <Head title="Preguntes" />

    <AuthenticatedLayout>

        <div class="flex flex-col w-3/4 m-auto mt-5 mb-10 text-center">

            <div class="w-auto flex flex-col">
                <!-- Enunciado de pregunta -->
                <label for="enunciado">Enunciado</label>
                <input name="enunciado" type="text" id="enunciado">
            </div>

            <div class="w-auto flex flex-col">
                <!-- Explicacion de la pregunta -->
                <label for="explicacion">Explicacion</label>
                <input name="explicacion" type="text" id="explicacion">
            </div>

            <h2 class="text-xl text-left mt-5">Respuestas</h2>
            <div class="flex flex-row">
                <div class="w-auto flex flex-col">
                    <!-- Explicacion de la pregunta -->
                    <label for="respuesta" class="text-left">Respuesta</label>
                    <input name="respuesta" type="text" id="respuesta">
                </div>
                <div class="w-auto flex flex-row">
                    <!-- Entrada para marcar si es correcta -->
                    <label for="correcta" class="text-left">Correcta</label>
                    <input name="correcta" type="checkbox" id="correcta">
                </div>
            </div>
            <PrimaryButton class="mt-5 w-fit" @click="añadirRespuesta()">Añadir respuesta</PrimaryButton>

            <!-- Tabla de respuestas -->
            <div>
                <table class="mt-5 border-collapse border border-gray-800 w-full">
                    <thead class="bg-gray-700 text-white">
                        <tr>
                            <th>Respuesta</th>
                            <th>Correcta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(respuesta, index) in respuestas" :key="index">
                            <td>{{ respuesta.respuesta }}</td>
                            <td>{{ respuesta.correcta === 1 ? 'Si' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <PrimaryButton class="mt-5" @click="añadirPregunta()">Crear pregunta</PrimaryButton>
        </div>


        <!-- Tabla de preguntas -->
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
                    <td class="border border-gray-600 p-2">{{ pregunta.id }}</td>
                    <td class="border border-gray-600 p-2">{{ pregunta.enunciado }}</td>
                    <td class="border border-gray-600 p-2">
                        <PrimaryButton @click="EliminarPregunta(pregunta.id)">Eliminar</PrimaryButton>
                    </td>
                </tr>
            </tbody>
        </table>



    </AuthenticatedLayout>
</template>