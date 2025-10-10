<template>
    <div class="row">

        <div class="col-sm-6 col-md-4" v-for="travel in travels">
            <article id="post-63989"
                class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry travel-putevoditeli">
                <figure class="effect-smart">
                    <a href="#">
                        <ResponsiveImage class="post-thumb lazyloaded" folder="categoryMenu/nashi-puteshestviya/"
                            :slug="travel.slug" :imageName="travel.imageName" :imageExten="travel.imageExten" />

                        <!-- <noscript><img class="post-thumb"
                                src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg"
                                alt="Рига. Путеводитель" /></noscript> -->
                    </a>
                    <figcaption>
                        <a href="#"></a>
                        <h2 class="entry-title">
                            <a href="#">

                            </a>
                            <a href="#" rel="bookmark">{{ travel.title }}</a>
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
            slug: ''
        }
    },
    methods: {
        async GetTravels() {
            try {
                const response = await axios.get('/api/travels');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.travels = response.data.data;
                console.table(this.travels);
            } catch (error) {
                console.error('Error fetching travels:', error);
            }
        }
    }
} 
</script>
