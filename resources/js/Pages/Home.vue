<script setup>

import {Head} from "@inertiajs/vue3";
import {useMenuStore} from "@/stores/menuStore.js";
import {computed} from "vue";
import uniq from 'lodash.uniq';
import Menus from "@/Components/Menus.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import LeftArrow from '/public/svgs/chevron_left.svg';
import RightArrow from '/public/svgs/chevron_right.svg';
import Slider from "@/Components/Slider.vue";
import MenuModal from "@/Components/MenuModal.vue";
import moment from "moment";

const menuStore = useMenuStore();
menuStore.fetchMenu();

const menu = computed(() => (type) => menuStore.menus.filter(m => m.name === type))
const menuTypes = computed(() => uniq(menuStore.menus.map(x => x.name)))

</script>

<template>
  <Head title="Home"/>

  <GuestLayout>
    <div class="container mx-auto dark:text-white py-3">
      <div class="my-3">
        <p class="text-3xl font-bold text-center">Minden mi szem-szájnak ingere!</p>
      </div>

      <div class="w-1/2 mx-auto mb-8">
        <Slider/>
      </div>

      <h2 class="text-3xl font-bold text-center">Válasszon a menük közül!</h2>
        <div class="grid mb-2">
          <div class="flex mx-auto md:mx-0 text-center p-2">
            <div class="p-2 cursor-pointer hover:bg-gray-500 rounded-full transition-all grid-cols-1"
             @click="menuStore.fetchMenu(moment(menuStore.weekStart).subtract(7, 'days').format('Y-M-D'))">
              <LeftArrow class="h-8"/>
            </div>
            <div class="p-2 rounded-full text-lg font-semibold grid-cols-2">
              {{ moment(menuStore.weekStart).format('Y. MM. DD.') }} -
              {{ moment(menuStore.weekStart).add(6, 'days').format('Y. MM. DD.') }}
            </div>
            <div class="p-2 cursor-pointer hover:bg-gray-500 rounded-full transition-all grid-cols-1"
               @click="menuStore.fetchMenu(moment(menuStore.weekStart).add(7, 'days').format('Y-M-D'))">
            <RightArrow class="h-8"/>
          </div>
        </div>
      </div>
      <div class="[&>*:nth-child(1)]:bg-menu-card-a [&>*:nth-child(2)]:bg-menu-card-b [&>*:nth-child(3)]:bg-menu-card-c">
        <template v-for="name in menuTypes">
          <Menus :name="name" :menus="menu(name)"/>
        </template>
      </div>
    </div>
  </GuestLayout>

  <MenuModal/>
</template>
