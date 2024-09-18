<script setup>
import { defineProps, ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    pregunta: Array
});

// Acceder al primer elemento del array "pregunta"
var preguntaActual = props.pregunta[0];

console.log(preguntaActual);

function CorregirPregunta(respuesta, preguntaid) {

    var respuestaDOM = document.getElementById(respuesta);

    if (respuestaDOM.classList.contains("Disabled")) {
        return;
    }

    if (respuestaDOM.classList.contains("is-it")) {
        respuestaDOM.style.backgroundColor = '#7ee279';
        //Aqui
    } else {
        respuestaDOM.style.backgroundColor = '#ec6363';
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

// Funcion para recargar una pagina
function RecargarPagina() {
    window.location.reload()
}

// Funcion para mezclar un array
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]]; // Intercambia elementos
  }
  return array;
}

</script>

<style scoped>
/* Asegura que la lista de respuestas esté en letras minúsculas */
.list-alpha {
    list-style-type: lower-alpha;
}
</style>

<template>

    <GuestLayout>
        
        <!-- Apartado donde se muestra la pregunta y sus respuestas -->
        <h3 class="text-xl font-bold">{{ preguntaActual.enunciado }}</h3>
        <ol class="list-inside list-alpha pl-5">
            <li v-for="respuesta in shuffleArray(preguntaActual.respuestas)" :id="respuesta.id"
                class="cursor-pointer border w-11/12 p-3 rounded-md m-2 shadow"
                :class="{ 'is-it': respuesta.correcta == 1 }" :data-id="preguntaActual.id"
                @click="CorregirPregunta(respuesta.id, preguntaActual.id)">
                {{ respuesta.respuesta }}
            </li>
        </ol>

        <!-- Apartado explicacion de la pregunta -->
        <div class="hidden" id="ExplicacionPregunta">
            <h2 class="text-xl mt-5">Explicacion pregunta</h2>
            <p>{{ preguntaActual.explicacion }}</p>
        </div>

        <!-- Boton pagina siguiente Test -->
        <div class="flex mt-10">
            <div class="m-auto text-center">
                <PrimaryButton @click="RecargarPagina()">Siguiente pregunta</PrimaryButton>
            </div>

        </div>


    </GuestLayout>

</template>