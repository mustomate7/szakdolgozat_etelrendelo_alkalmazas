<script setup>

import {Link} from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavBarDropdown from "@/Components/NavBarDropdown.vue";
import {ref} from 'vue';
import HamburgerIcon from "/public/svgs/hamburger.svg";
import CartIcon from "/public/svgs/cart_icon.svg";
import {useCartStore} from "@/stores/cartStore.js";
import {useUserStore} from "@/stores/userStore.js";
import CartPopup from "@/Pages/Cart/CartPopup.vue";

const hide = ref(true);
const userStore = useUserStore();
const cartStore = useCartStore();
cartStore.listCartItems();

function showQuantity() {
  return cartStore.items.reduce(
    (accumulator, currentValue) => accumulator + currentValue.quantity, 0
  );
}

function displayNav() {
  hide.value = !hide.value;
}
</script>

<template>
  <nav
    class="fixed top-0 left-0 w-full z-20 bg-navbar mb-6">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <Link href="/" class="flex items-center">
        <ApplicationLogo height="h-8"/>
        <span class="ml-3 self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
            Ételrendelés
        </span>
      </Link>
      <button @click="displayNav()"
              data-collapse-toggle="navbar-dropdown"
              type="button"
              class="hamburger-btn"
              aria-controls="navbar-dropdown"
              aria-expanded="false"
      >
        <span class="sr-only">Open main menu</span>
        <HamburgerIcon class="w-5 h-5"/>
      </button>
      <div class="w-full md:block md:w-auto" ref="navbar-dropdown" :class="{hidden: hide}">
        <ul class="navbar-list">
          <li>
            <Link href="/about-us" class="link-style">
              Rólunk
            </Link>
          </li>
          <template v-if="userStore.user">
            <li id="cartListElement">
              <Link :href="route('cart')" class="link-style">
                <div class="bg-red-500 rounded-full absolute
                                 mt-4 mx-4 w-6 h-6 text-white flex items-center justify-center">
                  <span>{{ showQuantity() }}</span>
                </div>
                <CartIcon class="w-5 h-5"/>
              </Link>
              <div id="cartDiv"
                   class="fixed pt-5 right-0 xl:right-28">
                <div tabindex="0"
                     class="block max-h-96 overflow-y-auto dropdown-content
                     menu p-2 shadow bg-base-100 rounded-box">
                  <CartPopup/>
                </div>
              </div>
            </li>
            <li>
              <NavBarDropdown/>
            </li>
          </template>
          <template v-else>
            <li>
              <Link href="/login" class="link-style">
                Bejelentkezés
              </Link>
            </li>
            <li>
              <Link href="/register" class="link-style">
                Regisztráció
              </Link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
  <div class="menu-margin"></div>
</template>

<style scoped>
#cartDiv {
  display: none;
}

#cartListElement:hover #cartDiv {
  display: block;
}
</style>
