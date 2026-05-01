/**
* Родительский Компонент для отображения страницы таблицы путешествий.
* Особенорсть его в том ,что здесь не просто отображается контент с БД
* А данные поля content проходят через специальный парсер
* app/Services/TravelContentParser.php
* для парсинга HTML-контента из travel-table-post и извлечения данных для header, gallery и items
* Используется для обработки контента при извлечении постов в категорию travel-final на фронте
* Позволяет извлекать изображения, заголовки, подзаголовки, цвета текста и другие данные из HTML-структуры поста
* Те DomDocument и DOMXPath для парсинга HTML и извлечения нужных данных
* для удобной работы с компонентом на фронте
* и формировать массив данных для сохранения в базе данных и отображения на сайте.
* И компелируется из следующих дочерних компонентов:
* - TravelHeader: отображает верхнюю рамку с название и 2-мя мал фото.
* - TravelGallery: отображает галерею изображений путешествия.
* - TravelItemList: отображает список пунктов путешествия.
*/
<template>
  <BreadCrumb parent-slug="nashi-puteshestviya" parent-title="Наши путешествия" :current-title="travel.title" />
  <div class="post-container-block" :style="containerStyle">
    <div class="content-block" v-if="travel.content">
      <TravelHeader :header="travel.content.header" />
      <p class="ab">&nbsp;</p>
      <TravelGallery v-if="travel.content.gallery.length" :images="travel.content.gallery" />
      <p class="ab">&nbsp;</p>
      <TravelItemList :items="travel.content.items" :header="travel.content.header" />
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import BreadCrumb from '../../BreadCrumb.vue';
import TravelHeader from './blocks/TravelHeader.vue';
import TravelGallery from './blocks/TravelGallery.vue';
import TravelItemList from './blocks/TravelItemList.vue';

/**
 * @typedef {Object} Travel
 * @property {number} id - id поста
 * @property {string} slug -  slug поста
 * @property {string} title -  title поста.
 * @property {Object} content - Это сформированный DOM-объект из поля content в БД, 
 * @property {Ob]ect} content.header - 
 * @property {Array} content.gallery -
 * @property {Object} content.items - массив объектов
 */
export default {
  name: 'travel-postmenu',

  props: [
    /**
     * slug поста, который используется для получения данных о посте и формирования пути к фоновому изображению.
    * @type {string}
    */
    'slug'],

  components: {
    BreadCrumb,
    TravelHeader,
    TravelGallery,
    TravelItemList
  },

  data() {
    return {
      /**
       * @type {Travel}
       */
      travel: {
        content: null
      }
    };
  },

  async mounted() {
    await this.fetchData();
  },

  computed: {
    containerStyle() {
      /**
       * Готовим фоновое фото 
       */
      if (!this.travel.id) return {};
      return {
        /**
       * Устанавливаем фоновое изображение для блока поста. Путь к изображению формируется на основе slug поста.
       * В папке каждого поста должно быть изображение с именем firstfon.jpg, 
       * которое будет использоваться в качестве фонового изображения.
        */
        backgroundImage: `url('/storage/images/travelTable/${this.travel.id}/firstfon.jpg')`,
        backgroundPosition: 'center',
      };
    }
  },

  methods: {
    async fetchData() {
      const response = await axios.get(`/api/travel/table/${this.slug}`);
      this.travel = response.data;
      console.log('Fetched travel dataAll:', this.travel.content);
      document.title = this.travel.title;
    }
  }
};
</script>
