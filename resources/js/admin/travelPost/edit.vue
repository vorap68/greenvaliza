<template>
    <div class="card" style="width:auto;">
        <div class="card-body">
            <h5 class="card-title">{{ travelpost.title }}</h5>
            <!-- Переключатель вкладок -->
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <button class="nav-link">
                        ✏️ Редактировать
                    </button>
                </li>
                <li class="nav-item">

                    <a :href="`/travel/${travelpost.slug}?type=posts `" target="_blank" class="btn btn-info btn-sm"> 👁️
                        Предпросмотр</a>
                </li>
            </ul>
            <!-- Вкладка редактирования -->
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

</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';

// CodeMirror imports

import { Codemirror } from 'vue-codemirror';
import { html } from '@codemirror/lang-html';
import { oneDark } from '@codemirror/theme-one-dark';
import { html as beautifyHtml } from 'js-beautify'; // 👈 импорт форматтера



export default defineComponent({
    name: 'TravelEdit',
    components: { Codemirror },
    props: ['slug'],

    data() {
        return {
            travelpost: {},

            html,
            oneDark,
        }
    },

    async mounted() {
        this.GetTravelPost();
    },

    methods: {
        async GetTravelPost() {
            try {
                const response = await axios.get('/api/admin/travels-post/' + this.slug);
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
                console.error('Error fetching travel post:', error);
            }
        },

        async saveChanges() {
            try {
                const result = await axios.put('/api/admin/travels-post/' + this.travelpost.id, {
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