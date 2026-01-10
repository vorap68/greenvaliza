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
                <th>Назначение поста</th>
                <th> Статус поста</th>
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

            <tr v-for="travelpost in sortedData" :key="travelpost.id">
                <td>{{ travelpost.id }}</td>
                <td>{{ travelpost.title }}</td>
                <td>{{ travelpost.travel_table_id }}</td>
                <td><button class="btn btn-sm" :class="travelpost.is_visual ? 'btn-success' : 'btn-outline-secondary'"
                        @click="changeVisual(travelpost)">
                        {{ travelpost.is_visual ? '👁️ Опубликован' : '🚫 Редакция' }}
                    </button>
                </td>
                <td>{{ travelpost.date }}</td>
                <td>{{ travelpost.description }}</td>
                <td>{{ travelpost.slug }}</td>
                <td>
                    <router-link :to="{ name: 'travelPostShow', params: { slug: travelpost.slug } }"
                        class="btn btn-info btn-sm">Просмотр</router-link>

                    <router-link :to="{ name: 'travelPostEdit', params: { slug: travelpost.slug } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>

                    <router-link :to="{ name: 'travelPostImages', params: { post_id: travelpost.id } }"
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
    name: 'TravelIndex',

    data() {
        return {
            travelposts: [],
            sortColumn: null,
            sortDirection: 'asc',
        }
    },

    computed: {
        sortedData() {
            if (!this.sortColumn) {
                return this.travelposts;
            }
            return [...this.travelposts].sort((a, b) => {
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
        console.log('TravelIndex component mounted.');
        this.GetTravelPosts();
    },

    methods: {
        async GetTravelPosts() {
            try {
                const response = await axios.get('/api/admin/travels-post');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.travelposts = response.data.data;
                console.table('Получено:', response.data.data);
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

        changeVisual(travelpost) {
            axios.patch(`/api/admin/travels-post/${travelpost.id}/toggle-visual`)
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