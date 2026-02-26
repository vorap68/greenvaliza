<template>
    <div class="container mt-4">
        <div class="border-bottom mb-4 pb-2  custom-border">
            <h3>Добавить новый пост</h3>
            <h4>1-шаг выбор таблицы </h4>
        </div>

        <!-- Имя поста -->
        <div class="mb-3">
            <label class="form-label">Имя поста</label>
            <input type="text" v-model="form.title" class="form-control" placeholder="Введите название поста">
        </div>

        <!-- Описание -->
        <div class="mb-3">
            <label class="form-label">Описание поста</label>
            <textarea class="form-control" rows="3" v-model="form.description"
                placeholder="Краткое описание"></textarea>
        </div>


        <label class="form-label">список пост-таблица.</label>

        <select v-model="form.parent_title" class="form-select">
            <option disabled value="">Выберите пост-таблицу</option>

            <option v-for="item in menuPosts" :value="item.id" :key="item.id">
                {{ item.title }}
            </option>
        </select>
    </div>
    <button class="btn btn-primary" @click="createPost">
        Создать пост
    </button>





</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';



export default defineComponent({
    name: 'AddingPostForTable',

    data() {
        return {
            form: {
                title: "",
                description: "",
                parent_title: "",

            },
            menuPosts: [] // сюда загрузим список меню-постов
        }
    },


    async mounted() {
        await this.loadTables();
    },

    methods: {
        onFileChange(e) {
            this.form.image = e.target.files[0];
        },

        async loadTables() {
            const response = await axios.get('/api/admin/travel-table');
            this.menuPosts = response.data.data;
            console.log('menuPosts', this.menuPosts);
        },

        async createPost() {

            const formData = new FormData();
            console.log('formData', formData);
            formData.append("title", this.form.title);
            formData.append("description", this.form.description);
            formData.append("table_id", this.form.parent_title);

            try {
                //создаем пост-превью-заставка
                const response = await axios.post(
                    '/api/admin/create-post-for-table',
                    formData,
                    { headers: { "Content-Type": "multipart/form-data" } }
                );
                console.log('response.data.componet.add', response.data);


                // redirect  на страницу редактирования созданного поста
                this.$router.push({
                    name: 'travelPostEdit', params: { id: response.data.id }
                }); // передаем id поста и таблицы в параметры маршрута


            } catch (e) {
                console.error(e);
                alert("Ошибка создания поста (component)");
            }
        }
    }

});
</script>
<style>
.custom-border {
    border-color: #28a745 !important;
}
</style>