<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

// Props del Component.
const props = defineProps({
    preguntas: Array,
    rol: Number,
});

// Variables globales del Component.
const preguntas = ref(props.preguntas);
const rol = ref(props.rol);
const respuestas = ref([]);
const isModaAddPreguntalVisible = ref(false);
const isModaAddRespuestaVisible = ref(false);
const preguntaSeleccionada = ref(0);
const preguntaIdEdit = ref(0);
const respuestaIdEdit = ref(0);

/**
 * Funcion que se ejecuta al cargar la vista.
 * Cargara el datagrid de preguntas.
 */
$(document).ready(function () {

    // DataGrid de preguntas.
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
                    <button class="btn btn-danger" onclick="SeleccionarPregunta(${row.id})"><span class="material-symbols-outlined">reply</span></button>
                    <button class="btn btn-danger" onclick="EditarPreguntaModal(${row.id})"><span class="material-symbols-outlined">edit</span></button>`;
                }
            },

        ],
        language: {
            search: '',
            searchPlaceholder: 'Buscar...',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            infoEmpty: 'No hay registros disponibles',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
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

    // Cargamos el array de preguntas dentro del datagrid.
    RecargarPreguntas();
});

//#region Preguntas

/**
 * Funcion usada para Añadir una pregunta nueva.
 * Al inicio de la funcion, se accede a los datos necesarios, enunciado y explicación.
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
 * Funcion usada para eliminar una pregunta de la BBDD.
 * @param idpregunta Este parametro es la id de la pregunta que queremos eliminar.
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
 * Funcion usada para configurar y abrir el modal de edición de la pregunta,
 * @param idPregunta Este parametro es el id de la pregunta que queremos editar.
 */
 window.EditarPreguntaModal = function (idPregunta) {
    $.ajax({
        url: `/pregunta/${idPregunta}`, // Ruta con el ID en la URL
        type: 'GET', // Método HTTP
        success: function (response) {

            preguntaIdEdit.value = response.id;

            //Rellenamos los campos del modal
            $("#enunciado").val(response.enunciado);
            $("#explicacion").val(response.explicacion);

            // Cambiamos el titulo del modal de preguntas
            $("#ModalPreguntaTitulo").text("Editar Pregunta");

            // Mostramos el modal de editar y escondemos el de crear.
            showAddPreguntaModal();

            // Abrimos el modal de crear pregunta y mostramos el boton de editar, y escondemos el de crear.
            $("#modalpreguntaeditarbtn").removeClass("hidden");
            $("#modalpreguntacrearbtn").addClass("hidden");

        },
        error: function (xhr) {
            console.error("Error al obtener la pregunta:", xhr.responseText);
            alert("No se pudo obtener la pregunta.");
        }
    });
}

/**
 * Funcion usada para configurar y abrir el modal de creacion de una nueva pregunta.
 * @param idPregunta 
 */
 function CrearPreguntaModal(idPregunta) {
    // Cambiamos el titulo del modal de preguntas
    $("#ModalPreguntaTitulo").text("Crear Pregunta");

    showAddPreguntaModal();

    // Mostramos el modal de crear y escondemos el de editar.
    $("#modalpreguntaeditarbtn").addClass("hidden");
    $("#modalpreguntacrearbtn").removeClass("hidden");
}

/**
 * Funcion usada para editar la pregunta, se editará la pregunta que estamos editando en el modal de edicion.
 */
function EditarPregunta() {
    var enunciado = $("#enunciado").val();
    var explicacion = $("#explicacion").val();
    var idPregunta = preguntaIdEdit.value;

    // Validaciones
    if (enunciado === "") {
        showToast("Debes introducir un enunciado.", "error");
        return;
    }
    if (explicacion === "") {
        showToast("Debes introducir una explicacion.", "error");
        return;
    }

    // Ajax para editar una pregunta en la BBDD
    $.ajax({
        url: '/editar-pregunta',
        type: 'POST',
        data: {
            idPregunta: idPregunta,
            enunciado: enunciado,
            explicacion: explicacion
        },
        success: function (response) {
            RecargarPreguntas();
            RecargarRespuestas(0);
            showToast("Pregunta editada correctamente.", "success");
            hideAddPreguntaModal();
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });
}

/**
 * Funcion usada para seleccionar una pregunta, esto cargará el listado de respuestas de esa pregunta en el grid de respuestas.
 * @param idPregunta Este parametro es la id de la pregunta que queremos seleccionar.
 */
window.SeleccionarPregunta = function (idPregunta) {

// Aqui cargaremos las respuestas de la pregunta seleccionada
preguntaSeleccionada.value = idPregunta;
RecargarRespuestas(idPregunta);
}

/**
 * Funcion usada para recargar el grid de preguntas.
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
 * Funcion usada para mostrar el modal de creacion o edicion de preguntas.
 */
function showAddPreguntaModal() {
    isModaAddPreguntalVisible.value = true;
}

/**
 * Funcion usada para esconder el modal de creacion o edicion de preguntas.
 */
function hideAddPreguntaModal() {
    isModaAddPreguntalVisible.value = false;
    preguntaIdEdit.value = -1;
    // Resetear los inputs
    $("#enunciado").val("");
    $("#explicacion").val("");
}

//#endregion

//#region Respuestas

/**
 * Funcion usada para añadir una respuesta a la pregunta seleccionada.
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
 * Funcion usada para eliminar una respuesta de la pregunta seleccionada.
 * @param idRespuesta Este parametro es la id de la respuesta que queremos eliminar.
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
 * Funcion usada para recargar el grid de respuestas, se usara después de cada 
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
 * Funcion usada para configurar y abrir el modal de creacion de una nueva respuesta.
 */
function crearRespuestaModal() {

    // Cambiamos el titulo del modal de preguntas
    $("#ModalRespuestaTitulo").text("Añadir Respuesta");

    showAddRespuestaModal();

    // Mostramos el modal de crear y escondemos el de editar.
    $("#modalrespuestaeditarbtn").addClass("hidden");
    $("#modalrespuestacrearbtn").removeClass("hidden");
}

/**
 * Funcion usada para configurar y abrir el modal de edicion de una respuesta ya existente.
 * @param idRespuesta Este parametro es el id de la respuesta que queremos editar.
 */
function EditarRespuestaModal(idRespuesta) {
    $.ajax({
        url: `/respuesta/${idRespuesta}`,
        type: 'GET',
        success: function (response) {


            respuestaIdEdit.value = response.id;
            document.getElementById("correcta").checked = response.correcta;
            document.getElementById("respuesta").value = response.respuesta;

            // Cambiamos el titulo del modal de preguntas
            $("#ModalRespuestaTitulo").text("Editar Respuesta");

            showAddRespuestaModal();

            // Mostramos el boton de crear y escondemos el de editar.
            $("#modalrespuestaeditarbtn").removeClass("hidden");
            $("#modalrespuestacrearbtn").addClass("hidden");

        },
        error: function (xhr) {
            console.error("Error al obtener la respuesta:", xhr.responseText);
            alert("No se pudo obtener la respuesta.");
        }
    });

}

/**
 * Funcion usada para abrir el modal de edicion y creacion de respuestas.
 */
function showAddRespuestaModal() {
    if (preguntaSeleccionada.value == 0) {
        showToast("Debes seleccionar una pregunta.", "error");
        return;
    }

    isModaAddRespuestaVisible.value = true;
}

/**
 * Funcion usada para cerrar el modal de edicion y creacion de respuestas.
 */
function hideAddRespuestaModal() {
    isModaAddRespuestaVisible.value = false;
    // Resetear los inputs
    document.getElementById("respuesta").value = "";
    document.getElementById("correcta").checked = false;
}

/**
 * Funcion usada para editar una respuesta, se editara la respuesta seleccionada en el modal de edicion
 * Funcion editarRespuesta
 */
 function EditarRespuesta(){
    var respuesta = $("#respuesta").val();
    var correcta = $("#correcta").prop("checked") ? 1 : 0;
    var idRespuesta = respuestaIdEdit.value;
    var idPregunta = preguntaSeleccionada.value;

    // Validaciones
    if (respuesta === "") {
        showToast("Debes introducir una respuesta.", "error");
        return;
    }

    // Ajax para editar una respuesta en la BBDD
    $.ajax({
        url: '/editar-respuesta',
        type: 'POST',
        data: {
            idRespuesta: idRespuesta,
            respuesta: respuesta,
            correcta: correcta,
        },
        success: function (response) {
            preguntaSeleccionada.value = idPregunta;
            RecargarRespuestas(idPregunta);
            showToast("Respuesta editada correctamente.", "success");
            hideAddRespuestaModal();
        },
        error: function (xhr) {
            // Maneja el error aquí
            console.error(xhr.responseText);
        }
    });

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
                <PrimaryButton @click="CrearPreguntaModal()" class="m-1 flex items-center">
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

                <!-- Botón para agregar respuestas -->
                <PrimaryButton @click="crearRespuestaModal()" class="m-1 flex items-center">
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
                                <button @click="EditarRespuestaModal(respuesta.id)"><span
                                        class="material-symbols-outlined">edit</span></button>
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
                    <h2 id="ModalPreguntaTitulo" class="text-2xl text-left">Crear Pregunta</h2>
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

                <!-- Botón para cerrar el modal-->
                <div class="mt-4 text-center">
                    <!--  Crear pregunta -->
                    <button id="modalpreguntacrearbtn"
                        class="bg-gray-700 m-1 text-white px-4 py-2 rounded hover:bg-gray   -600"
                        @click="añadirPregunta()">Crear pregunta</button>
                    <!-- Editar pregunta -->
                    <button id="modalpreguntaeditarbtn"
                        class="bg-gray-700 m-1 text-white px-4 py-2 rounded hover:bg-gray   -600"
                        @click="EditarPregunta()">Editar pregunta</button>
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
                    <h2 id="ModalRespuestaTitulo" class="text-2xl text-left mb-1">Añadir Respuesta</h2>
                    <div class="flex flex-col">
                        <div class="w-auto flex flex-col">
                            <!-- Explicacion de la pregunta -->
                            <label for="respuesta" class="text-left">Respuesta</label>
                            <input name="respuesta" type="text" id="respuesta">
                        </div>
                        <div class="w-auto flex flex-row items-center mt-1">
                            <!-- Entrada para marcar si es correcta -->
                            <label for="correcta" class="text-left">És correcta?</label>
                            <input name="correcta" type="checkbox" id="correcta" class="m-2">
                        </div>
                    </div>
                </div>

                <!-- Botón para cerrar el modal -->
                <div class="mt-4 text-center">
                    <button id="modalrespuestacrearbtn"
                        class="bg-gray-700 m-1 text-white px-4 py-2 rounded hover:bg-gray   -600"
                        @click="añadirRespuesta()">Añadir Respuesta</button>
                    <button id="modalrespuestaeditarbtn"
                        class="bg-gray-700 m-1 text-white px-4 py-2 rounded hover:bg-gray   -600"
                        @click="EditarRespuesta()">Editar Respuesta</button>
                    <button @click="hideAddRespuestaModal()"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>