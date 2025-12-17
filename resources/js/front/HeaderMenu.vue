<template>

    <div id="content" class="site-content">
        <header id="masthead" class="site-header" role="banner">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12" style="padding-top:10px; padding-bottom:10px;">
                        <div class="site-branding">
                            <div style="text-align: left; margin-bottom: 10px;">
                                <h1
                                    style="text-transform: none; font-size: 24px; margin-bottom: 10px;text-transform: uppercase;">
                                    <a id="blogname" style="color:white;" rel="home" href="http://localhost:8889/"
                                        title="Зеленый чемодан"> Зеленый чемодан </a>
                                </h1>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="flex: 1; text-align: left;">
                                    <h1 style="text-transform: none; font-size: 20px; color: white;"> Если хотим мы
                                        напиться свободы — пакуй зеленый чемодан</h1>
                                </div>
                                <div style="display: flex; justify-content: flex-end;">
                                    <h1 style="color:white; font-size: 20px;" class="btn ">
                                        <a href="https://greenvaliza.co.ua/donate-sum/" style="color:white;"> Помощь
                                            проекту</a>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

</template>
<script>

import { defineComponent } from 'vue';
export default defineComponent({
    name: 'HeaderMenu',
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