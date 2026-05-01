<template>
    <BreadCrumb :parent-slug="'ya-i-moi-knigi'" :parent-title="'Я и мои книги'" :current-title="mybook.title || ''" />

    <div class="post-container-block" :style="{
        /**
        * Устанавливаем фоновое изображение для блока поста. Путь к изображению формируется на основе slug поста.
        * В папке каждого поста должно быть изображение с именем firstfon.jpg, 
        * которое будет использоваться в качестве фонового изображения.
         */
        backgroundImage: `url('/storage/images/travels/${mybook.slug}/firstfon.jpg')`,
        backgroundPosition: 'center',
    }">

        <div class=" content-block">
            <div class="entry-content" v-html="mybook.content">


            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import BreadCrumb from '../BreadCrumb.vue';

/**
 * @typedef {Object} Mybook
 * @property {number} id - The unique identifier of the mybook.
 * @property {string} slug - The slug of the mybook, used for routing and image paths.
 * @property {string} title - The title of the mybook.
 * @property {string} description - A brief description of the mybook.
 * @property {string} content - The full content of the mybook, which may include HTML.
 * @property {string} imageName - The name of the image associated with the mybook,
 */
export default {
    name: 'mybook-post',
    props: [
        /**
           * slug поста, который используется для получения данных о посте и формирования пути к фоновому изображению.
            * @type {string}
           */
        'slug'],

    components: {
        BreadCrumb,
    },

    data() {
        return {
            /**
            * @type {Mybook}
            */
            mybook: {},
        };
    },
    async mounted() {
        console.log(this.slug + " component mounted.");
        await this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                const response = await axios.get(`/api/mybook/${this.slug}`);
                let content = response.data.data.content;
                content = content.replace(/\$\{mybook\.slug\}/g, this.slug);
                //Заменяем все вхождения ${mybook.slug} на фактический this.slug
                this.mybook = {
                    ...response.data.data,
                    content
                };
                if (this.mybook.title) {
                    document.title = this.mybook.title;
                }

                console.table('Fetched mybook data:', this.mybook.content);
            } catch (error) {
                console.error('Error fetching mybook data:', error);
            }
        },
    },

};
</script>
<style></style>
