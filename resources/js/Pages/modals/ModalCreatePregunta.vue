<template>
    <div v-if="show" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>Create a New Pregunta</h2>
        <form @submit.prevent="createPregunta">
          <div>
            <label for="enunciado">Enunciado:</label>
            <input type="text" v-model="enunciado" required>
          </div>
          <div>
            <label for="fallada">Fallada:</label>
            <input type="number" v-model="fallada" required>
          </div>
          <button type="submit">Create</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        show: false,
        enunciado: '',
        fallada: 0
      };
    },
    methods: {
      openModal() {
        this.show = true;
      },
      closeModal() {
        this.show = false;
      },
      async createPregunta() {
        try {
          await axios.post('/api/preguntas', {
            enunciado: this.enunciado,
            fallada: this.fallada
          });
          this.closeModal();
          this.$emit('preguntaCreated');
        } catch (error) {
          console.error('Error creating pregunta:', error);
        }
      }
    }
  };
  </script>
  
  <style>
  .modal {
    display: block;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }
  
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }
  
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  </style>