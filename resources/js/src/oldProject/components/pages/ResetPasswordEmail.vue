<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reset Password</div>

                    <div class="card-body">
                        <form @click.prevent>
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" required v-model="email">

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-info" @click="ResetPassword">Send</button>
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
import axios from 'axios';
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'ResetPassword',
    data() {
        return {
            email: '',

        }
    },

    methods: {
        async ResetPassword() {
            // Logic for resetting password goes here
            console.log('Resetting password for:', this.email);
            try {
                const response = await axios.post('/reset-password', { email: this.email }, { withCredentials: true });
                console.log('Response from server:', response.data);
            } catch (error) {
                console.error('Error sending reset password request:', error);
            }
        },
    }
});
</script>