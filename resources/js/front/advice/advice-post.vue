<template>
    <BreadCrumb :parent-slug="'sovety-i-poleznosti'" :parent-title="'Советы и полезности'"
        :current-title="advice.title || ''" />

    <div class="post-container-block" :style="{
        backgroundImage: `url('/storage/images/travels/${advice.slug}/firstfon.jpg')`,
        backgroundPosition: 'center',
    }">

        <div class=" content-block">
            <div class="entry-content" v-html="advice.content">


            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import BreadCrumb from '../BreadCrumb.vue';
export default {
    name: 'advice-post',
    props: ['slug'],

    components: {
        BreadCrumb,
    },

    data() {
        return {
            advice: {},
        };
    },
    async mounted() {
        console.log(this.slug + " component mounted.");
        await this.fetchData();
    },

    methods: {
        async fetchData() {
            try {
                // Example API call, replace with actual endpoint
                const response = await axios.get(`/api/advice/${this.slug}`);
                let content = response.data.data.content;
                content = content.replace(/\$\{advice\.slug\}/g, this.slug);
                this.advice = {
                    ...response.data.data,
                    content
                };
                if (this.advice.title) {
                    document.title = this.advice.title;
                }

                console.log('Fetched advice data:', this.advice.content);
            } catch (error) {
                console.error('Error fetching guide data:', error);
            }
        },
    },

};
</script>
<style></style>
