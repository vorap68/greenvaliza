<template>
    <div class="row">

        <div class="col-sm-6 col-md-4" v-for="mybook in mybooks">
            <article id="post-63989"
                class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry mybook-putevoditeli">
                <figure class="effect-smart">
                    <a href="#">
                        <ResponsiveImage class="post-thumb lazyloaded" folder="categoryMenu/ya-i-moi-knigi/"
                            :slug="mybook.slug" :imageName="mybook.imageName" :imageExten="mybook.imageExten" />

                        <!-- <noscript><img class="post-thumb"
                                src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg"
                                alt="Рига. Путеводитель" /></noscript> -->
                    </a>
                    <figcaption>
                        <a href="#"></a>
                        <h2 class="entry-title">
                            <a href="#">

                            </a>
                            <a href="#" rel="bookmark">{{ mybook.title }}</a>
                        </h2>
                        <p>{{ mybook.description }}</p>
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
        this.GetMybooks();
        console.log('Menu component mounted.');
    },

    components: { ResponsiveImage },
    data() {
        return {
            mybooks: [],
            imageUrl: '',
            imageName: '',
            imageExten: '',
            slug: ''
        }
    },
    methods: {
        async GetMybooks() {
            try {
                const response = await axios.get('/api/mybooks');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.mybooks = response.data.data;
                console.table(this.mybooks);
            } catch (error) {
                console.error('Error fetching mybooks:', error);
            }
        }
    }
} 
</script>
