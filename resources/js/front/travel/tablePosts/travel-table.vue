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

export default {
  name: 'travel-postmenu',

  props: ['slug'],

  components: {
    BreadCrumb,
    TravelHeader,
    TravelGallery,
    TravelItemList
  },

  data() {
    return {
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
      if (!this.travel.id) return {};
      return {
        backgroundImage: `url('/storage/images/travel/table/${this.travel.id}/firstfon.jpg')`,
        backgroundPosition: 'center',
      };
    }
  },


  methods: {
    async fetchData() {
      const response = await axios.get(`/api/travels/table/${this.slug}`);
      this.travel = response.data;
      console.log('Fetched travel dataAll:', this.travel.content);
      document.title = this.travel.title;
    }
  }
};
</script>
