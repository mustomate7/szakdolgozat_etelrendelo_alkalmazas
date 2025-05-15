<script setup>
import {Head, Link} from "@inertiajs/vue3";
import CartContent from "@/Pages/Cart/CartContent.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {useCartStore} from "@/stores/cartStore.js";
import {useMenuStore} from "@/stores/menuStore.js";
import {computed, ref} from "vue";

const cartStore = useCartStore();
const menuStore = useMenuStore();

cartStore.listCartItems();

</script>

<template>
    <Head title="Cart"/>
    <GuestLayout>
        <h1 class="text-xl">Kosár tartalma</h1>
        <div class="w-2/3 h-100">
            <CartContent v-for="item in cartStore.items" :item="item"/>
            <div class="mt-6 mb-6 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg min-h-fit">
                <div class="grid grid-cols-3 grid-rows-1 gap-1">
                    <div class="text-left m-4">Összesítés</div>
                    <div class="text-center m-4">Teljes összeg: {{ cartStore.getTotalValues().price }} Ft</div>
                    <div class="text-right m-4">Termékek száma: {{ cartStore.getTotalValues().quantity }}</div>
                </div>
            </div>
        </div>
        <div class="flex justify-between  w-2/3 mb-5">
            <Link href="/" class="flex items-center">
                <button class="btn btn-outline btn-error">Vissza</button>
            </Link>
            <form method="post" action="/stripe/checkout">
                <button type="submit" class="btn btn-success">Tovább a fizetéshez</button>
            </form>
        </div>
    </GuestLayout>
</template>

<style scoped>

</style>
