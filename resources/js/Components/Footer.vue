<script setup>

import ApplicationLogo from "@/Components/ApplicationLogo.vue";

function scrollToTop() {
  window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
}
</script>

<template>
    <div class="bg-black text-white p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="flex justify-center items-center p-6">
                <div>
                    <ApplicationLogo height="h-16" class="mx-auto mb-3"/>
                    <p>Ételrendelés</p>
                </div>
            </div>
            <div class="text-center">
                <p class="text-xl p-6">Elérhetőségek</p>
                <p>Email: info@etel.hu</p>
                <p>Tel: +36123123</p>
            </div>
            <div class="text-center">
                <p class="text-xl p-6">Hasznos információk</p>
                <p>ÁSZF</p>
                <p>Adatvédelmi nyilatkozat</p>
            </div>
            <div class="flex justify-center items-center p-6">
                <p @click="scrollToTop" class="hover:cursor-pointer">Az oldal tetejére</p>
            </div>
        </div>
        <div class="container mx-auto text-center mt-6">2025 &copy; Ételrendelés</div>
    </div>
</template>
