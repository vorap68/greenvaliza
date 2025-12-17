<template>
    <h1>Путешественные картинки</h1>
    <div>
        <p>Управление изображениями для путешествия : <strong>{{ this.title }}</strong></p>
        <h2>Картинки</h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">

            <div class="col" v-for="img in imagesArray" :key="img.id">
                <div class="card h-100 shadow-sm">
                    <img decodong="async" :src="`/storage/${img.filename}`" class="card-img-top" alt="image">
                    <div class="card-body">
                        <p class="card-text small">{{ img.filename }}</p>

                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';
export default defineComponent({
    name: 'travelImages',
    props: ['post_id'],

    data() {
        return {
            imagesArray: [],
        }
    },

    mounted() {
        this.loadImages();
    },

    methods: {
        async loadImages() {
            try {
                console.log('Загрузка изображений для путешествия:', this.post_id);
                const response = await axios.get('/api/admin/travel-images' + '/' + this.post_id);
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.imagesArray = response.data.data;
                console.log('Загруженные изображения:', this.imagesArray);
            }
            catch (error) {
                console.error('Error loading images:', error);
            }
        },
    }
});
</script>