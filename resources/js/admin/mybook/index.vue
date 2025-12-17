<template>
    <h1>Полезности</h1>
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
                <th @click="sortTable('type')">
                    Тип поста
                    <span v-if="sortColumn === 'type'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
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

            <tr v-for="mybookpost in sortedData" :key="mybookpost.id">
                <td>{{ mybookpost.id }}</td>
                <td>{{ mybookpost.title }}</td>
                <td>{{ mybookpost.type }}</td>
                <td>{{ mybookpost.date }}</td>
                <td>{{ mybookpost.description }}</td>
                <td>{{ mybookpost.slug }}</td>
                <td>
                    <router-link :to="{ name: 'MyBookhow', query: { slug: mybookpost.slug } }"
                        class="btn btn-info btn-sm">Просмотр</router-link>

                    <router-link :to="{ name: 'mybookEdit', query: { slug: mybookpost.slug } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>

                    <router-link :to="{ name: 'mybookImages', params: { post_id: mybookpost.id } }"
                        class="btn btn-secondary btn-sm">Картинки

                    </router-link>

                </td>
            </tr>

        </tbody>
    </table>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';


export default defineComponent({
    name: 'MybookIndex',

    data() {
        return {
            mybookposts: [],
            sortColumn: null,
            sortDirection: 'asc',
        }
    },

    computed: {
        sortedData() {
            if (!this.sortColumn) {
                return this.mybookposts;
            }
            return [...this.mybookposts].sort((a, b) => {
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

    mounted() {
        console.log('MybookIndex component mounted.');
        this.GetMybookPosts();
    },

    methods: {
        async GetMybookPosts() {
            try {
                const response = await axios.get('/api/admin/mybook');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                console.log('Response data:', response.data);
                this.mybookposts = response.data.data;
                console.table('mybookposts', this.mybookposts);
            } catch (error) {
                console.error('Error fetching advice posts:', error);
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
    }
});
</script>