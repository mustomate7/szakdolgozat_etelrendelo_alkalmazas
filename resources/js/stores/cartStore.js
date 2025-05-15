import {defineStore} from 'pinia';
import {useMenuStore} from "./menuStore.js";
import {useUserStore} from "./userStore.js";
import {computed} from "vue";
import {useToast} from "vue-toast-notification";

export const useCartStore = defineStore('cartStore', {
    state: () => {
        return {
            items: [],
            foods: [],
        }
    },
    actions: {
        addToCart(menu_id, quantity = 1, isAdded = true) {
            const menuStore = useMenuStore();
            const userStore = useUserStore();
            const toast = useToast();

            userStore.checkLogin();

            fetch('/api/cart/add', {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": userStore.csrf,
                    "Content-Type": "application/json",
                },
                credentials: 'same-origin',
                body: JSON.stringify({menu: menu_id, quantity}),
            })
                .then(response => response.json())
                .then(({data: {menu_id, id, quantity}}) => menuStore.updateCart(menu_id, {id, menu_id, quantity}))
                .then(() => {
                    if (isAdded) {
                        toast.success('Item added to cart!')
                    } else {
                        toast.error('Item removed from cart!')
                    }
                });
        },
        listCartItems() {
            const userStore = useUserStore();

            if (!userStore.getUser()) {
                return;
            }

            fetch('/api/cart/list', {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": userStore.csrf,
                    "Content-Type": "application/json",
                },
                credentials: 'same-origin',
            })
                .then(response => response.json())
                .then(({data: items}) => {
                    this.items = items;
                });
        },
        getTotalValues() {
            const totalValues = {};

            totalValues.price = 0;
            totalValues.quantity = 0;

            totalValues.quantity += this.items.reduce((total, item) => {
                    totalValues.price += item.foods.reduce(
                        (accumulator, currentValue) =>
                            accumulator + currentValue.price * item.quantity, 0);
                    return total + item.quantity;
                }, 0
            );
            return totalValues;
        }
    },
})
