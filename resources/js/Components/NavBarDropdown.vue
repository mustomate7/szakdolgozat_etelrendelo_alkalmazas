<script setup>

import DropdownLink from "@/Components/DropdownLink.vue";
import DropdownArrow from "/public/svgs/dropdown_arrow.svg";
import {ref} from 'vue';
import {useMenuStore} from "@/stores/menuStore.js";

const menuStore = useMenuStore();

const dropdownNavbarLink = ref("");
const dropdownNavbar = ref("");

const translate = ref("");
const hide = ref(true);

function displayDropdown() {
  const button = dropdownNavbarLink.value;
  const position = button.getBoundingClientRect();

  const x = position.x;
  const y = position.y;

  translate.value = `translate(${x},${y})`;
  hide.value = !hide.value;
}
</script>

<template>
  <button @click="displayDropdown()"
          ref="dropdownNavbarLink"
          data-dropdown-toggle="dropdownNavbar"
          class="dropdown-btn">
    {{ $page.props.auth.user.email }}
    <DropdownArrow class="w-2.5 h-2.5 ml-2.5"/>
  </button>
  <!-- Dropdown menu -->
  <div ref="dropdownNavbar"
       class="z-10 font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700
       dark:divide-gray-600 absolute"
       :style="{ transform: translate}"
       :class="{hidden: hide}"
  >
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
      <li>
        <a :href="route('profile.edit')"
           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
          Profil
        </a>
      </li>
    </ul>
    <div class="py-1">
      <DropdownLink :href="route('logout')" method="post" as="button"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600
                    dark:text-gray-400 dark:hover:text-white"
                    @click="menuStore.fetchMenu()">
        Kijelentkezés
      </DropdownLink>
    </div>
  </div>
</template>
