<template>
  <table class="travel-header" width="90%" border="2" align="center">
    <tbody>
      <tr>
        <td class="cell image-cell" :style="{ backgroundImage: `url(${header.background})` }" width="201" height="181"
          align="center">
          <img :src="header.left_image" width="120" height="120" /> 
        </td>

        <td class="cell title-cell" :style="{ backgroundImage: `url(${header.background})` }" width="570"
          align="center">
          <p class="title" :style="{ color: header.title_color || '#708090' }">
            {{ header.title }}
          </p>

          <p class="subtitle" :style="{ color: header.subtitle_color || '#708090' }">
            {{ header.subtitle }}
          </p>
        </td>

        <td class="cell image-cell" :style="{ backgroundImage: `url(${header.background})` }" width="201" height="181"
          align="center">
          <img :src="header.right_image" width="120" height="120" />
        </td>
      </tr>
    </tbody>
  </table>
</template>



<script>
export default {
  name: "TravelHeader",

  props: {
    header: {
      type: Object,
      required: true
    }
  },
  async mounted() {
    console.log(this.header)
  },

};
</script>

<style scoped>
.travel-header {
  border-collapse: collapse;
}

.cell {
  border-width: 2px;
  background-size: cover;
  background-position: center;
}

.title {
  font-family: 'PT Serif';
  font-size: 32px;
  font-style: italic;
  font-weight: bold;

  margin: 0;
}

.subtitle {
  font-family: 'PT Serif';
  font-size: 24px;
  font-style: italic;

  font-weight: bold;
  margin-top: 40px;
}
</style>
