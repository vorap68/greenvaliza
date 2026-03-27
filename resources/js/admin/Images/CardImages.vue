<template>
  <div>
    <label class="form-label">Категория</label>
    <select v-model="categoryCard" class="form-select">
      <option disabled value="">Выберите категорию</option>
      <option value="travel">Наши путешествия</option>
      <option value="guide">Путеводитель</option>
      <option value="advice">Советы и полезности</option>
      <option value="mybook">Я и мои книги</option>
    </select>
  </div>

  <div v-if="categoryCard" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">


    <div class="col" v-for="img in imagesArray">
      <div class="card h-100 shadow-sm">
        <img decoding="async" :src="`/storage/images/categoryMenu/${categoryCard}/${img.id}/original/${img.imageName}`"
          class="card-img-top" alt="image">
        <div class="card-body">
          <p class="card-text small">{{ img.filethumb }}</p>

        </div>
      </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios';
export default {
  name: "CardImages",

  data() {
    return {
      categoryCard: '',
      imagesArray: [],

    };
  },

  watch: {
    categoryCard(newCategory) {
      if (!newCategory) return;
      this.loadPosts();
    },
  },


  methods: {
    async loadPosts() {
      console.log('Загрузка изображений для категории:', this.categoryCard);
      const response = await axios.get(`/api/admin/images/card/${this.categoryCard}`)
      console.log('Ответ от сервера:', response.data);
      this.imagesArray = response.data;
      console.log('Загруженные изображения:', this.imagesArray);

    },

  },
};
</script>

<style lang="scss" scoped></style>