<script setup>
import moment from 'moment';
import {useFoodStore} from "@/stores/foodModal.js";
import {useCartStore} from "@/stores/cartStore.js";

const foodStore = useFoodStore();
const cartStore = useCartStore();

moment.locale('hu');
moment.updateLocale('hu', {
  weekdays : [
    "Vasárnap", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat"
  ]
});

defineProps({
  dailymenu: {
    disabled: Boolean,
    required: true,
  },
});
</script>

<template>
  <div class="text-center border rounded-md hover:shadow-lg p-2 bg-gray-100 bg-opacity-30 group
  transition-all duration-300">
      <div class="inline-block">
          <div class="font-bold text-lg bg-bottom bg-gradient-to-r from-gray-700 to-gray-700 bg-[length:0%_2px] bg-no-repeat
    group-hover:bg-[length:100%_2px] transition-all duration-300">
              {{ moment(dailymenu.week_day).format('dddd') }}
          </div>
      </div>
    <div class="py-2">
      <template v-for="food in dailymenu.foods">
        <div class="mb-3 cursor-pointer hover:text-red-700"
             v-on:click="foodStore.open(food.foodImage, food.name)">
          <p class="font-medium text-lg">{{ food.food_category.name }}</p>
          <p>{{ food.name }}</p>
        </div>
      </template>
    </div>
    <div class="text-right">
      <button :disabled="dailymenu.disabled" class="btn btn-sm dark:text-white text-center"
              v-on:click="cartStore.addToCart(dailymenu.id,dailymenu.cartItem?.quantity + 1)">
        <span v-show="dailymenu.cartItem?.quantity">{{ dailymenu.cartItem?.quantity }}</span>
        Cart
      </button>
    </div>
  </div>
</template>
