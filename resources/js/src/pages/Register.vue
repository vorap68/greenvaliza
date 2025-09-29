<template>
    <div>
        register
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">


                    <div class="card-body">
                        <form @click.prevent>
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" required v-model="name"
                                        autofocus>
                                </div>
                            </div>

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
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm
                                    Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation" required
                                        v-model="password_confirmation">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="NewUser">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import { getCurrentUser } from '../../auth.js';
import { userState } from '../state/userState.js';

export default defineComponent({
    name: "Register",
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        }
    },
    methods: {
        async NewUser() {
            const NewUser = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };
            console.log(NewUser);
            await axios.get('/sanctum/csrf-cookie');
            try {
                const response = await axios.post('/register', NewUser, { withCredentials: true });
                console.log('User registered successfully:', response.data);
                userState.user = await getCurrentUser() || null;
                this.$router.push('/'); // Redirect to login after successful registration
            } catch (error) {
                console.error('Error registering user:', error.response ? error.response.data : error.message);
            }
            this.name = '';
            this.email = '';
            this.password = '';
            this.password_confirmation = '';
        }

    }
})
</script>