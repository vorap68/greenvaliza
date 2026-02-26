<template>
    <div class="d-flex flex-column gap-3" style="max-width: 340px;">

        <!-- Категория -->
        <div>
            <label class="form-label">Категория</label>
            <select v-model="category" class="form-select">
                <option disabled value="">Выберите категорию</option>
                <option value="travel-post">Наши путешествия (Посты)</option>
                <option value="travel-table">Наши путешествия (Посты-таблицы)</option>
                <option value="guide">Путеводитель</option>
                <option value="advices">Советы и полезности</option>
                <option value="mybook">Я и мои книги</option>
            </select>
        </div>

        <!-- Поиск -->
        <div v-if="category" class="input-group">
            <input v-model="search" @keyup.enter="searchPost(search)" type="text" class="form-control"
                placeholder="Поиск по названию...">
            <button class="btn btn-primary" @click="searchPost(search)">
                🔍
            </button>
        </div>

        <!-- Результаты -->
        <ul v-if="filteredPosts.length" class="list-group">
            <li v-for="post in filteredPosts" :key="post.id" class="list-group-item list-group-item-action"
                @click="selectPost(post)" style="cursor:pointer">
                {{ post.title }}
            </li>
        </ul>

        <!-- Выбранный пост -->
        <div v-if="selectedPost" class="alert alert-success">
            Выбран пост: <b>{{ selectedPost.title }}</b>
        </div>

        <!-- Очистка -->
        <button class="btn btn-outline-secondary" @click="cleanSearch">
            Очистить поиск
        </button>

        <!-- Dropzone -->
        <div ref="dropzone" class="border border-2 border-dashed rounded p-4 text-center bg-dark text-light"
            style="cursor:pointer">
            <h5 class="mb-0">Добавить фото</h5>
        </div>

        <!-- Загрузка -->
        <button class="btn btn-success" @click.prevent="storeImages">
            Загрузить изображения
        </button>

    </div>



</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import Dropzone from 'dropzone';



export default defineComponent({
    name: 'AddingImage',

    data() {
        return {
            dropzone: null,
            category: "",
            search: "",
            posts: [],
            filteredPosts: [],
            selectedPost: null
        }
    },

    watch: {
        category(newCategory) {
            if (!newCategory) return;
            this.loadPosts();
        },



    },



    async mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone,
            {
                url: '/api/admin/create-image',
                clickable: true,
                acceptedFiles: 'image/*',
                autoProcessQueue: false,
                addRemoveLinks: true,
                dictRemoveFile: 'Удалить файл',
                maxFilesize: 15, // MB
            });
    },

    methods: {
        async loadPosts() {
            console.log('Загрузка постов для категории:', this.category);
            // пример — бери меню из /api/admin/advice (или любой свой маршрут)
            const response = await axios.get(`/api/admin/${this.category}`);

            this.posts = response.data.data;
            console.log('Загруженные посты:', this.posts);

        },

        searchPost(value) {
            console.log('Поиск постов по запросу:', value);
            if (value.length < 2) {
                this.filteredPosts = [];
                return;
            }

            const q = value.toLowerCase();

            this.filteredPosts = this.posts.filter(post =>
                post.title.toLowerCase().includes(q)
            );
            console.log('Найденные посты:', this.filteredPosts);
            console.log('Id пост:', this.filteredPosts.map(p => p.id));
        },

        selectPost(post) {
            this.selectedPost = post;
            this.search = post.title;
            this.filteredPosts = [];
        },

        cleanSearch() {
            this.search = "";
            this.category = "";
            this.posts = [];
            this.filteredPosts = [];
            this.selectedPost = null;
        },

        async storeImages() {
            const files = this.dropzone.getAcceptedFiles();
            console.log('Выбранные файлы для загрузки:', files);

            if (!files.length) {
                alert('Выберите файлы');
                return;
            }

            const images = new FormData();

            files.forEach((file, index) => {
                images.append('images[]', file);
            });

            try {
                const response = await axios.post(
                    `/api/admin/create-image/${this.category}/${this.selectedPost.id}`,
                    images,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                );

                console.log('Успех:', response.data);
            } catch (error) {
                console.error('Ошибка загрузки:', error);
            }
        }

    }
});


</script>
<style>
.custom-border {
    border-color: #28a745 !important;
}
</style>