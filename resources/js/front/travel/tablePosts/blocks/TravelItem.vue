<template>
  <div class="item">
    <img :src="item.left_image" />

    <router-link v-if="item.slug" :to="`/travel/final/${item.slug}`">
      {{ item.title }}
    </router-link>

    <span v-else>
      {{ item.title }}
    </span>

    <img :src="item.right_image" />
  </div>
</template>

<script>
export default {
  name: 'TravelItem',

  props: ['item']
};
</script>
