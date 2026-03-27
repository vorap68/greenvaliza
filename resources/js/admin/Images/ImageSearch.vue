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

  <!-- <div class="col" v-for="img in imagesArray">
      <div class="card h-100 shadow-sm">
        <img decoding="async" :src="`/storage/images/${img.category}/${img.post_id}/resize/${img.filethumb}`"
          class="card-img-top" alt="image">
        <div class="card-body">
          <p class="card-text small">{{ img.filethumb }}</p>

        </div>
      </div>
    </div> -->
  <div class="col" v-for="img in images">
    <div class="card h-100 shadow-sm">


      <div class="card-body">
        <div class="card h-100 shadow-sm">
          <img decoding="async" :src="`/storage/images/${img.category}/${img.post_id}/resize/${img.filethumb}`"
            class="card-img-top" alt="image">
        </div>
        <p class="card-text small">{{ img.filename }}</p>
        <p class="card-text small">{{ img.category }}</p>
        <p class="card-text small">{{ img.post_id }}</p>

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