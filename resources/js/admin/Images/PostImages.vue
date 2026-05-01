<template>
    <div>
        <h2>Картинки</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">

            <div class="col" v-for="img in imagesArray" :key="img.post_id">
                <div class="card h-100 shadow-sm">
                    <img decodong="async" :src="`/storage/images/${this.category}/${this.id}/resize/${img.filethumb}`"
                        class="card-img-top" alt="image">
                    <div class="card-body">
                        <p class="card-text small">{{ img.filethumb }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="pagination" class="d-flex justify-content-center mt-4">

        <button class="btn btn-outline-secondary me-2" :disabled="!pagination.prev_page_url"
            @click="loadImages(pagination.current_page - 1)">
            ←
        </button>

        <span class="align-self-center">
            {{ pagination.current_page }} / {{ pagination.last_page }}
        </span>

        <button class="btn btn-outline-secondary ms-2" :disabled="!pagination.next_page_url"
            @click="loadImages(pagination.current_page + 1)">
            →
        </button>

    </div>
</template>
<script>
import axios from 'axios';
import { defineComponent } from 'vue';

/**
 * @typedef {Object} Image
 * @property {number} post_id
 * @property {string} filethumb
 */
/**
 * $typedef {Object} Pagination
 * @property {number} current_page
 * @property {number} next_page
 * @property {number} last_page
 * @property {string|null} next_page_url
 * @property {string|null} prev_page_url
 */

export default defineComponent({
    name: 'PostImages',
    props: [
        /**
         * id поста, для которого нужно загрузить изображения
         * @type {number} 
         */
        'id',

        /**
         * категория изображений (например, 'posts')
         * @type {string}
         */
        'category'
    ],

    data() {
        return {
            /**
            * @type {Image[]}
             */
            imagesArray: [],
            /**
             * @type {Pagination|null}
             */
            pagination: null,
        }
    },

    mounted() {
        this.loadImages(1);
    },

    methods: {
        async loadImages(page = 1) {
            /**
     * Получает фото для выбраной категории + id поста +текущая страница 
     * @param {number} [page=1] - номер страницы
     */
            try {
                console.log('Загрузка изображений для :', this.category, this.id);
                const response = await axios.get(`/api/admin/images/${this.category}/${this.id}?page=${page}`)
                console.log('Ответ от сервера:', response.data.imageData);

                this.imagesArray = response.data.imageData.data || []; // на случай, если в ответе нет поля images
                console.log('Загруженные изображения:', this.imagesArray);
                this.pagination = response.data.imageData


                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

            }
            catch (error) {
                console.error('Error loading images:', error);
            }
        },
    }
});
</script>