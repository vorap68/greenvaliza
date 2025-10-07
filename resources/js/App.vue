<template>

  <div class="container">
    <Main />
  </div>
</template>
<script>
import { defineComponent } from 'vue';
import Main from './src/Main.vue';

export default defineComponent({
  name: 'App',
  components: {
    // Heder,
    Main
  },
  data() {
    return {

    }
  },
  methods: {

  }

})
</script>