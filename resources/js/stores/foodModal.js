import {defineStore} from 'pinia';

export const useFoodStore = defineStore('foodStore', {
    state: () => {
        return {
            show: false,
            foodImage: 'https://picsum.photos/200/300',
            foodName: '',
        }
    },
    actions: {
        open(image, name) {
            this.show = true;
            this.foodName = name;
        },
    },
})
