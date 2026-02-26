<template>
    <div class="container mt-4">
        <div class="border-bottom mb-4 pb-2  custom-border">
            <h3>Добавить новый пост</h3>
            <h4>1-шаг создание заставки-поста </h4>
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

        <!-- Категория -->
        <div class="mb-3">
            <label class="form-label">Категория</label>
            <select v-model="form.category" class="form-select">

                <option disabled value="">Выберите категорию</option>
                <option value="travel">Наши путешествия</option>
                <option value="guide">Путеводитель</option>
                <option value="advice">Советы и полезности</option>
                <option value="mybook">Я и мои книги</option>

            </select>
        </div>
        <input type="file" @change="onFileChange" />
        <!-- Кнопка -->
        <button class="btn btn-primary" @click="createPost">
            Создать пост
        </button>

    </div>


</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';



export default defineComponent({
    name: 'AddingPostSingle',

    data() {
        return {
            form: {
                title: "",
                description: "",
                category: "",
                image: ""
            },
            menuPosts: [] // сюда загрузим список меню-постов
        }
    },



    methods: {
        onFileChange(e) {
            this.form.image = e.target.files[0];
        },



        async createPost() {

            const formData = new FormData();
            console.log('formData', formData);
            formData.append("title", this.form.title);
            formData.append("description", this.form.description);
            formData.append("category", this.form.category);
            formData.append("image", this.form.image);



            try {
                //создаем пост-превью-заставка
                const response = await axios.post(
                    '/api/admin/create-post-single',
                    formData,
                    { headers: { "Content-Type": "multipart/form-data" } }
                );
                console.log('response.data', response.data);

                // После успешного создания пост-превью-заставка, получаем его ID и 
                // redirect  на страницу редактирования созданного поста
                this.$router.push({ name: this.form.category + 'PostEdit', params: { id: response.data.id } });

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