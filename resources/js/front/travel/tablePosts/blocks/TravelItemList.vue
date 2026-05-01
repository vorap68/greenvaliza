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
          <table width="85%" border="0" align="center" style="border-spacing: 3px; border-collapse: separate;">
            <tbody>
              <!-- /**
              * Здесь цикл обращений к каждому элементу из массива items, который передается в компонент.
              * Для каждого элемента создается строка таблицы, которая состоит из трех ячеек:
              * 1. Левая ячейка, которая содержит изображение,
              * 2. Центральная ячейка, которая содержит заголовок элемента, который может быть ссылкой, если у элемента
              есть slug,
              * 3. Правая ячейка, которая содержит изображение.
              * Фон каждой ячейки может быть задан индивидуально через свойство background элемента,
              * или по умолчанию будет использоваться светло-желтый цвет #FDF5E6, если background не указан.
              */ -->
              <tr v-for="(item, i) in items" :key="i">
                <td width="37%" :style="{
                  backgroundColor: item.background || '#FDF5E6'
                }">
                  <img :src="item.left_image" />
                </td>

                <td width="23%" bgcolor="#FDF5E6" align="center" :style="{
                  backgroundColor: item.background || '#FDF5E6'
                }">
                  <em>
                    <strong>
                      <span style="font-size: x-large;">
                        <!-- /**
                        * Cсылка на страницу путешествия, final-пост
                        */ -->
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
