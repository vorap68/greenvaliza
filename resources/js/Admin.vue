<template>
    <div class="app-wrapper">
        <SiderMenu />
        <main class="app-main">
            <div class="app-content py-3 px-3">
                <router-view />
            </div>
        </main>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import SiderMenu from './admin/SiderMenu.vue';

export default defineComponent({
    name: 'Admin',
    components: {
        SiderMenu,
        TravelIndex: () => import('./admin/travel/index.vue'),
    },
})
</script>
<style scoped>
.content-wrapper {
    height: calc(100vh - 60px);
    overflow-y: auto;
    overflow-x: hidden;
}
</style>