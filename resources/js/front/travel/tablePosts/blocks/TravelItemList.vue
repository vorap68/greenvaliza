<template>
  <!-- ВНЕШНЯЯ ТАБЛИЦА С ФОНОМ -->
  <table class="travel-items-wrapper" width="90%" border="1" align="center" :style="{
    backgroundImage: `url(${header.background})`
      ? `url(${header.background})`
      : null
  }">
    <tbody>
      <tr>
        <td height="900">

          <!-- ВНУТРЕННЯЯ ТАБЛИЦА -->
          <table width="85%" border="0" align="center"
           style="border-spacing: 3px; border-collapse: separate;"
         >
            <tbody>
              <tr v-for="(item, i) in items" :key="i">
                <td width="37%" :style="{
  backgroundColor: item.background || '#FDF5E6'
}">
                  <img :src="item.left_image" />
                </td>

                <td width="23%" bgcolor="#FDF5E6" align="center"
                 :style="{
  backgroundColor: item.background || '#FDF5E6'
}">
                  <em>
                    <strong>
                      <span style="font-size: x-large;">
                        <router-link v-if="item.slug" :to="`/travel/final/${item.slug}`">
                          {{ item.title }}
                        </router-link>
                        <span v-else>
                          {{ item.title }}
                        </span>
                      </span>
                    </strong>
                  </em>
                </td>

                <td width="37%" :style="{
  backgroundColor: item.background || '#FDF5E6'
}">
                  <img :src="item.right_image" />
                </td>
              </tr>
            </tbody>
          </table>

        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: 'TravelItemList',

  props: {
    items: Array,
    header: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>
img {
  width: 100%;
  height: auto;
  display: block;
}

span {
  font-family: 'PT Serif';
}
</style>
