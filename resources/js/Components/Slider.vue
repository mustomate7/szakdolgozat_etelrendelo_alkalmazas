<script setup>
import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/css';
import {Autoplay} from 'swiper/modules';

let pictures = ['/images/food1.jpg', '/images/food2.jpg', '/images/food3.jpg'];
let modules = [Autoplay];

</script>

<template>
  <swiper
      :speed="500"
      :centeredSlides="true"
      :autoplay="{delay: 4500, disableOnInteraction: false}"
      :modules="modules"
      class="mySwiper border-1 border-gray-500 h-[40vh] rounded-[20px]"
  >
    <swiper-slide v-for="path in pictures">
      <img :src="path" alt="foods" class="image-full">
    </swiper-slide>
  </swiper>
</template>

<style scoped>
swiper-slide {
  background-position: center;
  background-size: contain;
}

.swiper-slide img {
  display: block;
  width: 100%;
}
</style>
