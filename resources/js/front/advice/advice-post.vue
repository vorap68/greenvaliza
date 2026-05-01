<template>
    <BreadCrumb :parent-slug="'sovety-i-poleznosti'" :parent-title="'Советы и полезности'"
        :current-title="advice.title || ''" />

    <div class="post-container-block" :style="{
        /**
        * Устанавливаем фоновое изображение для блока поста. Путь к изображению формируется на основе slug поста.
        * В папке каждого поста должно быть изображение с именем firstfon.jpg, 
        * которое будет использоваться в качестве фонового изображения.
         */
        backgroundImage: `url('/storage/images/travels/${advice.slug}/firstfon.jpg')`,
        backgroundPosition: 'center',
    }">
        <div class=" content-block">
            <div class="entry-content" v-html="advice.content">
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import BreadCrumb from '../BreadCrumb.vue';

/**
 * @typedef {Object} Advice
 * @property {number} id - The unique identifier of the advice.
 * @property {string} slug - The slug of the advice, used for routing and image paths.
 * @property {string} title - The title of the advice.
 * @property {string} description - A brief description of the advice.
 * @property {string} content - The full content of the advice, which may include HTML.
 * @property {string} imageName - The name of the image associated with the advice,
 */
export default {
    name: 'advice-post',
    props: [
        /**
         * slug поста, который используется для получения данных о посте и формирования пути к фоновому изображению.
          * @type {string}
         */
        'slug'
    ],

    components: {
        BreadCrumb,
    },

    data() {
        return {
            /**
             * @type {Advice}
             */
            advice: {},
        };
    },
    async mounted() {
        console.log(this.slug + " component mounted.");
        await this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                const response = await axios.get(`/api/advice/${this.slug}`);
                let content = response.data.data.content;
                console.log('Fetched advice content:', content);
                //Заменяем все вхождения ${advice.slug} на фактический this.slug
                content = content.replace(/\$\{advice\.slug\}/g, this.slug);
                console.log('Fetched advice content_NEW:', content);

                this.advice = {
                    ...response.data.data,
                    content
                };
                console.log('Fetched advice this.advice:', this.advice);

                if (this.advice.title) {
                    document.title = this.advice.title;
                }

            } catch (error) {
                console.error('Error fetching guide data:', error);
            }
        },
    },

};
</script>
<style></style>
