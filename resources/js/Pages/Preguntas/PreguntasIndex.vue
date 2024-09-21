<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

// Definimos las propiedades que nos llegaran desde el controlador.
const props = defineProps({
    preguntas: Array
});

// Constantes de clases.
const preguntas = ref(props.preguntas);
const respuestas = ref([]);

// Funcion updatePreguntas, actualiza el array de preguntas
function updatePreguntas() {
    // Ajax para actualizar la lista de preguntas
    $.ajax({
        url: '/preguntas', // Cambia esta ruta a la ruta correcta para tu controlador
        type: 'GET',
        contentType: 'application/json', // Convierte los datos a JSON
        success: function (response) {
            preguntas.value = response; // Actualiza la lista de preguntas en la vista
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

// Funcion que añade una respuesta al array reactivo 
function añadirRespuesta() {

    // se cojen los campos de los input
    var respuesta = document.getElementById("respuesta").value;
    var correcta = document.getElementById("correcta").checked;

    // Contamos las respuestas y si tiene ya 4 respuests no dejara añadir mas
    if (respuestas.value.length >= 4) {
        alert("Solo puedes añadir 4 respuestas.");
        return;
    }

    // Validar que la respuesta no este vacia
    if (respuesta === "") {
        alert("Debes introducir una respuesta.");
        return;
    }

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

    // Ajax para añadir una pregunta a la BBDD
    $.ajax({
        url: '/crear-pregunta', // Cambia esta ruta a la ruta correcta para tu controlador
        type: 'POST',
        contentType: 'application/json', // Indica que los datos están en formato JSON
        data: JSON.stringify(datos), // Convierte los datos a JSON
        success: function (response) {
            updatePreguntas();
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
            updatePreguntas();
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });

}

// Document ready
$(document).ready(function () {

    // Asignamos el datatable a nuestra tabla de preguntas
    $('#tablaPreguntas').DataTable(
        {
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 5,
        }
    );
});

// Funcion para editar una pregunta
function editarPregunta(idpregunta) {

    // Ajax para obtener la pregunta que se quiere editar
    $.ajax({
        url: '/pregunta/' + idpregunta, // Cambia esta ruta a la ruta correcta para tu controlador
        type: 'GET',
        contentType: 'application/json', // Indica que los datos están en formato JSON
        success: function (response) {
            // Asignamos los valores a los input
            document.getElementById("idPregunta").value = response.id;
            document.getElementById("enunciado").value = response.enunciado;
            document.getElementById("explicacion").value = response.explicacion;
            respuestas.value = response.respuestas;
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

            <!-- Datatable de preguntas -->
            <div id="app">
                <h2 class="text-2xl text-left mt-5">Preguntas</h2>
                <table id="tablaPreguntas" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enunciado</th>
                            <th>Herramientas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pregunta in preguntas" :key="pregunta.id">
                            <td>{{ pregunta.id }}</td>
                            <td>{{ pregunta.enunciado }}</td>
                            <td>
                                <PrimaryButton @click="EliminarPregunta(pregunta.id)">Eliminar</PrimaryButton>
                                <!-- <PrimaryButton @click="editarPregunta(pregunta.id)">Editar</PrimaryButton> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Formulario para crear una pregunta -->
            <div id="formularioCrearPregunta">
                <h2 class="text-2xl text-left mt-5">Crear Pregunta</h2>
                <div class="w-auto flex flex-col">
                    <!-- Enunciado de pregunta -->
                    <label for="enunciado" class="text-left mt-3">Enunciado</label>
                    <input name="enunciado" type="text" id="enunciado">
                </div>
                <div class="w-auto flex flex-col">
                    <!-- Explicacion de la pregunta -->
                    <label for="explicacion" class="text-left mt-3">Explicacion</label>
                    <input name="explicacion" type="text" id="explicacion">
                </div>
                <PrimaryButton class="mt-5 w-fit" @click="añadirPregunta()">Crear pregunta</PrimaryButton>
            </div>

            <!-- Apartado para introducir respuestas a la pregunta -->
            <div id="ApartadoRespuestas">
                <h2 class="text-xl text-left mt-5">Respuestas de la pregunta</h2>

                <div class="flex flex-col">
                    <div class="w-auto flex flex-col">
                        <!-- Explicacion de la pregunta -->
                        <label for="respuesta" class="text-left">Respuesta</label>
                        <input name="respuesta" type="text" id="respuesta">
                    </div>
                    <div class="w-auto flex flex-row items-center">
                        <!-- Entrada para marcar si es correcta -->
                        <label for="correcta" class="text-left">És correcta?</label>
                        <input name="correcta" type="checkbox" id="correcta" class="m-2">
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
                                <th>Herramientas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(respuesta, index) in respuestas" :key="index">
                                <td>{{ respuesta.respuesta }}</td>
                                <td>{{ respuesta.correcta === 1 ? 'Si' : 'No' }}</td>
                                <td>
                                    <PrimaryButton @click="respuestas.splice(index, 1)">Eliminar</PrimaryButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>






    </AuthenticatedLayout>
</template>