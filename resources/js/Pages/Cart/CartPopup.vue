<script setup>

import {useCartStore} from "@/stores/cartStore.js";
import {useMenuStore} from "@/stores/menuStore.js";
import {computed} from "vue";

const cartStore = useCartStore();
const menuStore = useMenuStore();
const totalPrice = computed(() => cartStore.getTotalValues().price);

</script>
<template>
  <div v-for="item in cartStore.items" class="w-96">
    <div class="grid grid-cols-3 items-center text-center">
      <div>
        <p>{{ item.name }}</p>
        <p>{{ item.week_day }}</p>
      </div>
      <div class="grid grid-cols-2 grid-rows-3 gap-2">
        <template v-for="food in item.foods">
          <div class="truncate text-overflow ">{{ food.name }}</div>
          <div>{{ food.price }}</div>
        </template>
      </div>
      <div>
        <p class="text-xl">x {{ item.quantity }}</p>
      </div>
    </div>
    <div class="divider mt-2 mb-2"></div>
  </div>
  <div class="text-xl pl-5" v-show="totalPrice !== 0">Total: {{ totalPrice }}</div>
</template>

<style scoped>

</style>
