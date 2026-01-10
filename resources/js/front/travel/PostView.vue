<template>
    <Suspense>
        <component :is="CurrentComponent" :slug="slug" />
    </Suspense>
</template>
<script>
import { defineAsyncComponent } from 'vue';


export default {
    name: 'PostView',
    components: {

    },

    props: {
        slug: String,
        type: String
    },

    computed: {
        consoleLog() {
            console.log('PostView component loaded with slug:', this.slug, 'and type:', this.type);
        },

        //выбор компонента в зависимости от типа либо меню-table либо пост-final
        CurrentComponent() {
            switch (this.type) {
                case 'menus':
                    console.log('Loading travel-table-post component for slug:', this.slug);
                    return defineAsyncComponent(() => import('./tablePosts/travel-table.vue'));
                case 'posts':
                    console.log('Loading travel-post component for slug:', this.slug);
                    return defineAsyncComponent(() => import('./endPosts/travel-post.vue'));

            }

        }
    }
} 
</script>