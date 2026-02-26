<template>
  <table v-if="images && images.length" width="90%" align="center">
    <tbody>
      <tr v-for="(img, index) in images" :key="index">
        <td class="gallery-td" align="center">
          <img :src="img" loading="lazy" decoding="async" />

        </td>

      </tr>

    </tbody>
  </table>
</template>

<script>
export default {
  name: 'TravelGallery',

  props: {
    images: {
      type: Array,
      required: true
    }
  }
};
</script>

<style scoped>
/* аналог <p class="ab">&nbsp;</p> */


/* td как в старой table */

/* картинки — широкие, одна под другой */
.gallery-td img {
  width: 100%;
  max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto;
}

/* отступ между изображениями (как margin-top: 20px) */
tr+tr .gallery-td img {
  margin-top: 20px;
}
</style>
