<script setup>

import MenuCard from "@/Components/MenuCard.vue";

defineProps({
  name: {
    type: String,
    required: true,
  },
  menus: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <div
      class="mx-auto grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-4 p-4 border-2 border-black dark:border-gray-400 rounded-[10px]">
    <div class="md:grid-cols-2 text-center flex justify-center items-center">
      <div>
        <p class="mb-3 text-xl font-semibold">{{ name }}</p>
<!--        <button class="btn btn-md dark:text-white">Order Menu</button>-->
      </div>
    </div>
    <template v-for="menu in menus">
      <MenuCard :dailymenu="menu"></MenuCard>
    </template>
  </div>
</template>
