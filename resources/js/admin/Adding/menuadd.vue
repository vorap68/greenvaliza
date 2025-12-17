<template>
    <h1>Меню для поста наши путешествия</h1>
    <!-- Имя менюпоста -->
    <div class="mb-3">
        <label class="form-label">название поста-меню</label>
        <input type="text" v-model="form.title" class="form-control" placeholder="Введите название поста">
    </div>

    <!-- Описание -->
    <div class="mb-3">
        <label class="form-label">Описание поста-меню</label>
        <textarea class="form-control" rows="3" v-model="form.description" placeholder="Краткое описание"></textarea>
    </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'AddingMenu',

    data() {
        return {
            form: {
                title: '',
                description: '',
            },
        }
    },

    methods: {
        async createMenu() {
            try {
                const response = await axios.post('/api/admin/create-menu', this.form);
                console.log('Меню успешно создано:', response.data);
            } catch (error) {
                console.error('Ошибка при создании меню:', error);
            }

            this.$router.push({ name: 'AddingPost', query: { slug: response.data.slug } });
        },
    },
});
</script>