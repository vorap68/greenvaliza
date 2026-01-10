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
                <th>Статус поста</th>
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

            <tr v-for="advicepost in sortedData" :key="advicepost.id">
                <td>{{ advicepost.id }}</td>
                <td>{{ advicepost.title }}</td>
                <td><button class="btn btn-sm" :class="advicepost.is_visual ? 'btn-success' : 'btn-outline-secondary'"
                        @click="changeVisual(advicepost)">
                        {{ advicepost.is_visual ? '👁️ Опубликован' : '🚫 Редакция' }}
                    </button>
                </td>

                <td>{{ advicepost.date }}</td>
                <td>{{ advicepost.description }}</td>
                <td>{{ advicepost.slug }}</td>
                <td>
                    <router-link :to="{ name: 'adviceShow', params: { slug: advicepost.slug } }"
                        class="btn btn-info btn-sm">Просмотр</router-link>

                    <router-link :to="{ name: 'advicePostEdit', params: { slug: advicepost.slug } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>

                    <router-link :to="{ name: 'adviceImages', params: { post_id: advicepost.id } }"
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
    name: 'AdviceIndex',

    data() {
        return {
            adviceposts: [],
            sortColumn: null,
            sortDirection: 'asc',

        }
    },

    computed: {
        sortedData() {
            if (!this.sortColumn) {
                return this.adviceposts;
            }
            return [...this.adviceposts].sort((a, b) => {
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
        console.log('AdviceIndex component mounted.');
        this.GetAdvicePosts();
    },

    methods: {
        async GetAdvicePosts() {
            try {
                const response = await axios.get('/api/admin/advices');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.adviceposts = response.data.data;
                console.table(this.adviceposts);
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
        changeVisual(advicepost) {
            advicepost.is_visual = !advicepost.is_visual;
            axios
                .patch(`/api/admin/advices/${advicepost.id}/toggle-visual`)
                .then((response) => {
                    console.log('Visual status updated:', response.data);
                })
                .catch((error) => {
                    console.error('Error updating visual status:', error);
                });
        },
    }
});
</script>