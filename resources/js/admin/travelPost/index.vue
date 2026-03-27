<template>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Путешествия</h1>

        <div class="input-group" style="max-width: 300px;">
            <input v-model="search" type="text" class="form-control" placeholder="Поиск по названию..."
                @keyup.enter="loadPosts" />
            <button class="btn btn-primary" @click="page = 1; GetTravelPosts()">
                🔍
            </button>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th @click="sort('id')" style="cursor: pointer;">
                    ID
                </th>
                <th @click="sort('title')" style="cursor: pointer;">
                    Заголовок
                </th>
                <th>
                    Назначение поста
                </th>

                <th> Статус поста</th>
                <th>
                    Дата публикации
                </th>
                <th>Описание</th>
                <th>slug</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>

            <tr v-for="travelpost in travelposts" :key="travelpost.id">
                <td>{{ travelpost.id }}</td>
                <td>{{ travelpost.title }}</td>
                <td>{{ travelpost.sense }}</td>
                <td><button class="btn btn-sm" :class="travelpost.is_visual ? 'btn-success' : 'btn-outline-secondary'"
                        @click="changeVisual(travelpost)">
                        {{ travelpost.is_visual ? '👁️ Опубликован' : '🚫 Редакция' }}
                    </button>
                </td>
                <td>{{ travelpost.date }}</td>
                <td>{{ travelpost.description }}</td>
                <td>{{ travelpost.slug }}</td>
                <td>

                    <a :href="`/travel/final/${travelpost.slug}`" target="_blank"
                        class="btn btn-info btn-sm">Просмотр</a>

                    <router-link :to="{ name: 'travelPostEdit', params: { id: travelpost.id } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>

                    <router-link :to="{ name: 'PostImages', params: { id: travelpost.id, category: 'travelPost' } }"
                        class="btn btn-secondary btn-sm">Картинки</router-link>


                </td>
            </tr>

        </tbody>
    </table>
    <button class="btn btn-sm btn-secondary" :disabled="meta.current_page === 1" @click="page--; GetTravelPosts()">
        ←
    </button>
    <span class="mx-2">Страница {{ page }}</span>
    <button class="btn btn-sm btn-secondary" :disabled="meta.current_page === meta.last_page"
        @click="page++; GetTravelPosts()">
        →
    </button>

</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';


export default defineComponent({
    name: 'TravelIndex',

    data() {
        return {
            travelposts: [],
            search: '',
            sortBy: 'id',
            sortDir: 'desc',
            page: 1,
            perPage: 10,
            meta: {},
            links: [],
        }
    },

    computed: {

    },

    mounted() {

        console.log('TravelIndex component mounted.');
        this.GetTravelPosts();
    },


    methods: {
        async GetTravelPosts() {
            try {
                console.log('Загрузка списка путешествий с сервера...', this.search);
                const response = await axios.get('/api/admin/travel-post', {
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
                this.travelposts = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
                console.table('Получено:', response.data.data);

            } catch (error) {
                console.error('Error fetching travel posts:', error);
            }
        },

        sort(field) {
            console.log(field);
            if (this.sortBy === field) {
                this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy = field;
                this.sortDir = 'asc';
            }
            console.log(this.sortBy);
            console.log(this.sortDir);

            this.page = 1;
            this.GetTravelPosts();
        },

        changeVisual(travelpost) {
            axios.patch(`/api/admin/travel-post/${travelpost.id}/toggle-visual`)
                .then(response => {
                    travelpost.is_visual = response.data.is_visual;
                })
                .catch(error => {
                    console.error('Error toggling visual status:', error);
                });
        },
    }
});
</script>