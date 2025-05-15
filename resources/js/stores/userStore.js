import {defineStore} from 'pinia';
import {usePage} from "@inertiajs/vue3";

export const useUserStore = defineStore('userStore', {
    getters: {
        csrf: () => usePage().props.auth.csrf_token,
        user: () => usePage().props.auth.user,
    },
    actions: {
        checkLogin() {
            if (!this.user) {
                return window.location.href = '/login';
            }
        },
        getUser() {
            return this.user;
        }
    },
})
