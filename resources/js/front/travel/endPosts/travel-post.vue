<template>
    <BreadCrumb :parent-slug="'nashi-puteshestviya'" :parent-title="'Наши путешествия'"
        :current-title="travel.title || ''" />

    <div class="post-container-block" :style="{
        /**
      * Устанавливаем фоновое изображение для блока поста. Путь к изображению формируется на основе slug поста.
      * В папке каждого поста должно быть изображение с именем firstfon.jpg, 
      * которое будет использоваться в качестве фонового изображения.
       */
        backgroundImage: `url('/storage/images/travels/${travel.slug}/firstfon.jpg')`,
        backgroundPosition: 'center',
    }">

        <div class=" content-block">
            <div class="entry-content" v-html="travel.content">


            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import BreadCrumb from '../../BreadCrumb.vue';

/**
 * @typedef {Object} Travel
 * @property {number} id - The unique identifier of the travel.
 * @property {string} slug - The slug of the travel, used for routing and image paths.
 * @property {string} title - The title of the travel.
 * @property {string} description - A brief description of the travel.
 * @property {string} content - The full content of the travel, which may include HTML.
 * @property {string} imageName - The name of the image associated with the travel,
 */
export default {
    name: 'travel-post',
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
             * @type {Travel}
             */
            travel: {},
        };
    },
    async mounted() {
        console.log(this.slug + " :post component mounted.");
        await this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                const response = await axios.get(`/api/travel/post/${this.slug}`);
                let content = response.data.data.content;
                //Заменяем все вхождения ${travel.slug} на фактический this.slug

                content = content.replace(/\$\{travel\.slug\}/g, this.slug);
                this.travel = {
                    ...response.data.data,
                    content
                };
                if (this.travel.title) {
                    document.title = this.travel.title;
                }

                //console.log('Fetched travel data:', this.travel.content);
            } catch (error) {
                console.error('Error fetching travel data:', error);
            }
        },
    },

};
</script>
<style>
/* .entry-content img {
    display: inline-block;
    vertical-align: top;
    max-width: 48%;
    height: auto;
    margin: 1% 1% 1% 0;
} */
</style>
