<template>
    <div class="row">
        <div class="col-md-12">
            <div class="welcome-section sub-header">
                <h1 class="page-title">Я и мои книги</h1>
            </div>
        </div>

        <div class="col-sm-6 col-md-4" v-for="mybook in MyBooks">
            <article id="post-63989"
                class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry mybook-putevoditeli">
                <figure class="effect-smart">
                    <a href="#">
                        <ResponsiveImage class="post-thumb lazyloaded" folder="categoryMenu/mybook" :slug="mybook.slug"
                            :imageName="mybook.imageName" :imageExten="mybook.imageExten" />

                    </a>
                    <figcaption>
                        <router-link :to="{ name: 'mybook-post', params: { slug: mybook.slug } }">
                            {{ mybook.title }}
                        </router-link>
                        <h2 class="entry-title">
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
        this.GetMyBook();
        console.log('Menu component mounted.');
    },

    components: { ResponsiveImage },
    data() {
        return {
            MyBooks: [],
            imageUrl: '',
            imageName: '',
            imageExten: '',
            slug: ''
        }
    },
    methods: {
        async GetMyBook() {
            try {
                const response = await axios.get('/api/mybook');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.MyBooks = response.data.data;
                console.log('получено:', this.MyBooks);
            } catch (error) {
                console.error('Error fetching MyBook:', error);
            }
        }
    }
} 
</script>
