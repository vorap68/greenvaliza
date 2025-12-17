<template>
    <div class="container mt-4">

        <h3>Добавить новый пост</h3>

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

        <!-- Родительское меню-пост -->
        <div class="mb-3">
            <label class="form-label">Меню-пост-родитель (опционально)</label>

            <select v-model="form.parent_title" class="form-select">
                <option value="">Без родителя</option>

                <option v-for="item in menuPosts" :value="item.title">
                    {{ item.title }}
                </option>
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
    name: 'AddingPost',

    data() {
        return {
            form: {
                title: "",
                description: "",
                category: "",
                parent_title: "",
                image: ""
            },
            menuPosts: [] // сюда загрузим список меню-постов
        }
    },

    computed: {

    },

    async mounted() {
        await this.loadMenuPosts();
    },

    methods: {
        onFileChange(e) {
            this.form.image = e.target.files[0];
        },

        async loadMenuPosts() {
            // пример — бери меню из /api/admin/advice (или любой свой маршрут)
            const response = await axios.get('/api/admin/travels-menu');
            this.menuPosts = response.data.data;
        },

        async createPost() {

            const formData = new FormData();
            formData.append("title", this.form.title);
            formData.append("description", this.form.description);
            formData.append("category", this.form.category);
            formData.append("image", this.form.image);
            formData.append("parent_title", this.form.parent_title);

            try {
                const response = await axios.post(
                    '/api/admin/create-post',
                    formData,
                    { headers: { "Content-Type": "multipart/form-data" } }
                );

                console.log(response.data);
                alert("Пост создан!");
                // redirect
                this.$router.push({ name: this.form.category + 'Edit', query: { slug: response.data.slug } });

            } catch (e) {
                console.error(e);
                alert("Ошибка создания поста");
            }
        }
    }

});
</script>