<script setup>
import { defineProps, ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  preguntas: Array // Definir el tipo de prop
});

function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]]; // Intercambia elementos
  }
  return array;
}

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

    <div class=" w-11/12 m-auto">
      <!-- Cargar preguntas y respuestas -->
      <div class="p-4">
        <ol class="list-decimal pl-5">
          <li v-for="(pregunta, index) in shuffleArray(preguntas)" :key="pregunta.id" class="mt-5">
            <h3 class="text-xl font-bold">{{ pregunta.enunciado }}</h3>
            <ol class="list-inside list-alpha pl-5">
              <li v-for="respuesta in shuffleArray(pregunta.respuestas)" :id="respuesta.id" class="cursor-pointer border w-11/12 p-3 rounded-md m-2 shadow"
                :class="{ 'is-it': respuesta.correcta == 1 }" :data-id="pregunta.id"
                @click="CorregirPregunta(respuesta.id, pregunta.id)">
                {{ respuesta.respuesta }}
              </li>
            </ol>
          </li>
        </ol>
      </div>


      <p>{{ arrayExample }}</p>

      <!-- botones Test -->
      <div class="flex mt-10">
        <div class="m-auto text-center">
          <PrimaryButton>Descarta Test</PrimaryButton>
        </div>
        <div class="m-auto text-center">
          <PrimaryButton @click="CerrarTest()">Guardar Test</PrimaryButton>
        </div>

      </div>

    </div>

</GuestLayout>

</template>