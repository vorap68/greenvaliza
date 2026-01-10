<template>
    <div class="row">
        <div class="col-md-12">
            <div class="welcome-section sub-header">
                <h1 class="page-title">Наши путешествия</h1>
            </div>
        </div>
        <div class="col-sm-6 col-md-4" v-for="travel in travels">
            <article id="post-63989"
                class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry travel-putevoditeli">
                <figure class="effect-smart">
                    <a href="/2">
                        <ResponsiveImage class="post-thumb lazyloaded" folder="categoryMenu/travel" :slug="travel.slug"
                            :imageName="travel.imageName" :imageExten="travel.imageExten" />

                        <!-- <noscript><img class="post-thumb"
                                src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg"
                                alt="Рига. Путеводитель" /></noscript> -->
                    </a>
                    <figcaption>

                        <router-link
                            :to="{ name: 'travel-postmenu', params: { slug: travel.slug }, query: { type: travel.type } }">
                            {{ travel.title }}
                        </router-link>

                        <h2 class="entry-title">

                            <a href="5" rel="bookmark">{{ travel.title }}</a>
                        </h2>
                        <p>{{ travel.description }}</p>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import ResponsiveImage from '../ResponsiveImage.vue';
import { type } from 'jquery';
export default {
    name: 'Menu',

    mounted() {
        this.GetTravels();
        console.log('Menu component mounted.');
    },

    components: { ResponsiveImage },
    data() {
        return {
            travels: [],
            imageUrl: '',
            imageName: '',
            imageExten: '',
            slug: '',
            type: ''
        }
    },
    methods: {
        async GetTravels() {
            try {
                const response = await axios.get('/api/travels');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                console.log('Fetched travels data:', response.data);
                this.travels = response.data.data;
                console.table('travels:', this.travels);
            } catch (error) {
                console.error('Error fetching travels:', error);
            }
        }
    }
} 
</script>
