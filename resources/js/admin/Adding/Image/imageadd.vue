/**
* Родительский компонент для добавления изображений к постам. Позволяет
* - выбрать категорию, найти пост и выбрать пост.(selectedPost.vue)
* - загрузить изображения для выбранного поста (dropZone.vue)
* - загрузить фото без привязки к посту в папке с текущей датой.
*/
<template>
    <div class="d-flex flex-column gap-3" style="max-width: 340px;">

        <!-- Выбор поста -->
        <selectedPost @post-selected="onPostSelected" />

        <!-- Dropzone -->
        <AddingDropzone ref="index" />

        <!-- Загрузка -->
        <button class="btn btn-success" @click.prevent="storeImages" :disabled="!selectedPost">
            Загрузить изображения для выбраного поста
        </button>

        <button class="btn btn-success" @click.prevent="storeImagesNoPost">
            Добавить изображение без привязки к посту
        </button>

    </div>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import Dropzone from 'dropzone';
import AddingDropzone from './dropZone.vue';
import selectedPost from './selectedPost.vue';

/**
 * @typedef {Object} Post выбранный пост полученный из компонента selectedPost.vue
 * @property {number} id - Идентификатор поста
 * @property {string} title - Название поста
 * @property {string} category - Категория поста    
 */

/**   
* @typedef {Object} selectedPost  объект, который содержит информацию о выбранном посте и его категории.
* @property {Post} post - Выбранный пост, который содержит id и title.
* @property {string} category - Категория, к которой принадлежит выбранный пост  
*/
export default defineComponent({
    name: 'AddingImage',
    components: {
        AddingDropzone,
        selectedPost,
    },

    data() {
        return {
            /** 
             * @type {selectedPost} selectedPost - объект, который содержит информацию о выбранном посте и его категории.
             */
            selectedPost: null,
            hasFiles: false,
        }
    },

    mounted() {
        /**
         * Получаем ссылку на экземпляр Dropzone из дочернего компонента AddingDropzone.
         * Это позволяет нам управлять Dropzone и получать доступ к его методам, таким как getAcceptedFiles(), для получения списка выбранных файлов.
         * Теперь this.dropzone будет содержать экземпляр Dropzone, который мы можем использовать для загрузки изображений.
         * Важно, что мы должны убедиться, что AddingDropzone уже смонтирован
         */
        this.dropzone = this.$refs.index.dropzone;
    },

    methods: {
        /**
         * 
         * Метод для обработки события выбора поста из компонента selectedPost.vue.
         *  Принимает объект с выбранным постом и его категорией, сохраняет эти данные в локальных переменных и эмитирует событие 'post-selected' с этими данными для передачи их в родительский компонент.
          * @param {selectedPost} объект, который содержит информацию о выбранном посте и его категории.
         * @param {Post}  Выбранный пост, который содержит id и title.  
         * @param {string} category - Категория, к которой принадлежит выбранный пост.  
         */
        onPostSelected({ post, category }) {
            this.selectedPost = post;
            this.category = category;
            console.log('Выбран пост:', this.selectedPost.title);
            console.log('Выбрана категория:', this.category);
        },

        /**
         * Загрузка изображений для выбранного поста.
         *  Получаем файлы из Dropzone и проверяем, что они есть. 
         *  Создаем объект FormData и добавляем в него файлы и название поста.
         *  Отправляем POST-запрос на сервер с данными изображений и информацией о посте.
         */
        async storeImages() {
            /**
             * Получаем список файлов, которые были добавлены в Dropzone и готовы к загрузке.
             *  Если файлов нет, выводим предупреждение и прекращаем выполнение функции.
             *  Если файлы есть, создаем новый объект FormData и добавляем в него
             *  каждый файл с ключом 'images[]', 
             *  а также добавляем название поста для связи изображений
             */
            const files = this.dropzone.getAcceptedFiles();
            console.log('Выбранные файлы для загрузки:', files);

            if (!files.length) {
                alert('Выберите файлы');
                return;
            }

            const images = new FormData();
            files.forEach((file, index) => {
                images.append('images[]', file);
            });
            images.append('post_title', this.selectedPost.title);

            try {
                /**
                 * Отправляем POST-запрос на сервер по адресу
                 *  /api/admin/create-image/{category}/{post_id} с данными изображений 
                 * и информацией о посте.
                 *  Сервер сохранит эти изображения и свяжет их с указанным постом.
                 *  В случае успешной загрузки, выводим информацию о посте
                 *  и количестве сохраненных изображений. В случае ошибки,
                 *  выводим сообщение об ошибке в консоль.
                 */
                const response = await axios.post(
                    `/api/admin/create-image/${this.category}/${this.selectedPost.id}`,
                    images,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                );
                console.log('Успех:', response.data);
                alert(
                    `Пост: ${response.data.post}\n` +
                    `Сохранено новых фото: ${response.data.saved_images}`
                );
            } catch (error) {
                console.error('Ошибка загрузки:', error);
            }
        },

        /**
         * Загрузка изображений без привязки к посту.
         *  Получаем файлы из Dropzone и проверяем, что они есть. 
         *  Создаем объект FormData и добавляем в него файлы.
         *  Отправляем POST-запрос на сервер с данными изображений.
         *  Сервер сохранит эти изображения в папке с текущей датой
         */
        async storeImagesNoPost() {
            const files = this.dropzone.getAcceptedFiles();
            console.log('Выбранные файлы для загрузки:', files);

            if (!files.length) {
                alert('Выберите файлы');
                return;
            }

            const images = new FormData();
            files.forEach((file, index) => {
                images.append('images[]', file);
            });

            try {
                /**
                 * Отправляем POST-запрос на сервер по адресу /api/admin/create-image/nopost 
                 * с данными изображений.   
                 */
                const response = await axios.post(
                    `/api/admin/create-image/nopost`,
                    images,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }
                );
                console.log('Успех:', response.data);
                alert(
                    `Пост: ${response.data.post}\n` +
                    `Сохранено новых фото: ${response.data.saved_images}`
                );
            } catch (error) {
                console.error('Ошибка загрузки:', error);
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