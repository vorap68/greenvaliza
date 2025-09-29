<template>
  <header class="m-auto p-3 mb-2 text-white">
    <ul class="nav jasa-nav-pills justify-content-center">
      <li v-if="!user" class="nav-item">
        <router-link to="/login" class="nav-link active">Login</router-link>
      </li>
      <li v-if="!user" class="nav-item">
        <router-link to="/register-user" class="nav-link">Register</router-link>
      </li>
      <li v-if="user" class="nav-item">
        <router-link to="/all-users" class="nav-link">All_Users</router-link>
      </li>
      <li class="nav-item">
        <router-link to="/check-user" class="nav-link">Check User</router-link>
      </li>
      <li v-if="user" class="nav-item">
        <a href="#" @click.prevent="logoutUser" class="nav-link">
          Logout: {{ user.user.email }}
        </a>
      </li>
    </ul>
  </header>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import { userState } from '../state/userState.js';

export default defineComponent({
  name: 'PrimaryHeader',

  computed: {
    user() {
      return userState.user; // ← теперь только computed
    }
  },

  mounted() {
    // Проверяем пользователя при монтировании компонента
    console.log('PrimaryHeader mounted, user:', this.user);

  },

  methods: {
    logoutUser() {
      axios.post('/logout', {}, { withCredentials: true })
        .then(() => {
          userState.user = null; // ← очищаем реактивный объект
          this.$router.push('/login');
        })
        .catch(error => {
          console.error('Logout failed:', error);
        });
    }
  }
});
</script>
