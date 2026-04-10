<template>
  <div>

  </div>

  <div class="input-group" style="max-width: 300px;">
    <input v-model="search" type="text" class="form-control" placeholder="Поиск фото по имени..."
      @keyup.enter="GetImages" />
    <button class="btn btn-primary" @click="GetImages()">
      🔍
    </button>
  </div>


  <div class="row row-cols-1 row-cols-md-3 g-3">
    <div class="col" v-for="img in images" :key="img.id">
      <div class="card h-100 shadow-sm">

        <div class="text-center p-2">
          <img decoding="async" :src="`/storage/images/${img.category}/${img.post_id}/resize/${img.filethumb}`"
            class="img-fluid rounded" alt="image" style="max-height: 240px; width: auto; object-fit: contain;">
        </div>

        <div class="card-body pt-2">
          <p class="card-text small mb-1">
            имя: <span class="fw-semibold text-primary ms-1">{{ img.filename }}</span>
          </p>
          <p class="card-text small mb-1">
            категория: <span class="fw-semibold text-success ms-1">{{ img.category }}</span>
          </p>
          <p class="card-text small mb-1">
            id поста: <span class="fw-semibold text-dark ms-1">{{ img.post_id }}</span>
          </p>
        </div>

      </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios';
export default {
  name: "ImageSearch",

  data() {
    return {
      search: "",
      image: null,
      images: [],
    };
  },



  methods: {
    async GetImages() {
      try {
        const response = await axios.post('/api/admin/images/search',
          {
            search: this.search,
          });

        this.images = response.data.data;
        console.log('получено', this.images);
      } catch (e) {
        console.error(e);
        alert("Ошибка загрузки изображений");
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>