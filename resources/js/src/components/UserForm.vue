<template>
    <form @submit.prevent>
        <input type="text" v-model="name" placeholder="Name" class="form-control mb-3" />
        <input type="email" v-model="email" placeholder="Email" class="form-control mb-3" />
        <input type="password" v-model="password" placeholder="Password" class="form-control mb-3" />
        <button type="submit" class="btn btn-primary" @click="NewUser">Add User</button>
    </form>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    name: "UserForm",
    data() {
        return {
            name: '',
            email: '',
            password: '',
        }
    },
    methods: {
        NewUser() {
            const NewUser = {
                name: this.name,
                email: this.email,
                password: this.password,
            };
            console.log('Adding user:', NewUser);
            this.$emit('add-new-user', NewUser);
            this.name = '';
            this.email = '';
            this.password = '';
        }
    }
})
</script>