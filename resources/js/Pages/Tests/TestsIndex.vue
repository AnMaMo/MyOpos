<script setup>
import { defineProps, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

// Propierties del component.
const props = defineProps({
    pregunta: Array
});

// Variables globales del component.
var preguntaActual = props.pregunta[0];

/**
 * Funcion usada para Corregir la pregunta, se llamara al contestar la pregunta.
 * @param respuesta 
 * @param preguntaid 
 */
function CorregirPregunta(respuesta, preguntaid) {
    var respuestaDOM = document.getElementById(respuesta);

    if (respuestaDOM.classList.contains("Disabled")) {
        return;
    }

    if (respuestaDOM.classList.contains("is-it")) {
        respuestaDOM.style.backgroundColor = '#7ee279';
    } else {
        respuestaDOM.style.backgroundColor = '#ec6363';
        // Marcamos la respuesta correcta en el DOM para que el usuario sepa cual es.
        var respuestacorrect = document.getElementsByClassName("is-it");
        for (let element of respuestacorrect) {
            element.style.backgroundColor = '#7ee279';
        }
    }

    // Seleccionar todos los elementos con el data-id igual a preguntaid
    var elements = document.querySelectorAll(`[data-id='${preguntaid}']`);
    console.log(elements);

    // Remover el evento de clic de cada uno de esos elementos
    elements.forEach(function (element) {
        element.style.cursor = 'default';
        element.classList.add("Disabled");
    });

    // Mostrar la explicacion de las preguntas
    document.getElementById("ExplicacionPregunta").classList.remove("hidden");
    document.getElementById("ExplicacionPregunta").classList.add("visible");
}

/**
 * Funcion usada para recargar la pagina.
 */
function RecargarPagina() {
    window.location.reload()
}

/**
 * Funcion usada para mezclar un array, se usara para mezclar el array de respuestas.
 * @param array 
 */
// Funcion para mezclar un array
function shuffleArray(array) {
    for (let i = array.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [array[i], array[j]] = [array[j], array[i]]; // Intercambia elementos
    }
    return array;
}

</script>


<template>
    <AuthenticatedLayout>

        <!-- Logo de la aplicación -->
        <div>
            <Link href="/Tests">
            <ApplicationLogo class="w-20 h-20 m-auto mt-10 fill-current text-gray-500" />
            </Link>
        </div>

        <!-- Cargamos la pregunta aleatoria que ha tocado en la vista -->
        <div class="w-full sm:w-3/4 lg:w-1/2 m-auto mt-7 border rounded-lg shadow p-5 bg-white" v-if="preguntaActual != null">

            <!-- Apartado donde se muestra la pregunta y sus respuestas -->
            <h3 class="text-xl font-bold">{{ preguntaActual.id }}. {{ preguntaActual.enunciado }}</h3>
            <ol class="list-inside list-alpha">
                <li v-for="respuesta in shuffleArray(preguntaActual.respuestas)" :id="respuesta.id"
                    class="cursor-pointer border p-3 rounded-md mt-2 shadow"
                    :class="{ 'is-it': respuesta.correcta == 1 }" :data-id="preguntaActual.id"
                    @click="CorregirPregunta(respuesta.id, preguntaActual.id)">
                    {{ respuesta.respuesta }}
                </li>
            </ol>

            <!-- Apartado explicacion de la pregunta -->
            <div class="hidden" id="ExplicacionPregunta">
                <h2 class="text-xl mt-5">Explicació pregunta</h2>
                <p>{{ preguntaActual.explicacion }}</p>
            </div>

            <!-- Boton Siguiente pregunta, recarga la pagina. -->
            <div class="flex mt-5">
                <div class="m-auto text-center">
                    <PrimaryButton class="text-2xl" @click="RecargarPagina()">Siguiente pregunta</PrimaryButton>
                </div>
            </div>

            <!-- Boton para reportar una incidencia con la pregunta actual. -->
            <p class="m-auto mt-2 text-center text-gray-400 cursor-pointer" title="Reporta una incidencia amb aquesta pregunta">
                Incidencia
            </p>

        </div>

        <!-- Si no hay pregunta, mostrar mensaje de que no hay preguntas. -->
        <div v-else>
            <p class="text-center text-red-600">Actualmente no hay preguntas disponibles.</p>
        </div>

    </AuthenticatedLayout>
</template>