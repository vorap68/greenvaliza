<template>
    <div ref="dropzone" class="border border-2 border-dashed rounded p-4 text-center bg-dark text-light"
        style="cursor:pointer">
        <h5 class="mb-0">Добавить фото</h5>
    </div>
</template>
<script>
import { defineComponent } from 'vue';
import Dropzone from 'dropzone';
export default defineComponent({
    name: 'AddingDropzone',

    data() {
        return {
            dropzone: null,
        }
    },



    async mounted() {
        /**
   * Инициализация Dropzone и настройка параметров. Dropzone будет привязан к div с ref="dropzone". 
    - URL для загрузки: /api/admin/create-image
    - Прикрепляемые файлы: только изображения
    - Автоматическая загрузка отключена (autoProcessQueue: false), чтобы мы могли контролировать момент отправки.
    - Добавляем ссылки для удаления файлов и настраиваем текст для кнопки удаления.
   * После инициализации Dropzone, он будет готов принимать файлы для загрузки
   */
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/admin/create-image',
            clickable: true,
            acceptedFiles: 'image/*',
            autoProcessQueue: false,
            addRemoveLinks: true,
            dictRemoveFile: 'Удалить файл',
            maxFilesize: 15,
        });
        console.log(this.dropzone);
    },
})

</script>