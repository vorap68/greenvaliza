<template>
    <div class="row">
        <div class="col-md-12">
            <div class="welcome-section sub-header">
                <h1 class="page-title">Путеводители</h1>
            </div>
        </div>
        <div class="col-sm-6 col-md-4" v-for="guide in guides" :key="guide.id">
            <article id="post-63989"
                class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry guide-putevoditeli">
                <figure class="effect-smart">
                    <a href="#">
                        <ResponsiveImage class="post-thumb lazyloaded" folder="categoryMenu/guide/" :slug="guide.slug"
                            :imageName="guide.imageName" :imageExten="guide.imageExten" />

                        <!-- <noscript><img class="post-thumb"
                                src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg"
                                alt="Рига. Путеводитель" /></noscript> -->
                    </a>
                    <figcaption>
                        <router-link :to="{ name: 'guide-post', params: { slug: guide.slug } }">
                            {{ guide.title }}
                        </router-link>
                        <h2 class="entry-title">

                            <a href="#" rel="bookmark">{{ guide.title }}</a>
                        </h2>
                        <p>{{ guide.description }}</p>
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
        this.Getguide();
        console.log('Menu component mounted.');
    },

    components: { ResponsiveImage },
    data() {
        return {
            guides: [],
            imageUrl: '',
            imageName: '',
            imageExten: '',
            slug: ''
        }
    },
    methods: {
        async Getguide() {
            try {
                const response = await axios.get('/api/guide');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                console.log('Response data:', response.data);
                this.guides = response.data.data;
                console.table(this.guide);
            } catch (error) {
                console.error('Error fetching guide:', error);
            }
        }
    }
} 
</script>
