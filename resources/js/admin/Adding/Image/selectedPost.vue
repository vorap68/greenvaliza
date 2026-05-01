<template>
    <div class="d-flex flex-column gap-3" style="max-width: 340px;">
        <!-- выбор категории -->
        <div>
            <label class="form-label">Категория</label>
            <select v-model="category" class="form-select">
                <option disabled value="">Выберите категорию</option>
                <option value="travel-post">Наши путешествия (Посты)</option>
                <option value="travel-table">Наши путешествия (Посты-таблицы)</option>
                <option value="guide">Путеводитель</option>
                <option value="advice">Советы и полезности</option>
                <option value="mybook">Я и мои книги</option>
            </select>
        </div>

        <!-- Поиск поста в категории-->
        <div v-if="category" class="input-group">
            <input v-model="search" @keyup.enter="searchPost(search)" type="text" class="form-control"
                placeholder="Поиск по названию...">
            <button class="btn btn-primary" @click="searchPost(search)">
                🔍
            </button>
        </div>

        <!-- список полученых постов для выбора,и передача выбраного поста в метод selectPost()-->
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
    </div>
</template>
<script>
import { defineComponent } from 'vue';
import axios from 'axios';

/**
 * @typedef {Object} Post выбранный пост полученный из компонента selectedPost.vue
 * @property {number} id - Идентификатор поста
 * @property {string} title - Название поста
 * @property {string} category - Категория поста    
 */
/**
 * @typedef {Object} selectedPost  объект, который содержит информацию о выбранном посте и его категории.
 * @property {Post} post - Выбранный пост, который содержит id и title.
 * @property {string} category - Категория, к которой принадлежит выбранный пост
 */

export default defineComponent({
    name: 'SelectedPost',


    data() {
        return {
            category: "",
            search: "",

            /** 
             * @type {Post[]} posts - Массив всех постов для выбранной категории.
            */
            posts: [],
            filteredPosts: [],

            /** 
             * @type {selectedPost} selectedPost - Выбранный пост.
            */
            selectedPost: null,
            hasFiles: false,
        }
    },

    /**
   * При изменении категории, сбрасываем все данные и загружаем посты для новой категории.
   */
    watch: {
        category(newCategory) {
            if (!newCategory) return;
            this.loadPosts();
        },
    },

    methods: {

        /**
          * Загрузка постов для выбранной категории.
          *  Отправляем GET-запрос на сервер с параметром all=true, 
          * чтобы получить все посты для данной категории.
          *  Полученные данные сохраняем в массив posts и выводим в консоль для проверки.
          */
        async loadPosts() {
            console.log('Загрузка постов для категории:', this.category);
            const response = await axios.get((`/api/admin/${this.category}`), {
                params: {
                    all: true,
                }
            });
            this.posts = response.data.data;
            console.log('Загруженные посты:', this.posts);

        },

        /**
         * Поиск постов по введенному запросу.
         * Поиск идет из массива posts, который был загружен для выбранной категории.
         */
        searchPost(value) {
            console.log('Поиск постов по запросу:', value);
            if (value.length < 2) {
                this.filteredPosts = [];
                return;
            }
            const q = value.toLowerCase();
            /**
             * Фильтруем посты, оставляя только те, в названии которых есть введенный запрос.
             */
            this.filteredPosts = this.posts.filter(post =>
                post.title.toLowerCase().includes(q)
            );
            console.log('Найденные посты:', this.filteredPosts);
            console.log('Id пост:', this.filteredPosts.map(p => p.id));
        },

        /**
         * Выбранный пост сохраняем в selectedPost, отображаем его название в поле поиска 
         * и очищаем список найденных постов.
         * @param post 
         */
        selectPost(post) {
            this.selectedPost = post;
            this.search = post.title;
            this.filteredPosts = [];
            this.$emit('post-selected', { post, category: this.category }); // Эмитим событие с выбранным постом    
        },

        /**
         * Сброс всех данных: очистка поля поиска, выбранной категории,
         *  списка постов и выбранного поста.
         */
        cleanSearch() {
            this.search = "";
            this.category = "";
            this.posts = [];
            this.filteredPosts = [];
            this.selectedPost = null;
        },
    }
})
</script>