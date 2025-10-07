<template>

    <div class="row">

        <div class="col-sm-6 col-md-4" v-for="category in categories">

            <!-- Блок 1 -->

            <article class="grid hentry">

                <figure class="effect-smart">
                    <a href="#" rel="bookmark">

                        <ResponsiveImage class="post-thumb lazyloaded" :slug="category.slug"
                            :imageName="category.imageName" :imageExten="category.imageExten" folder="categories" />
                        <noscript>
                            <img class="post-thumb" :src="imageUrl" alt="Изображение" />
                        </noscript>
                    </a>
                    <figcaption>
                        <h2 class="entry-title">
                            <a href="#" rel="bookmark">
                                <!-- {{ category.title }} -->
                            </a>
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
        console.log('Component mounted.');
    },
    methods: {
        async GetCategories() {
            try {
                const response = await axios.get('/api/categories');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.data.data;
                this.categories = data;
                // this.imageUrl = 'storege/images/categories/'.this.categories.slug.'/'.this.categories.imageName.'.'.this.categories.imageExten;

                console.log('categories:', this.categories);
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        }
    }
});

</script>
<style></style>