/**
* Компонент для админки, который содержит сайд-меню и основной контент
* Внутри основного контента отображается компонент, который соответствует текущему маршруту
* Сайд-меню импортируется из отдельного компонента SiderMenu.vue
* Роуты для админки загружаются в файле router-admin.js и отображаются внутри <router-view />
* Все что я выбираю в SiderMenu.vue (роуты )отображается внутри <router-view /> в этом компоненте
*/
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
        TravelIndex: () => import('./admin/travelPost/index.vue'),
    }

})
</script>
<style scoped>
.content-wrapper {
    height: calc(100vh - 60px);
    overflow-y: auto;
    overflow-x: hidden;
}
</style>