<template>
  <!-- Header всегда сверху -->
  <HeaderMenu />

  <!-- Фон начинается ЗДЕСЬ -->
  <div class="page-background">
    <div class="site-content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <main class="site-main">
              <router-view />
            </main>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import HeaderMenu from './front/HeaderMenu.vue'

export default defineComponent({
  name: 'App',
  components: {
    HeaderMenu,
  },
})
</script>

<style>
/* Фон начинается строго под header */
.page-background {
  background-image: url('/storage/images/categoryMain/fon.jpg');
  background-position: center top;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% auto;
  min-height: 100vh;
}

/* Чтобы контент читался */
.site-content {
  padding-top: 30px;
  padding-bottom: 40px;
}
</style>