<template>

    <div class="border-bottom mb-4 pb-2  custom-border">
        <h3>Добавить новое меню</h3>
        <h4>1-шаг создание заставки-поста</h4>
    </div>
    <div class="container mt-4">
        <!-- Имя менюпоста -->
        <div class="mb-3">
            <label class="form-label">название поста-меню</label>
            <input type="text" v-model="form.title" class="form-control" placeholder="Введите название поста">
        </div>

        <!-- Описание -->
        <div class="mb-3">
            <label class="form-label">Описание поста-меню</label>
            <textarea class="form-control" rows="3" v-model="form.description"
                placeholder="Краткое описание"></textarea>

        </div>
        <input type="file" @change="onFileChange" />
        <button class="btn btn-primary" @click="createTable">
            Создать пост-меню
        </button>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';

export default defineComponent({
    name: 'AddingTable',

    data() {
        return {
            form: {
                title: '',
                description: '',
                image: '',
            },
        }
    },

    methods: {
        onFileChange(e) {
            this.form.image = e.target.files[0];
        },
        async createTable() {

            const formData = new FormData();
            formData.append("title", this.form.title);
            formData.append("description", this.form.description);

            formData.append("image", this.form.image);


            try {
                //создаем пост-превью-заставка
                const response = await axios.post(
                    '/api/admin/create-table',
                    formData,
                    { headers: { "Content-Type": "multipart/form-data" } }
                );
                console.log('response.data', response.data);
                console.log('data_slug', response.data.slug);


                // redirect  на страницу редактирования созданного поста
                this.$router.push({ name: 'travelTableEdit', params: { slug: response.data.slug } });

            } catch (e) {
                console.error(e);
                alert("Ошибка создания поста-меню");
            }
        }
    },
});
</script>