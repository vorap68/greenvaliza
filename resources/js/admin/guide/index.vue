<template>
    <h1>Путеводители</h1>
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

            <tr v-for="guidepost in sortedData" :key="guidepost.id">
                <td>{{ guidepost.id }}</td>
                <td>{{ guidepost.title }}</td>
                <td><button class="btn btn-sm" :class="guidepost.is_visual ? 'btn-success' : 'btn-outline-secondary'"
                        @click="changeVisual(guidepost)">
                        {{ guidepost.is_visual ? '👁️ Опубликован' : '🚫 Редакция' }}
                    </button>
                </td>
                <td>{{ guidepost.date }}</td>
                <td>{{ guidepost.description }}</td>
                <td>{{ guidepost.slug }}</td>
                <td>

                    <a :href="`/guide/${guidepost.slug}`" target="_blank" class="btn btn-info btn-sm">Просмотр</a>

                    <router-link :to="{ name: 'guidePostEdit', params: { slug: guidepost.slug } }"
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

        changeVisual(guidepost) {
            axios.patch(`/api/admin/guide/${guidepost.id}/toggle-visual`)
                .then(response => {
                    guidepost.is_visual = response.data.is_visual;

                })
                .catch(error => {
                    console.error('Error toggling visual status:', error);
                });
        },
    }
});
</script>