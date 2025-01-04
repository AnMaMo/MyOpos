<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

// Definimos las propiedades que nos llegaran desde el controlador.
const props = defineProps({
    preguntas: Array,
    rol: Number,
});

// Constantes de clases.
const preguntas = ref(props.preguntas);
const rol = ref(props.rol);
const respuestas = ref([]);
const isModaAddPreguntalVisible = ref(false);
const isModaAddRespuestaVisible = ref(false);
const preguntaSeleccionada = ref(0);

/**
 * Funcion que se ejecuta cuando la vista esta cargada
 */
$(document).ready(function () {

    console.log(rol.value);

    $('#tablaPreguntas').DataTable({
        "columns": [
            { "data": "id" },
            { "data": "enunciado" },
            { "data": "explicacion" },
            {
                "data": null,
                "render": function (data, type, row) {
                    return `
                    <button class="btn btn-danger" onclick="EliminarPregunta(${row.id})"><span class="material-symbols-outlined">delete</span></button>
                    <button class="btn btn-danger" onclick="SeleccionarPregunta(${row.id})"><span class="material-symbols-outlined">reply</span></button>`;
                }
            },

        ],
        language: {
            search: '', // Elimina el texto "Search"
            searchPlaceholder: 'Buscar...', // Placeholder en el cuadro de búsqueda
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros', // Cambia el texto "info"
            infoEmpty: 'No hay registros disponibles', // Cuando no hay datos
            infoFiltered: '(filtrado de _MAX_ registros totales)', // Para datos filtrados
            paginate: {
            first: 'Primero',
            last: 'Último',
            next: 'Siguiente',
            previous: 'Anterior'
        },
        },
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 5,
    });

    RecargarPreguntas();
});


//#region Preguntas

/**
 * Function Añadir pregunta, Añade una pregunta a la BBDD.
*/
function añadirPregunta() {
    var enunciado = $("#enunciado").val();
    var explicacion = $("#explicacion").val();

    // Validaciones
    if (enunciado === "") {
        showToast("Debes introducir un enunciado.", "error");
        return;
    }
    if (explicacion === "") {
        showToast("Debes introducir una explicacion.", "error");
        return;
    }

    // Ajax para añadir una pregunta a la BBDD
    $.ajax({
        url: '/añadir-pregunta',
        type: 'POST',
        data: {
            enunciado: enunciado,
            explicacion: explicacion
        },
        success: function (response) {
            RecargarPreguntas();
            preguntaSeleccionada.value = response.idPregunta;
            RecargarRespuestas(0);
            showToast("Pregunta añadida correctamente.", "success");
            hideAddPreguntaModal();
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

/**
 * Funcion Eliminar pregunta, Elimina una pregunta de la BBDD.
 * @param idpregunta 
 */
window.EliminarPregunta = function (idpregunta) {

    $.ajax({
        url: '/eliminar-pregunta', // Cambia esta ruta a la ruta correcta para tu controlador
        type: 'POST',
        contentType: 'application/json', // Indica que los datos están en formato JSON
        data: JSON.stringify({ id: idpregunta }), // Convierte los datos a JSON
        success: function (response) {
            RecargarPreguntas();
            RecargarRespuestas(0);
            showToast("Pregunta eliminada correctamente.", "success");

        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });

}

/**
 * Funcion Seleccionar Pregunta, Selecciona una pregunta para cargar sus respuestas.
 * @param idPregunta 
 */
window.SeleccionarPregunta = function (idPregunta) {

    // Aqui cargaremos las respuestas de la pregunta seleccionada
    preguntaSeleccionada.value = idPregunta;
    RecargarRespuestas(idPregunta);
}

/**
 * Funcion Recargar Preguntas, recarga el grid de preguntas.
 */
function RecargarPreguntas() {
    // Ajax para actualizar la lista de preguntas
    $.ajax({
        url: '/preguntas', // Cambia esta ruta a la ruta correcta para tu controlador
        type: 'GET',
        contentType: 'application/json', // Convierte los datos a JSON
        success: function (response) {
            preguntas.value = response;

            var table = $('#tablaPreguntas').DataTable();
            table.clear();
            table.rows.add(response);
            table.draw();
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

/**
 * Funcion Show Add Pregunta Modal, muestra el modal de añadir una pregunta.
 */
function showAddPreguntaModal() {
    isModaAddPreguntalVisible.value = true;
}

/**
 * Funcion Hide Add Pregunta Modal, muestra el modal de añadir una pregunta.
 */
function hideAddPreguntaModal() {
    isModaAddPreguntalVisible.value = false;
    // Resetear los inputs
    $("#enunciado").val("");
    $("#explicacion").val("");
}

//#endregion

//#region Respuestas

/**
 * Funcion para añadir una respuesta a una pregunta ya existente
 */
function añadirRespuesta() {

    // se cojen los campos de los input
    var respuesta = document.getElementById("respuesta").value;
    var correcta = document.getElementById("correcta").checked;
    var idPregunta = preguntaSeleccionada.value;

    if (correcta == true) {
        correcta = 1;
    } else if (correcta == false) {
        correcta = 0;
    }


    // Peticion ajax que añada la respuesta a la pregunta seleccionada
    $.ajax({
        url: '/añadir-respuesta',
        type: 'POST',
        data: {
            respuesta: respuesta,
            correcta: correcta,
            idPregunta: idPregunta
        },
        success: function (response) {

            console.log(response.correcta);

            if (response.mensaje == "true") {
                showToast("respuesta añadida correctamente.", "success");
                hideAddRespuestaModal();
                RecargarRespuestas(idPregunta);
            } else {
                showToast("No se ha podido añadir la respuesta.", "error");
                hideAddRespuestaModal();
            }
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

/**
 * Funcion para eliminar una respuesta
 * @param idRespuesta 
 */
function removeRespuesta(idRespuesta) {
    $.ajax({
        url: '/eliminar-respuesta',
        type: 'POST',
        data: {
            idRespuesta: idRespuesta
        },
        success: function (response) {
            showToast("Respuesta eliminada correctamente.", "success");
            RecargarRespuestas(preguntaSeleccionada.value);
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

/**
 * Funcion recargar respuestas del grid de respuestas con la pregunta seleccionada.
 * @param idPregunta
 */
function RecargarRespuestas(idPregunta) {

    // 0 Para limpiar el listado.
    if (idPregunta == 0) {
        respuestas.value = [];
        return;
    }

    // Ajax para recargar el listado de respuestas
    $.ajax({
        url: '/get-respuestas-idpregunta',
        type: 'POST',
        data: {
            idPregunta: idPregunta
        },
        success: function (response) {
            console.log(response);
            respuestas.value = response;
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

/**
 * Funcion Show Add Respuesta Modal, muestra el modal de añadir una pregunta.
 */
function showAddRespuestaModal() {
    if (preguntaSeleccionada.value == 0) {
        showToast("Debes seleccionar una pregunta.", "error");
        return;
    }

    isModaAddRespuestaVisible.value = true;
}

/**
 * Funcion Hide Add Respuesta Modal, muestra el modal de añadir una pregunta.
 */
function hideAddRespuestaModal() {
    isModaAddRespuestaVisible.value = false;
    // Resetear los inputs
    document.getElementById("respuesta").value = "";
    document.getElementById("correcta").checked = false;
}

//#endregion

</script>

<template>

    <Head title="Preguntes" />
    <AuthenticatedLayout>

        <div class="flex flex-col w-3/4 m-auto mt-5 text-center pb-10">

            <div class="barraHerramientas flex items-center">
                <!-- Título más grande -->
                <h2 class="text-xl font-bold mr-4">Listado de Preguntas</h2>

                <!-- Botón para agregar preguntas -->
                <PrimaryButton @click="showAddPreguntaModal" class="m-1 flex items-center">
                    <span class="material-symbols-outlined">add</span>
                    <span class="ml-2">Agregar Pregunta</span>
                </PrimaryButton>
            </div>

            <!-- Datatable de preguntas -->
            <div id="app">
                <table id="tablaPreguntas" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Enunciado</th>
                            <th>Explicación</th>
                            <th>Herramientas</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="barraHerramientas flex items-center mt-10">
                <!-- Título más grande -->
                <h2 class="text-xl font-bold mr-4">Respuestas pregunta Nº: {{ preguntaSeleccionada }}</h2>

                <!-- Botón para agregar preguntas -->
                <PrimaryButton @click="showAddRespuestaModal" class="m-1 flex items-center">
                    <span class="material-symbols-outlined">add</span>
                    <span class="ml-2">Agregar Respuesta</span>
                </PrimaryButton>
            </div>

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
                                <button @click="removeRespuesta(respuesta.id)"><span
                                        class="material-symbols-outlined">delete</span></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal Añadir Pregunta -->
        <div v-show="isModaAddPreguntalVisible"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">

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

                </div>

                <!-- Botón para cerrar el modal -->
                <div class="mt-4 text-center">
                    <button class="bg-gray-700 m-1 text-white px-4 py-2 rounded hover:bg-gray   -600"
                        @click="añadirPregunta()">Crear pregunta</button>
                    <button @click="hideAddPreguntaModal()"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>

        <!-- Modal Añadir Respuesta -->
        <div v-show="isModaAddRespuestaVisible"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">

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
                </div>

                <!-- Botón para cerrar el modal -->
                <div class="mt-4 text-center">
                    <button class="bg-gray-700 m-1 text-white px-4 py-2 rounded hover:bg-gray   -600"
                        @click="añadirRespuesta()">Añadir Respuesta</button>
                    <button @click="hideAddRespuestaModal()"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>