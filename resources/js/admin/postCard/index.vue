<template>
    <h1>Окна меню от {{ this.category_name }}</h1>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Заголовок
                </th>
                <th>
                    Описание
                </th>
                <th> Статус </th>
                <th>
                    Дата публикации
                </th>
                <th>Картинка</th>
                <th>slug</th>

                <th>Действия</th>
            </tr>
        </thead>
        <tbody>

            <tr v-for="postCard in postCards" :key="postCard.id">
                <td>{{ postCard.id }}</td>
                <td>{{ postCard.title }}</td>
                <td>{{ postCard.description }}</td>
                <td><button @click="changeVisual(postCard)" class="btn btn-sm"
                        :class="postCard.is_visual ? 'btn-success' : 'btn-outline-secondary'">
                        {{ postCard.is_visual ? '👁️ Опубликован' : '🚫 Редакция' }}
                    </button>
                </td>
                <td>{{ postCard.date }}</td>
                <td><img
                        :src="`/storage/images/categoryMenu/${category_name}/${postCard.id}/original/${postCard.image}`">
                </td>

                <td>{{ postCard.slug }}</td>
                <td>

                    <router-link
                        :to="{ name: 'postCardEdit', params: { category_name: category_name, id: postCard.id } }"
                        class="btn btn-warning btn-sm">Редактирование</router-link>
                </td>
            </tr>


        </tbody>
    </table>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';


export default defineComponent({
    name: 'PostCardsIndex',

    data() {
        return {
            postCards: [],
        }
    },

    props: ['category_name'],

    watch: {
        // category_name(newValue, oldValue) {
        //     this.GetPostCardMenu();
        // }
        '$route.params.category_name': {
            immediate: true,
            handler(newValue, oldValue) {
                console.log('Категория изменилась:', oldValue, '→', newValue);
                this.GetPostCardMenu();
            }
        }
    },


    mounted() {
        console.log('PostCadrs component mounted.');
        // this.GetPostCardMenu();
    },

    methods: {
        async GetPostCardMenu() {
            try {
                const response = await axios.get(`/api/admin/postcard-menu/${this.category_name}`);
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                this.postCards = response.data;
                console.log(this.postCards);
            } catch (error) {
                console.error('Error fetching :', error);
            }
        },

        changeVisual(postCard) {
            axios.patch(`/api/admin/postcard/${this.category_name}/${postCard.id}/toggle-visual`)
                .then(response => {
                    postCard.is_visual = response.data.is_visual;
                })
                .catch(error => {
                    console.error('Error toggling visual status:', error);
                });
        },
    }
});
</script>