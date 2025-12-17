<template>
    <div class="card" style="width:auto;">
        <div class="card-body">
            <h5 class="card-title">{{ advicepost.title }}</h5>
            <!-- Переключатель вкладок -->
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <button class="nav-link" :class="{ active: activeTab === 'edit' }" @click="activeTab = 'edit'">
                        ✏️ Редактировать
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" :class="{ active: activeTab === 'preview' }"
                        @click="activeTab = 'preview'">
                        👁️ Предпросмотр
                    </button>
                </li>
            </ul>
            <!-- Вкладка редактирования -->
            <div v-if="activeTab === 'edit'">
                <Codemirror v-model="advicepost.content" :extensions="[html()]" :theme="oneDark" :style="{
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

            <!-- Вкладка предпросмотра -->
            <div v-else class="preview-container p-3 border rounded bg-light">
                <div v-html="advicepost.content"></div>
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
    name: 'AdviceEdit',
    components: { Codemirror },

    data() {
        return {
            advicepost: {},
            activeTab: 'edit', // edit | preview
            html,
            oneDark,
        }
    },

    async mounted() {
        this.GetAdvicePost();
    },

    methods: {
        async GetAdvicePost() {
            try {
                const response = await axios.get('/api/admin/mybook/' + this.$route.query.slug);
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const post = response.data.data;
                console.log('Полученный пост на редактирование :', post);

                // автоформатирование HTML-контента
                post.content = beautifyHtml(post.content || '', {
                    indent_size: 2,
                    wrap_line_length: 120,
                    preserve_newlines: true,
                    end_with_newline: true,
                    unformatted: [],
                });

                // сохраняем в data()
                this.advicepost = post;

            } catch (error) {
                console.error('Error fetching guide post:', error);
            }
        },

        async saveChanges() {
            try {
                const result = await axios.put('/api/admin/advices/' + this.advicepost.id, {
                    content: this.advicepost.content,
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

.preview-container {
    background-color: #fafafa;
    min-height: 500px;
    overflow: auto;
}
</style>