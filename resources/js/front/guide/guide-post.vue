<template>
    <BreadCrumb :parent-slug="'putevoditeli'" :parent-title="'Путеводители'" :current-title="guide.title || ''" />

    <div class="post-container-block" :style="{
        backgroundImage: `url('/storage/images/travels/${guide.slug}/firstfon.jpg')`,
        backgroundPosition: 'center',
    }">

        <div class=" content-block">
            <div class="entry-content" v-html="guide.content">


            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import BreadCrumb from '../BreadCrumb.vue';

/**
 * @typedef {Object} Guide
 * @property {number} id - The unique identifier of the guide.
 * @property {string} slug - The slug of the guide, used for routing and image paths.
 * @property {string} title - The title of the guide.
 * @property {string} description - A brief description of the guide.
 * @property {string} content - The full content of the guide, which may include HTML.
 * @property {string} imageName - The name of the image associated with the guide,
 */
export default {
    name: 'guide-post',
    props: [
          /**
         * slug поста, который используется для получения данных о посте и формирования пути к фоновому изображению.
          * @type {string} .
         */'slug'],

    components: {
        BreadCrumb,
    },

    data() {
        return {
            /**
             * @type {Guide}
             */
            guide: {},
        };
    },
    async mounted() {
        console.log(this.slug + " component mounted.");
        await this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                const response = await axios.get(`/api/guide/${this.slug}`);
                let content = response.data.data.content;
                //Заменяем все вхождения ${guide.slug} на фактический this.slug
                content = content.replace(/\$\{guide\.slug\}/g, this.slug);
                this.guide = {
                    ...response.data.data,
                    content
                };
                if (this.guide.title) {
                    document.title = this.guide.title;
                }

                console.log('Fetched guide data:', this.guide.content);
            } catch (error) {
                console.error('Error fetching guide data:', error);
            }
        },
    },

};
</script>
<style></style>
