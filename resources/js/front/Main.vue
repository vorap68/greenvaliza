`<template>
    <div class="row">
        <div class="col-sm-6 col-md-4" v-for="category in categories">

            <article class="grid hentry">
                <figure class="effect-smart">
                    <router-link :to="{ name: 'Category', params: { slug: category.slug } }">

                        <ResponsiveImage class="post-thumb lazyloaded" :id="category.id" :imageName="category.imageName"
                            folder="categoryMain" />
                        <noscript>
                            <img class="post-thumb" :src="imageUrl" alt="Изображение" />
                        </noscript>
                    </router-link>

                    <figcaption>
                        <h2 class="entry-title">
                            <router-link :to="{ name: 'Category', params: { slug: category.slug } }">
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

export default defineComponent({
    name: 'Main',
    components: { ResponsiveImage },
    data() {
        return {
            categories: [],
            imageUrl: '',
        }
    },

    mounted() {
        this.GetCategories();
        // console.log('Component mounted.');
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
<style></style>