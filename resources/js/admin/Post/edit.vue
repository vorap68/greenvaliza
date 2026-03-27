<template>
    <div class="card" style="width:auto;">
        <div class="card-body">


            <div class="d-flex flex-column gap-3">
                <div>
                    <li class="nav-item">
                        <a :href="`/${category}/${post.slug}?type=posts `" target="_blank" class="btn btn-info btn-sm">
                            👁️
                            Предпросмотр</a>
                    </li>
                </div>
                <div class="card-title text-center">
                    <h3>{{ post.title }}</h3>
                </div>
                <div class="d-flex flex-column gap-2">
                    <input type="text" v-model="post.title" class="form-control">

                    <button class="btn btn-primary align-self-start" @click="changeTitle">
                        💾 Изменить название поста
                    </button>
                </div>


                <div>
                    <Codemirror v-model="post.content" :extensions="[html()]" :theme="oneDark" :style="{
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



export default defineComponent({
    name: 'postAdminEdit',
    components: { Codemirror },
    props: ['id',
        'category'
    ],

    data() {
        return {
            post: {},
            html,
            oneDark,

        }
    },

    async mounted() {

        await this.GetPost();
        console.log('Редактирование поста с категория:', this.category);
    },

    methods: {
        async GetPost() {
            try {
                const response = await axios.get(`/api/admin/${this.category}/${this.id}`);
                if (!response.data) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const postContent = response.data.data;
                //console.log('Полученный пост на редактирование :', post);

                // автоформатирование HTML-контента
                postContent.content = beautifyHtml(postContent.content || '', {
                    indent_size: 2,
                    wrap_line_length: 120,
                    preserve_newlines: true,
                    end_with_newline: true,
                    unformatted: [],
                });

                // сохраняем в data()
                this.post = postContent;

            } catch (error) {
                console.error('Error fetching advice post:', error);
            }
        },

        async changeTitle() {
            const newTitle = this.post.title.trim();
            //console.log('Новое название:', newTitle);
            try {
                const result = await axios.put(`/api/admin/change-title/${this.category}/${this.post.id}`, {
                    title: newTitle,
                });
                console.log('Изменено:', result.data.slug);
                console.log('Изменено:', result.data

                );
                alert('✅ Название поста успешно изменено!');
                //this.advicepost.slug = result.data.slug; // обновляем slug
                this.$router.replace({ name: 'postAdminEdit', params: { id: this.post.id, category: this.category } });
                //this.GetAdvicePost();
            } catch (error) {
                console.error('Ошибка при изменении:', error);
                alert('❌ Ошибка при изменении имени поста');
            }
        },


        async saveChanges() {
            try {
                const result = await axios.put(`/api/admin/${this.category}/${this.post.id}`, {
                    content: this.post.content,
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