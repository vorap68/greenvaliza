<template>
    <BreadCrumb :parent-slug="'ya-i-moi-knigi'" :parent-title="'Я и мои книги'" :current-title="mybook.title || ''" />

    <div class="post-container-block" :style="{
        backgroundImage: `url('/storage/images/travels/${mybook.slug}/firstfon.jpg')`,
        backgroundPosition: 'center',
    }">

        <div class=" content-block">
            <div class="entry-content" v-html="mybook.content">


            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
import BreadCrumb from '../BreadCrumb.vue';
export default {
    name: 'mybook-post',
    props: ['slug'],

    components: {
        BreadCrumb,
    },

    data() {
        return {
            mybook: {},
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
                const response = await axios.get(`/api/mybook/${this.slug}`);
                let content = response.data.data.content;
                content = content.replace(/\$\{mybook\.slug\}/g, this.slug);
                this.mybook = {
                    ...response.data.data,
                    content
                };
                if (this.mybook.title) {
                    document.title = this.mybook.title;
                }

                console.table('Fetched mybook data:', this.mybook.content);
            } catch (error) {
                console.error('Error fetching mybook data:', error);
            }
        },
    },

};
</script>
<style>
p.ab {
    text-align: justify;
    font-family: serif;
    font-size: medium;
    font-weight: 400;
    margin-right: 4%;
    margin-left: 4%;
    line-height: 1.2;
    font-size: 20px;
    color: #333333;
}

p.ab2 {
    text-align: right;
    font-weight: bold;
    font-style: italic;
    margin-right: 3%;
    margin-left: 3%;
}

p.name {
    font-size: x-large;
    font-family: cursive;
    font-weight: 700;
    text-align: center;
    color: #BC8F8F
}

p.name2 {
    font-size: large;
    font-family: cursive;
    font-weight: 600;
    text-align: center;
    color: #DAA520
}
</style>
