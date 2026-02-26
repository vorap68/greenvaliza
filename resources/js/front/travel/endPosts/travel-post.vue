<template>
    <BreadCrumb :parent-slug="'nashi-puteshestviya'" :parent-title="'Наши путешествия'"
        :current-title="travel.title || ''" />

    <div class="post-container-block" :style="{
        backgroundImage: `url('/storage/images/travels/${travel.slug}/firstfon.jpg')`,
        backgroundPosition: 'center',
    }">

        <div class=" content-block">
            <div class="entry-content" v-html="travel.content">


            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import BreadCrumb from '../../BreadCrumb.vue';
export default {
    name: 'travel-post',
    props: ['slug'],

    components: {
        BreadCrumb,
    },

    data() {
        return {
            travel: {},
        };
    },
    async mounted() {
        console.log(this.slug + " :post component mounted.");
        await this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                // Example API call, replace with actual endpoint
                const response = await axios.get(`/api/travel/post/${this.slug}`);
                let content = response.data.data.content;
                content = content.replace(/\$\{travel\.slug\}/g, this.slug);
                this.travel = {
                    ...response.data.data,
                    content
                };
                if (this.travel.title) {
                    document.title = this.travel.title;
                }

                //console.log('Fetched travel data:', this.travel.content);
            } catch (error) {
                console.error('Error fetching travel data:', error);
            }
        },
    },

};
</script>
<style>
/* .entry-content img {
    display: inline-block;
    vertical-align: top;
    max-width: 48%;
    height: auto;
    margin: 1% 1% 1% 0;
} */
</style>
