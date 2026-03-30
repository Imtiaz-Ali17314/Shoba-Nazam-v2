import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user') || 'null'),
        token: localStorage.getItem('auth_token'),
    }),
    actions: {
        setUser(user) {
            this.user = user;
            localStorage.setItem('user', JSON.stringify(user));
        },
        setToken(token) {
            this.token = token;
            localStorage.setItem('auth_token', token);
        },
        logout() {
            this.user = null;
            this.token = null;
            localStorage.removeItem('auth_token');
            localStorage.removeItem('user');
        },
    },
});