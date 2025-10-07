<template>
  <h1>All Users</h1>
  <user-form @add-new-user="AddUser" />
  <table class="table">
    <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
      </tr>
    </thead>
    <tbody>
      <user-item v-for="user in users" :user="user" @user-deleted="GetUsers" />


    </tbody>
  </table>

</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import UserForm from '../components/UserForm.vue';
import UserItem from '../components/UserItem.vue';
import { userState } from '../state/userState';
import { getCurrentUser } from '../../auth.js';

export default defineComponent({
  name: 'AllUsers',
  components: {
    UserForm,
    UserItem,
  },
  data() {
    return {
      users: [],
      name: '',
      email: '',
      password: '',
    }
  },

  mounted() {
    this.GetUsers();
  },

  methods: {

    async GetUsers() {
      try {
        const response = await axios.get('/users');
        this.users = response.data.data;
        console.log('Ответ от сервера:', response.data);
        userState.user = await getCurrentUser() || null;
      } catch (error) {
        console.error('Ошибка загрузки пользователей:', error);
      }
    },


    AddUser(user) {
      console.log('Adding user from child component:', user);
      axios.post('/add-user', {
        name: user.name,
        email: user.email,
        password: user.password,
      })
        .then(response => {
          this.GetUsers();
          console.log('User added:', response.data);
          user.name = '';
          user.email = '';
          user.pasword = '';
        });

    }

  },

})

</script>