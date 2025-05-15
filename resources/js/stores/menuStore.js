import {defineStore} from 'pinia';
import {useCartStore} from "@/stores/cartStore.js";

export const useMenuStore = defineStore('menuStore', {
    state: () => {
        return {
            menus: [],
            weekStart: '',
        }
    },
    actions: {
        fetchMenu(value = null) {
            let url = '/api/menu';
            url += value ? `/?weekStart=${value}` : ''

            fetch(url, {
                method: 'GET',
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then(response => response.json())
                .then(({data: {menus, weekStart}}) => {
                    return [
                        this.menus = menus,
                        this.weekStart = weekStart,
                    ]
                });
        },
        updateCart(menu_id, cart) {

            const cartStore = useCartStore();
            cartStore.listCartItems();
            this.menus = this.menus.map(item => {
                if (item.id === menu_id) {
                    item.cartItem = cart;
                }
                return item;
            });
        },
    },
})
