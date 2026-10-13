<template>
    <div class="auth-card">

        <div class="auth-card__header">
            <h2>Вход</h2>
            <p>Войдите, чтобы оставить комментарий</p>
        </div>

        <form @submit.prevent="QuickLogin" class="auth-form">

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    id="email"
                    v-model="email"
                    type="email"
                    placeholder="Введите email"
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>

                <input
                    id="password"
                    v-model="password"
                    type="password"
                    placeholder="Введите пароль"
                    autocomplete="current-password"
                >
            </div>

            <div v-if="errorMessage" class="auth-error">
                {{ errorMessage }}
            </div>

            <button
                type="submit"
                class="auth-button"
            >
                Войти
            </button>

        </form>

    </div>
</template>

<script>
import axios from 'axios';

export default {

    name: 'LoginFront',

    data() {
        return {
            email: '',
            password: '',
            errorMessage: ''
        }
    },

    methods: {

        async QuickLogin() {

            this.errorMessage = '';

            if (!this.email || !this.password) {
                this.errorMessage = 'Заполните все поля';
                return;
            }

            try {

                // CSRF cookie
                await axios.get('/sanctum/csrf-cookie');

                // Авторизация
                const response = await axios.post('/login', {
                    email: this.email,
                    password: this.password
                });

                console.log('LOGIN RESPONSE:', response.data);

                  if (response.data.user) {

            const redirect = this.$route.query.redirect;

            if (redirect) {
                await this.$router.push(redirect);
            } else {
                await this.$router.push('/');
            }
        }


            } catch (error) {

                console.log('LOGIN ERROR:', error);

                this.errorMessage =
                    error.response?.data?.message ??
                    'Ошибка авторизации';
            }
        }
    }
}
</script>

<style scoped>

.auth-card {
    max-width: 500px;
    margin: 40px auto;
    padding: 30px;
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
}

.auth-card__header {
    text-align: center;
    margin-bottom: 25px;
}

.auth-card__header h2 {
    margin: 0 0 8px;
    font-size: 28px;
}

.auth-card__header p {
    margin: 0;
    color: #777;
    font-size: 14px;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 7px;
    font-weight: 600;
    font-size: 14px;
}

.form-group input {
    width: 100%;
    padding: 11px 13px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 15px;
    box-sizing: border-box;
}

.form-group input:focus {
    outline: none;
    border-color: #888;
}

.auth-button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 5px;
    background: #333;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: 0.2s;
}

.auth-button:hover {
    background: #555;
}

.auth-error {
    padding: 10px 12px;
    border-radius: 5px;
    background: #f8d7da;
    color: #842029;
    font-size: 14px;
}

</style>