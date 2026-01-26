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
                    <a v-if="guide.image" href="#" rel="bookmark" class="image-link">
                        <ResponsiveImage class="post-thumb lazyloaded" folder="categoryMenu/guide/" :id="guide.id"
                            :imageName="guide.imageName" />
                    </a>
                    <!-- PLACEHOLDER -->
                    <a v-else href=" #" rel="bookmark" class="image-placeholder">
                        <span class="placeholder-text">
                            {{ guide.title }}
                        </span>
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
<style>
.image-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 100%;
    aspect-ratio: 16 / 9;

    background: linear-gradient(135deg, #ececec, #dcdcdc);
    color: #555;

    text-decoration: none;
    font-weight: 600;
    text-align: center;

    padding: 16px;
    border-radius: 6px;
}

.placeholder-text {
    line-height: 1.4;
}
</style>
