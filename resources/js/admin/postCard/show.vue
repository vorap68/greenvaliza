<template>
    <div class="card shadow-sm border-0 rounded-3" style="max-width: 22rem;">
        <img :src="`/storage/images/categoryMenu/${category_name}/${postCard.slug}/${postCard.image}`"
            class="card-img-top" alt="Изображение поста">

        <div class="card-body">
            <h5 class="card-title fw-bold text-primary">{{ postCard.title }}</h5>
            <p></p>
            <p class="card-text text-muted mb-2">
                {{ postCard.description }}
            </p>

            <p class="text-secondary small mb-3">
                <i class="bi bi-calendar3"></i>
                Дата публикации: <strong>{{ postCard.date }}</strong>
            </p>

            <a :href="`/post/${category_name}/${postCard.slug}`" class="btn btn-outline-primary w-100">
                Читать полностью
            </a>
        </div>
    </div>

</template>

<script>

import { defineComponent } from 'vue';
import axios from 'axios';
export default defineComponent({
    name: 'PostCardShow',
    data() {
        return {
            postCard: {},
        }
    },

    props: ['category_name', 'slug'],
    mounted() {
        this.loadPostCard();
    },
    methods: {
        async loadPostCard() {
            try {
                const response = await axios.get(`/api/admin/postcard/show/${this.category_name}/${this.slug}`);
                console.log('Response data:', response.data.data);
                this.postCard = response.data;
            } catch (error) {
                console.error('Error loading post card:', error);
            }
        },
    }
});
</script>