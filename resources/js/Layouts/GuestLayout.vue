<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from '@inertiajs/vue3';
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";

</script>

<template>
  <NavBar/>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <template v-if="$page.url === '/login' || $page.url === '/register'">
      <div>
        <Link href="/">
          <ApplicationLogo class="w-20 h-20 fill-current text-gray-500"/>
        </Link>
      </div>

      <div
          class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
      >
        <slot/>
      </div>
    </template>
    <template v-else>
      <slot/>
    </template>
  </div>
  <Footer/>
</template>
