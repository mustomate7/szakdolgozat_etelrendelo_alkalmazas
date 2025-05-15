<script setup>

import Modal from "@/Components/Modal.vue";
import {useFoodStore} from "@/stores/foodModal.js";

const foodStore = useFoodStore();

</script>

<template>
  <Modal :show="foodStore.show" @close="foodStore.$reset()">
    <div class="flex items-center justify-center w-full h-[85vh] sm:min-h-[50vh] bg-gray-300 rounded dark:bg-gray-700">
      <div class="absolute top-0 right-0 p-4">
        <button @click="foodStore.$reset()">Close</button>
      </div>
      <div class="h-52 sm:h-96 w-3/4 bg-no-repeat bg-cover bg-center"
           :style="`background-image: url('${foodStore.foodImage}')`">
      </div>
      <div class="absolute bottom-0 p-4">
        {{ foodStore.foodName }}
      </div>
    </div>
  </Modal>
</template>
