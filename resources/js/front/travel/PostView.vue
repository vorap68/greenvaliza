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
        CurrentComponent() {
            switch (this.type) {
                case 'menus':
                    console.log('Loading travel-postmenu component for slug:', this.slug);
                    return defineAsyncComponent(() => import('./menuPosts/travel-postmenu.vue'));
                case 'posts':
                    console.log('Loading travel-postmenu component for slug:', this.slug);
                    return defineAsyncComponent(() => import('./endPosts/travel-post.vue'));

            }

        }
    }
} 
</script>