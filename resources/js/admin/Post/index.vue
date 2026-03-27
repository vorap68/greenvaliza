<template>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">{{ category }}</h1>

        <div class="input-group" style="max-width: 300px;">
            <input v-model="search" type="text" class="form-control" placeholder="Поиск по названию..."
                @keyup.enter="GetPosts" />
            <button class="btn btn-primary" @click="page = 1; GetPosts()">
                🔍
            </button>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th @click="sortTable('id')">
                    ID
                    <span v-if="sortColumn === 'id'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                </th>
                <th @click="sortTable('title')">
                    Заголовок
                    <span v-if="sortColumn === 'title'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                </th>
                <th>Статус поста
                </th>
                <th @click="sortTable('date')">
                    Дата публикации
                    <span v-if="sortColumn === 'date'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
                </th>
                <th>Описание</th>
                <th>slug</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>

            <tr v-for="post in sortedData" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.title }}</td>
                <td><button @click="changeVisual(post)" class="btn btn-sm"
                        :class="post.is_visual ? 'btn-success' : 'btn-outline-secondary'">
                        {{ post.is_visual ? '👁️ Опубликован' : '🚫 Редакция' }}
                    </button>
                </td>
                <td>{{ post.date }}</td>
                <td>{{ post.description }}</td>
                <td>{{ post.slug }}</td>
                <td>

                    <a :href="`/${this.category}/${post.slug}`" target="_blank" class="btn btn-info btn-sm">Просмотр</a>

                    <router-link :to="{ name: 'postAdminEdit', params: { id: post.id, category: this.category } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>

                    <router-link :to="{ name: 'PostImages', params: { id: post.id, category: this.category } }"
                        class="btn btn-secondary btn-sm">Картинки</router-link>

                </td>
            </tr>

        </tbody>
    </table>

    <button class="btn btn-sm btn-secondary" :disabled="meta.current_page === 1" @click="page--; GetPosts()">
        ←
    </button>
    <span class="mx-2">Страница {{ page }}</span>
    <button class="btn btn-sm btn-secondary" :disabled="meta.current_page === meta.last_page"
        @click="page++; GetPosts()">
        →
    </button>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';


export default defineComponent({
    name: 'PostAdminIndex',


    data() {
        return {
            posts: [],
            search: '',
            sortBy: 'id',
            sortDir: 'desc',
            page: 1,
            perPage: 10,
            meta: {},
            links: [],
            sortColumn: null,
            sortDirection: 'asc'
        }
    },


    props: {
        category: {
            type: String,
            required: true
        }
    },

    computed: {
        sortedData() {
            if (!this.sortColumn) {
                return this.posts;
            }
            return [...this.posts].sort((a, b) => {
                const aValue = a[this.sortColumn];
                const bValue = b[this.sortColumn];

                if (typeof aValue === 'number' && typeof bValue === 'number') {
                    return this.sortDirection === 'asc' ? aValue - bValue : bValue - aValue;
                } else {
                    const sA = String(aValue).toLowerCase();
                    const sB = String(bValue).toLowerCase();
                    if (sA < sB) return this.sortDirection === 'asc' ? -1 : 1;
                    if (sA > sB) return this.sortDirection === 'asc' ? 1 : -1;
                    return 0;
                }
            });
        }
    },

    watch: {
        category() {
            this.page = 1
            this.GetPosts()
        }
    },

    mounted() {
        console.log('PostIndex component mounted.', 'Category:', this.category);
        this.GetPosts();
    },

    methods: {
        async GetPosts() {
            try {
                console.log('Загрузка списка путешествий с сервера...', this.search);
                const response = await axios.get((`/api/admin/${this.category}`), {
                    params: {
                        search: this.search,
                        sort_by: this.sortBy,
                        sort_dir: this.sortDir,
                        page: this.page,
                        per_page: this.perPage
                    }
                });
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.posts = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
                console.table('Получено:', response.data.data);
            } catch (error) {
                console.error('Error fetching  posts:', error);
            }
        },

        sortTable(column) {
            if (this.sortColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortColumn = column;
                this.sortDirection = 'asc';
            }
        },

        changeVisual(post) {

            axios.patch(`/api/admin/${this.category}/${post.id}/toggle-visual`)
                .then(response => {
                    post.is_visual = response.data.is_visual;
                })
                .catch(error => {
                    console.error('Error toggling visual status:', error);
                });
        }
    }
});
</script>