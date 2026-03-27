<template>
  <div>
    <label class="form-label">Категория</label>
    <select v-model="category" class="form-select">
      <option disabled value="">Выберите категорию</option>
      <option value="travelPost">Наши путешествия (Посты)</option>
      <option value="travelTable">Наши путешествия (Посты-таблицы)</option>
      <option value="guide">Путеводитель</option>
      <option value="advice">Советы и полезности</option>
      <option value="mybook">Я и мои книги</option>
    </select>
  </div>

  <div v-if="category" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">


    <div class="col" v-for="img in imagesArray">
      <div class="card h-100 shadow-sm">
        <img decoding="async" :src="`/storage/images/${category}/${img.post_id}/resize/${img.filethumb}`"
          class="card-img-top" alt="image">
        <div class="card-body">
          <p class="card-text small">{{ img.filethumb }}</p>

        </div>
      </div>
    </div>
  </div>
  <div v-if="pagination" class="d-flex justify-content-center mt-4">

    <button class="btn btn-outline-secondary me-2" :disabled="!pagination.prev_page_url"
      @click="loadPosts(pagination.current_page - 1)">
      ←
    </button>

    <span class="align-self-center">
      {{ pagination.current_page }} / {{ pagination.last_page }}
    </span>

    <button class="btn btn-outline-secondary ms-2" :disabled="!pagination.next_page_url"
      @click="loadPosts(pagination.current_page + 1)">
      →
    </button>

  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: "CategoryImages",

  data() {
    return {
      category: '',
      imagesArray: [],
      pagination: null
    };
  },

  watch: {
    category(newCategory) {
      if (!newCategory) return;
      this.loadPosts(1);
    },
  },


  methods: {
    async loadPosts(page = 1) {
      console.log('Загрузка изображений для категории:', this.category);
      const response = await axios.get(`/api/admin/images/${this.category}?page=${page}`)
      console.log('Ответ от сервера:', response.data);

      this.imagesArray = response.data.imageData.data || []; // на случай, если в ответе нет поля images
      console.log('Загруженные изображения:', this.imagesArray);
      this.pagination = response.data.imageData

    },

  },
};
</script>

<style lang="scss" scoped></style>