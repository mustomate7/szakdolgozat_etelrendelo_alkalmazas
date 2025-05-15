<script setup>

import {Head, Link} from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import AboutUsPicture from "/public/svgs/placeholder.svg";

</script>

<template>
  <Head title="About Us"/>

  <GuestLayout>
    <div class="container mx-auto py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-4 p-4">
        <div class="md:grid-cols-6 text-center flex justify-center items-center">
          <div class="flex items-center justify-center w-full h-80 bg-gray-300 rounded sm:w-96 dark:bg-gray-700">
            <AboutUsPicture class="w-10 h-10 text-gray-200 dark:text-gray-600"/>
          </div>
        </div>
        <div class="md:grid-cols-6 text-center flex justify-center items-center">
          <div>
            <p class="font-medium pb-12 text-2xl">Cégünkről</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet aspernatur consequuntur explicabo
              fugit in minima numquam quasi rerum tempora!</p>
          </div>
        </div>
      </div>

      <div class="py-12 bg-blue-100 dark:bg-gray-700">
        <div class="flex pb-6">
          <Link href="/" class="flex items-center mx-auto">
            <ApplicationLogo height="h-20"/>
          </Link>
        </div>
        <p class="text-3xl text-center">Rendeljen tőlünk, nem fogja megbánni!</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-4 p-4 mt-6">
        <div class="md:grid-cols-6 text-center">
          <p class="font-medium text-2xl pb-6">Gyakran Ismételt Kérdések</p>
          <div class="pb-3">
            <p class="font-medium">Kérdés?</p>
            <p>Válasz</p>
          </div>
          <div class="pb-3">
            <p class="font-medium">Kérdés?</p>
            <p>Válasz</p>
          </div>
        </div>
        <div class="md:grid-cols-6 text-center">
          <div>
            <p class="font-medium text-2xl pb-6">Egyéb információk</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet aspernatur consequuntur explicabo
              fugit in minima numquam quasi rerum tempora!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam amet aspernatur consequuntur explicabo
              fugit in minima numquam quasi rerum tempora!</p>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>

</template>
