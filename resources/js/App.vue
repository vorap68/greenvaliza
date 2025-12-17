<template>
  <HeaderMenu />

  <div id="content" class="site-content">
    <div class="container">
      <div class="row">
        <!-- <div class="col-md-12"> -->
        <div id="primary" class="content-area">
          <main id="main" class="site-main" role="main">
            <router-view />
          </main>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import HeaderMenu from './front/HeaderMenu.vue';


export default defineComponent({
  name: 'App',
  components: {
    HeaderMenu,
  },

})
</script>