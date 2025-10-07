<template>
    <h1>Check present user</h1>
    <div v-if="!user">
        <div class="alert alert-danger" role="alert">
            You are not logged in!
        </div>
    </div>
    <div v-else>
        <div class="alert alert-success" role="alert">
            You are logged in as {{ user.user.email }}.
        </div>
    </div>
</template>
<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import { userState } from '../state/userState';


export default defineComponent({
    name: "CheckUser",

    computed: {
        user() {
            return userState.user;
        }
    },
    mounted() {
        this.checkUser();
    },

    methods: {
        async checkUser() {
            try {
                const response = await axios.get('/user-check', { withCredentials: true });
                console.log('User check response:', response.data);
                userState.user = response.data;
                console.log('User check :', userState.user);
            } catch (error) {
                console.error('Error fetching user:', error);
                this.user = null;
            }
        }

    }

});
</script>
