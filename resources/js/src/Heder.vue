<template>
    <div class="background" :style="{ backgroundImage: `url(${imageUrl})` }">
        <h1>Header</h1>
        <span>background</span>
    </div>
</template>
<script>

import { defineComponent } from 'vue';
export default defineComponent({
    name: 'Heder',
    data() {
        return {
            imageUrl: '/storage/images/categories/fon.jpg'
        }
    },
});


</script>
<style scoped>
.background {
    min-height: 100vh;
    /* на весь экран */
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
}
</style>