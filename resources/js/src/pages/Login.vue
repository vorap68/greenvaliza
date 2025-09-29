<template>
    <h1>Login</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">


                    <div class="card-body">
                        <form @click.prevent>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" required v-model="email">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control " name="password" required
                                        v-model="password">

                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-info" @click="LoginUser">
                                        Login
                                    </button>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Forgot your password?
                                    <router-link to="/reset-password" class="text-info fw-bold ms-1">
                                        Reset it here
                                    </router-link>
                                </small>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import { getCurrentUser } from '../../auth.js';
import { userState } from '../state/userState.js';

export default defineComponent({
    name: "Login",
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {

        async LoginUser() {
            const userLogin = {
                email: this.email,
                password: this.password
            };
            console.log('User login data_start:', userLogin);
            try {
                const response = await axios.post('/login', userLogin, { withCredentials: true });
                console.log('Login successful:', response.data);
                userState.user = await getCurrentUser() || null;
                console.log('Current user after login:', userState.user);
                this.$router.push('/'); // Redirect to check user page after login
            } catch (error) {
                console.error('Login failed:', error);
                alert('Login failed. Please check your credentials.');
            }

        }
    }
});
</script>