<template>
    <div class="row">

        <div class="col-sm-6 col-md-4" v-for="guidebook in guidebooks">
            <article id="post-63989"
                class="grid post-63989 post type-post status-publish format-standard has-post-thumbnail hentry guidebook-putevoditeli">
                <figure class="effect-smart">
                    <a href="#">
                        <ResponsiveImage class="post-thumb lazyloaded" :slug="guidebook.slug"
                            :imageName="guidebook.imageName" :imageExten="guidebook.imageExten" folder="putevoditeli" />

                        <!-- <noscript><img class="post-thumb"
                                src="https://greenvaliza.co.ua/wp-content/uploads/2025/05/riga40-768x768.jpg"
                                alt="Рига. Путеводитель" /></noscript> -->
                    </a>
                    <figcaption>
                        <a href="#"></a>
                        <h2 class="entry-title">
                            <a href="#">

                            </a>
                            <a href="#" rel="bookmark">{{ $guidebook.title }}</a>
                        </h2>
                        <p>{{ $guidebook.description }}</p>
                    </figcaption>
                </figure>
            </article>
        </div>
    </div>
</template>
<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import ResponsiveImage from '../ResponsiveImage.vue';
export default {
    name: 'Menu',
    props: {
        guidebooks: {
            type: Array,
            required: true
        }
    }
} >    
</script>
