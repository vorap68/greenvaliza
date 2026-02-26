<template>
    <div class="card" style="width:auto;">
        <div class="card-body">


            <div class="d-flex flex-column gap-3">
                <div>
                    <li class="nav-item">
                        <a :href="`/travel/table/${traveltable.slug}`" target="_blank" class="btn btn-info btn-sm">
                            👁️
                            Предпросмотр</a>
                    </li>
                </div>
                <div class="card-title text-center">
                    <h3>{{ traveltable.title }}(таблица)</h3>
                </div>
                <div class="d-flex flex-column gap-2">
                    <input type="text" v-model="traveltable.title" class="form-control">

                    <button class="btn btn-primary align-self-start" @click="changeTitle">
                        💾 Изменить название таблицы
                    </button>
                </div>
                <div class="mb-3">
                    <p class="text-muted mb-1">*Путь для фото</p>

                    <div class="d-flex align-items-center gap-2">
                        <input type="text" class="form-control"
                            :value="`/storage/images/travel/table/${traveltable.id}/`" readonly>

                        <button class="btn btn-outline-secondary" @click="copyPath">
                            Копировать
                        </button>
                    </div>
                </div>

                <div>
                    <Codemirror v-model="traveltable.content" :extensions="extensions" :theme="oneDark" :style="{
                        height: '500px',
                        border: '1px solid #ccc',
                        borderRadius: '6px'
                    }" />
                </div>
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
    name: 'TravelTableEdit',
    components: {
        Codemirror,
    },
    props: ['id'],

    data() {
        return {
            traveltable: {
                title: '',
                content: '',
            },
            extensions: [html()],
            oneDark,
            loading: true,
        }
    },

    async mounted() {
        this.GetTravelTable();
    },

    methods: {
        async GetTravelTable() {
            try {
                // this.loading = true;
                const response = await axios.get('/api/admin/travel-table/' + this.id);
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const traveltable = response.data.data;
                console.log('Полученное ВСе:', response.data.data);
                console.log('Полученный пост:', traveltable.slug);
                console.log('Полученный контент:', traveltable.content);

                // автоформатирование HTML-контента
                let rawContent = traveltable.content ?? '';
                console.log('Сырой контент до форматирования:', rawContent);
                traveltable.content = beautifyHtml(rawContent, {
                    indent_size: 2,
                    wrap_line_length: 120,
                    preserve_newlines: true,
                    end_with_newline: true,
                    unformatted: [],
                });

                // сохраняем в data()
                this.traveltable = traveltable;

            } catch (error) {
                console.error('Error fetching travel table:', error);
                // } finally {
                //     this.loading = false;
            }
        },

        async changeTitle() {
            const newTitle = this.traveltable.title.trim();
            console.log('Новое название:', newTitle);
            try {
                const result = await axios.put(`/api/admin/change-title-travel/table/${this.traveltable.id}`, {
                    title: newTitle,
                });
                console.log('Изменено:', result.data.slug);
                console.log('Изменено:', result.data

                );
                alert('✅ Название поста успешно изменено!');
                //this.traveltable.slug = result.data.slug; // обновляем slug
                this.$router.replace({ name: 'travelTableEdit', params: { post_id: this.traveltable.id } });

            } catch (error) {
                console.error('Ошибка при изменении:', error);
                alert('❌ Ошибка при изменении имени поста');
            }
        },

        copyPath() {
            const path = `/storage/images/travel/table/${this.traveltable.id}/`;
            navigator.clipboard.writeText(path);
        },

        async saveChanges() {
            try {
                const result = await axios.put('/api/admin/travel-table/' + this.traveltable.id, {
                    content: this.traveltable.content,
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