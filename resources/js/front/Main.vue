`<template>
    <div class="row">
        <div class="col-sm-6 col-md-4" v-for="category in categories">
            <article class="grid hentry">
                <figure class="effect-smart">
                    <router-link :to="`${category.name}`">
                        <!-- 
                        * Используем компонент ResponsiveImage для отображения изображения категории.
                        * Компонент принимает следующие пропсы:
                        * - id: идентификатор категории, который используется для генерации пути к изображению
                        * - imageName: имя изображения, которое используется для генерации различных размеров
                        * изображения
                        * - folder: папка, в которой хранятся изображения категории
                        *-->
                        <ResponsiveImage class="post-thumb lazyloaded" :id="category.id" :imageName="category.imageName"
                            folder="categoryMain" />
                    </router-link>

                    <figcaption>
                        <h2 class="entry-title">
                            <router-link :to="`${category.name}`">
                                {{ category.title }}
                            </router-link>
                        </h2>
                        <p>
                            {{ category.description }}
                        </p>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
</template>
<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import ResponsiveImage from './ResponsiveImage.vue';

/**
 * @typedef {Object} Category
 * @property {number} id - The unique identifier of the category.
 * @property {string} name - The name of the category.
 * @property {string} title - The title of the category.
 * @property {string} description - The description of the category.
 * @property {string} imageName - The name of the image associated with the category.
 */
export default defineComponent({
    name: 'Main',
    components: { ResponsiveImage },
    data() {
        return {
            categories: [],
        }
    },

    mounted() {
        this.GetCategories();
    },

    methods: {
        async GetCategories() {

            try {
                const response = await axios.get('/api/categories');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.data.data;
                console.log('Fetched data:', data);
                this.categories = data;


                console.log('categories:', this.categories);
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        }
    }
});

</script>
<style scoped></style>