<template>
    <tr>
        <td>{{ user.id }}</td>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>
            <form @submit.prevent>
                <button type="submit" class="btn btn-warning" @click="DelUser">Delete</button>
            </form>
        </td>
    </tr>

</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';

export default defineComponent({
    name: 'UserItem',
    props: {
        user: {
            type: Object,
            required: true
        }
    },

    methods: {
        DelUser() {
            const UserId = this.user.id;
            // this.$emit('delete-user', UserId);
            //console.log('Deleting user with ID:', UserId);
            axios.delete('/delete-user/' + UserId, { timeout: 10000 })
                .then(response => {
                    console.log('User deleted:', response.data);
                    this.$emit('user-deleted', UserId);
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                });

        }
    }
})
</script>