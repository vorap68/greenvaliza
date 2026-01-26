<template>

    <img class="post-thumb lazyloaded" :src="image.medium" :srcset="srcSet" :sizes="sizes" :alt="alt"
        data-ll-status="loaded" />
</template>

<script>
export default {
    name: 'ResponsiveImage',
    props: {
        imageName: { type: String, required: true },
        folder: { type: String, required: true },
        // slug: { type: String, required: true },
        alt: { type: String, default: '' },
        id: { type: [String, Number], default: null },
    },

    computed: {

        basePath() {
            return `/storage/images/${this.folder}/${this.id}`;
        }
        ,

        image() {
            const [name, ext] = this.imageName.split(/\.(?=[^.]+$)/)

            return {
                base: `${this.basePath}/${this.imageName}`,
                thumb: `${this.basePath}/${name}_150.${ext}`,
                small: `${this.basePath}/${name}_600.${ext}`,
                medium: `${this.basePath}/${name}_768.${ext}`,
                large: `${this.basePath}/${name}_1200.${ext}`,
            }
        },

        srcSet() {
            return `
                ${this.image.thumb} 150w, 
                ${this.image.small} 600w,
                ${this.image.medium} 768w,
                 ${this.image.large} 768w
            `
        },
        sizes() {

            return
            `(max-width: 575.98px) 100vw, 
          (max-width: 767.98px) 50vw, 
               (max-width: 991.98px) 33.333vw, 
              33.333vw`;
        }
    },


}
</script>
