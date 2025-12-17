<template>
    <div class="row">

        <div class="col-sm-6 col-md-4" v-for="advice in advices">
            <article id="post-63989"
                class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry advice-putevoditeli">
                <figure class="effect-smart">
                    <a href="#">
                        <ResponsiveImage class="post-thumb lazyloaded" folder="categoryMenu/advice" :slug="advice.slug"
                            :imageName="advice.imageName" :imageExten="advice.imageExten" />

                        <!-- <noscript><img class="post-thumb"
                                src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg"
                                alt="Рига. Путеводитель" /></noscript> -->
                    </a>
                    <figcaption>
                        <router-link :to="{ name: 'advice-post', params: { slug: advice.slug } }">
                            {{ advice.title }}
                        </router-link>
                        <h2 class="entry-title">

                            <a href="#" rel="bookmark">{{ advice.title }}</a>
                        </h2>
                        <p>{{ advice.description }}</p>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import ResponsiveImage from '../ResponsiveImage.vue';
export default {
    name: 'Menu',

    mounted() {
        this.GetAdvices();
        console.log('Menu component mounted.');
    },

    components: { ResponsiveImage },
    data() {
        return {
            advices: [],
            imageUrl: '',
            imageName: '',
            imageExten: '',
            slug: ''
        }
    },
    methods: {
        async GetAdvices() {
            try {
                const response = await axios.get('/api/advice');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.advices = response.data.data;
                console.table(this.advices);
            } catch (error) {
                console.error('Error fetching advices:', error);
            }
        }
    }
} 
</script>
