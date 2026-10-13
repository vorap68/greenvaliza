import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loading: false,
        error: null,
    }),

    getters: {
        isAuthenticated: (state) => state.user !== null,
    },

    actions: {

        async login(email, password) {
            this.loading = true;
            this.error = null;

            try {
                // Получаем CSRF cookie
                await axios.get('/sanctum/csrf-cookie');

                // Авторизация
                const response = await axios.post('/login', {
                    email,
                    password
                });

                console.log('LOGIN RESPONSE:', response.data);

                // Получаем текущего пользователя
                await this.getUser();

                return true;

            } catch (error) {

                this.error = error.response?.data?.message
                    ?? 'Ошибка авторизации';

                console.log('LOGIN ERROR:', error);

                return false;

            } finally {
                this.loading = false;
            }
        },


        async getUser() {

            try {

                const response = await axios.get('/api/user');

                this.user = response.data;

                return this.user;

            } catch (error) {

                this.user = null;

                return null;
            }
        },


        async logout() {

            try {

                await axios.post('/logout');

            } finally {

                this.user = null;
            }
        }
    }
});