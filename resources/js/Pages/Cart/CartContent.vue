<script setup>
import {useCartStore} from "@/stores/cartStore.js";
import {useMenuStore} from "@/stores/menuStore.js";
import CartMenuFoods from "@/Pages/Cart/CartMenuFoods.vue";
import {ref} from "vue";

const cartStore = useCartStore();
const menuStore = useMenuStore();
// const diameterValue = ref(150);

defineProps({
  item: {
    week_day: String,
    name: String,
    quantity: Number,
    price: Number,
    menu_id: String,
    foods: Array,
    images: Array,
    required: true,
  },
  food: {
    name: String,
    price: Number,
  }
});

function subTotal(items) {

  const total = items.foods.reduce(
    (accumulator, food) => accumulator + food.price,
    0,
  );
  return total * items.quantity;
}

// function getImageUrls(foods) {
//   return foods.map(food => food?.images[0]?.path ?? '/svgs/placeholder.svg');
// }

</script>

<template>
  <div>
    <div class="mt-6 mb-6 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg min-h-fit">
      <div class="cartElement">
        <div class="grid lg:grid-cols-4 grid-cols-1 items-center text-center py-3">
<!--          <div class="m-auto p-3 flex justify-center">-->
<!--            <CartMenuFoods :diameter="diameterValue"-->
<!--                           :images="getImageUrls(item.foods)"/>-->
<!--          </div>-->
          <div>
            <p>{{ item.name }}</p>
            <p>{{ item.week_day }}</p>
          </div>
          <div class="grid grid-cols-2 grid-rows-3 gap-2">
            <template v-for="food in item.foods" :key="food.id">
              <div>{{ food.name }}</div>
              <div>{{ food.price }} Ft</div>
            </template>
          </div>
          <div>
            <p>Részösszeg</p>
            <p>{{ subTotal(item) }} Ft</p>
          </div>
          <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1 justify-center my-5 lg:my-0">
            <button data-action="decrement"
                    class=" bg-red-200 text-gray-600 hover:bg-red-400 h-full w-10 rounded-l cursor-pointer outline-none"
                    @click="cartStore.addToCart(item.menu_id,item.quantity - 1, false)">
              <span class="m-auto text-2xl font-thin">−</span>
            </button>
            <input type="number"
                   class="dark:bg-gray-800 border-none
                                outline-none focus:outline-none text-center
                                w-12 font-semibold text-md md:text-basecursor-default
                                flex items-center  outline-none remove-arrow"
                   name="custom-input-number"
                   v-model=item.quantity
                   @change="cartStore.addToCart(item.menu_id, item.quantity)">
            <button data-action="increment"
                    class="bg-green-200 text-gray-600 hover:text-gray-700 hover:bg-green-400 h-full w-10 rounded-r cursor-pointer"
                    @click="cartStore.addToCart(item.menu_id,item.quantity + 1)">
              <span class="m-auto text-2xl font-thin">+</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
