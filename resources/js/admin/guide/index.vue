<template>
    <h1>Путешествия</h1>
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

            <tr v-for="guidepost in sortedData" :key="guidepost.id">
                <td>{{ guidepost.id }}</td>
                <td>{{ guidepost.title }}</td>
                <td>{{ guidepost.type }}</td>
                <td>{{ guidepost.date }}</td>
                <td>{{ guidepost.description }}</td>
                <td>{{ guidepost.slug }}</td>
                <td>
                    <router-link :to="{ name: 'guideShow', query: { slug: guidepost.slug } }"
                        class="btn btn-info btn-sm">Просмотр</router-link>

                    <router-link :to="{ name: 'guideEdit', query: { slug: guidepost.slug } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>

                    <router-link :to="{ name: 'guideImages', params: { post_id: guidepost.id } }"
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
    name: 'GuideIndex',

    data() {
        return {
            guideposts: [],
            sortColumn: null,
            sortDirection: 'asc',
        }
    },

    computed: {
        sortedData() {
            if (!this.sortColumn) {
                return this.guideposts;
            }
            return [...this.guideposts].sort((a, b) => {
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
        console.log('GuideIndex component mounted.');
        this.GetGuidePosts();
    },

    methods: {
        async GetGuidePosts() {
            try {
                const response = await axios.get('/api/admin/guide');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.guideposts = response.data.data;
                console.table(this.guideposts);
            } catch (error) {
                console.error('Error fetching travel posts:', error);
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