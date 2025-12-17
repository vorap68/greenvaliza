<template>

    <img class="post-thumb lazyloaded" :src="basesrc" :srcset="srcSet" :sizes="sizes" :alt="alt" />
</template>

<script>
export default {
    name: 'ResponsiveImage',
    props: {
        slug: {
            type: String,
            required: true
        },
        imageName: {
            type: String,
            required: true
        },
        imageExten: {
            type: String,
            required: true
        },
        alt: {
            type: String,
            default: ''
        },
        folder: {
            type: String,
            required: true
        },

    },

    computed: {
        basesrc() {
            return `/storage/images/${this.folder}/${this.slug}/${this.imageName}_768x768.${this.imageExten}`;
        },
        srcSet() {
            return `/storage/images/${this.folder}/${this.slug}/${this.imageName}_thumb.${this.imageExten} 150w,
                    /storage/images/${this.folder}/${this.slug}/${this.imageName}_onesmall.${this.imageExten} 600w,
                    
                    /storage/images/${this.folder}/${this.slug}/${this.imageName}_768x768.${this.imageExten} 768w,
                     `;
        },

        sizes() {

            return
            `(max-width: 575.98px) 100vw, 
          (max-width: 767.98px) 50vw, 
               (max-width: 991.98px) 33.333vw, 
              33.333vw`;
        }
    }
}
</script>
