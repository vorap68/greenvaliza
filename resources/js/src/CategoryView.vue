<template>
    <Suspense>
        <component :is="CurrentComponent" />
    </Suspense>
</template>
<script>
import { defineAsyncComponent } from 'vue';


export default {
    name: 'CategoryView',
    components: {

    },

    props: {
        slug: {
            type: String,
            required: true
        }
    },
    computed: {
        CurrentComponent() {
            switch (this.slug) {
                case 'putevoditeli':
                    return defineAsyncComponent(() => import('./guidebooks/Menu.vue'));
                case 'nashi-puteshestviya':
                    return defineAsyncComponent(() => import('./travels/Menu.vue'));
                case 'sovety-i-poleznosti':
                    return defineAsyncComponent(() => import('./advices/Menu.vue'));
                case 'ya-i-moi-knigi':
                    return defineAsyncComponent(() => import('./my_books/Menu.vue'));
                default:
                    return defineAsyncComponent(() => import('./Main.vue'));
            }

        }
    }
} 
</script>