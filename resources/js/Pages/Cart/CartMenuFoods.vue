<script setup>
import {useCartStore} from "@/stores/cartStore.js";
import {computed, ref} from "vue";

const cartStore = useCartStore();
const scale = 1.35;

const props = defineProps({
    diameter: {
        required: false,
        default: 200,
        type: Number,
    },
    images: {
        type: Array,
        required: true,
    }
})

const inner = computed(() => props.diameter * scale);
const outerCircle = computed(() => ({width: `${props.diameter}px`, height: `${props.diameter}px`}));
const offset = computed(() => (props.diameter - inner.value) / 2);
const circle = computed(() => ({
    width: `${inner.value}px`,
    height: `${inner.value}px`,
    top: `${offset.value}px`,
    left: `${offset.value}px`,
}));


const firstImage = computed(() => ({
    'background-image': `url(${props.images[0]})`,
    width: `${props.diameter}px`,
    height: `${props.diameter}px`,
    transform: `
        skewY(-30deg)
        translateY(${offset.value}px)`,
}))

const secondImage = computed(() => ({
    'background-image': `url(${props.images[1]})`,
    width: `${props.diameter}px`,
    height: `${props.diameter}px`,
    transform: `
        skewY(-30deg)
        rotate(-120deg)
        translateY(0px)
        translateX(${-offset.value * 1.75}px)`
}))
const thirdImage = computed(() => ({
    'background-image': `url(${props.images[2]})`,
    width: `${props.diameter}px`,
    height: `${props.diameter}px`,
    transform: `
        skewY(-30deg)
        rotate(-240deg)
        translateY(${-offset.value * 1.75}px`
}))

</script>

<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
    <div class="circle-outer" :style="outerCircle">

        <ul class="circle" :style="circle">
            <li>
                <a href="#">
                    <div class="background">
                        <div class="food-image" :style="firstImage"></div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="background">
                        <div class="food-image" :style="secondImage"></div>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <div class="background">
                        <div class="food-image" :style="thirdImage"></div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>

<style scoped>

.circle-outer {
    position: relative;
    border: 1px solid black;
    padding: 0;
    border-radius: 50%;
    list-style: none;
    overflow: hidden;
}

.circle {
    position: absolute;
    border: 1px solid black;
    padding: 0;
    border-radius: 50%;
    list-style: none;
    overflow: hidden;
}

li .background {
    overflow: hidden;
    position: absolute;
    top: 0;
    right: 0;
    width: 50%;
    height: 50%;
    transform-origin: 0% 100%;
}

.food-image {
    object-fit: cover;
    overflow: hidden;
    background-size: cover
}

li:first-child .background {
    transform: rotate(0deg) skewY(30deg);
}

li:nth-child(2) .background {
    transform: rotate(120deg) skewY(30deg);
}

li:nth-child(3) .background {
    transform: rotate(240deg) skewY(30deg);
}
</style>
