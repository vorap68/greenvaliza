<template>
    <h1>Путешествия Посты-Таблицы</h1>
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

                <th>slug</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>

            <tr v-for="traveltable in sortedData" :key="traveltable.id">
                <td>{{ traveltable.id }}</td>
                <td>{{ traveltable.title }}</td>
                <td><button class="btn btn-sm" :class="traveltable.is_visual ? 'btn-success' : 'btn-outline-secondary'"
                        @click="changeVisual(traveltable)">
                        {{ traveltable.is_visual ? '👁️ Опубликован' : '🚫 Редакция' }}
                    </button>
                </td>
                <td>{{ traveltable.date }}</td>
                <td>{{ traveltable.slug }}</td>
                <td>
                    <a :href="`/travel/table/${traveltable.slug}`" target="_blank"
                        class="btn btn-info btn-sm">Просмотр</a>

                    <router-link :to="{ name: 'travelTableEdit', params: { id: traveltable.id } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>
                    <!-- <router-link :to="{ name: 'travelTableImages', params: { id: traveltable.id } }"
                        class="btn btn-secondary btn-sm">Картинки 

                    </router-link> -->
                    <router-link :to="{ name: 'PostImages', params: { id: traveltable.id, category: 'travelTable' } }"
                        class="btn btn-secondary btn-sm">Картинки</router-link>






                </td>
            </tr>

        </tbody>
    </table>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';


export default defineComponent({
    name: 'travelTables',

    data() {
        return {
            traveltables: [],
            sortColumn: null,
            sortDirection: 'asc',
        }
    },

    computed: {
        sortedData() {
            if (!this.sortColumn) {
                return this.traveltables;
            }
            return [...this.traveltables].sort((a, b) => {
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
        },


    },

    mounted() {
        console.log('TravelTableIndex component mounted.');
        this.GetTravelTables();
    },

    methods: {
        async GetTravelTables() {
            try {
                const response = await axios.get('/api/admin/travel-table');
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.traveltables = response.data.data;
                console.table('Получено:', this.traveltables);
            } catch (error) {
                console.error('Error fetching travel tables:', error);
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

        changeVisual(traveltable) {
            axios.patch(`/api/admin/travels-table/${traveltable.id}/toggle-visual`)
                .then(response => {
                    console.log('Visual status toggled:', response.data);
                    traveltable.is_visual = response.data.is_visual;
                })
                .catch(error => {
                    console.error('Error toggling visual status:', error);
                });
        },
    }
});
</script>