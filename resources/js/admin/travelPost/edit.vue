<template>
    <div class="card" style="width:auto;">
        <div class="card-body">
            <div v-if="travelpost" class="d-flex flex-column gap-3">
                <div>
                    <li class="nav-item">
                        <a :href="`/travel/final/${travelpost.slug} `" target="_blank" class="btn btn-info btn-sm">
                            👁️
                            Предпросмотр</a>
                    </li>
                </div>
                <div v-if="travelpost.table_id">Таблица: {{ travelpost.sense }}</div>
                <div class="card-title text-center">
                    <h3>{{ travelpost.title }}</h3>
                </div>
                <div class="d-flex flex-column gap-2">
                    <input type="text" v-model="travelpost.title" class="form-control">

                    <button class="btn btn-primary align-self-start" @click="changeTitle">
                        💾 Изменить название поста
                    </button>
                </div>

                <div>
                    <Codemirror v-model="travelpost.content" :extensions="[html()]" :theme="oneDark" :style="{
                        height: '500px',
                        border: '1px solid #ccc',
                        borderRadius: '6px'
                    }" />
                    <div class="mt-3 text-end">
                        <button class="btn btn-primary" @click="saveChanges">
                            💾 Сохранить
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';

// CodeMirror imports

import { Codemirror } from 'vue-codemirror';
import { html } from '@codemirror/lang-html';
import { oneDark } from '@codemirror/theme-one-dark';
import { html as beautifyHtml } from 'js-beautify'; // 👈 импорт форматтера


/** @typedef {Object} TravelPost
 * @property {number} id - ID путешествия
 * @property {string} title - Заголовок путешествия
 * @property {string} content - Содержание путешествия
 * @property {string} slug - Slug путешествия
 * @property {string} sense - Тип путешествия
 */
export default defineComponent({
    name: 'TravelEdit',
    components: { Codemirror },
    props: [
        /** @type {number} */
        'id'],

    data() {
        return {
            travelpost: null,
            html,
            oneDark,
        }
    },

    async mounted() {
        console.log('ID поста для редактирования:', this.id);
        console.log(' таблицы (если есть):', this.table);
        this.GetTravelPost();
    },

    methods: {
        async GetTravelPost() {
            try {
                const response = await axios.get(`/api/admin/travel-post/${this.id}`);
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const post = response.data.data;
                console.log('Полученный пост:', post);

                // автоформатирование HTML-контента
                post.content = beautifyHtml(post.content || '', {
                    indent_size: 2,
                    wrap_line_length: 120,
                    preserve_newlines: true,
                    end_with_newline: true,
                    unformatted: [],
                });

                // сохраняем в data()
                this.travelpost = post;

            } catch (error) {
                console.error('Error fetching travelpost post:', error);
            }
        },

        async changeTitle() {
            const newTitle = this.travelpost.title.trim();
            console.log(' поста sense:', this.travelpost.sense);


            try {
                /**
                 * изменения названия по происходит разному для одиночного поста и поста внутри таблицы
                 * поэтому что в контроллере разные методы для изменения названия
                 * @type {string} type - тип изменения названия 
                 * ('single' для одиночного поста, 'final' для поста внутри таблицы)
                 */
                const type = this.travelpost.sense === 'SinglePost'
                    ? 'single'
                    : 'final';
                console.log('Тип изменения названия:', type);
                const result = await axios.put(`/api/admin/change-title-travel/post/${type}/${this.travelpost.id}`, {
                    title: newTitle,
                });
                //console.log('Изменено:', result.data.);
                console.log('Изменено:', result.data);
                alert('✅ Название поста успешно изменено!');

                this.$router.replace({ name: 'travelPostEdit', params: { id: this.travelpost.id } });

            } catch (error) {
                console.error('Ошибка при изменении:', error);
                alert('❌ Ошибка при изменении имени поста');
            }
        },

        async saveChanges() {
            try {
                const result = await axios.put('/api/admin/travel-post/' + this.travelpost.id, {
                    content: this.travelpost.content,
                });
                console.log('Сохранено:', result.data);
                alert('✅ Изменения успешно сохранены!');
            } catch (error) {
                console.error('Ошибка при сохранении:', error);
                alert('❌ Ошибка при сохранении');
            }
        },
    },

});
</script>

<style>
.cm-editor {
    font-size: 14px;
    font-family: 'Fira Code', monospace;
}
</style>