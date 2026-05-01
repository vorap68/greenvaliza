/**
* Компонент для отображения адаптивного изображения с поддержкой различных размеров и форматов.
* Использует пропсы для получения информации о изображении и вычисляет пути к различным размерам изображения.
*/
<template>
    <img class="post-thumb lazyloaded" :src="image.medium ? image.medium : '/image/no-image.jpg'" :srcset="srcSet"
        :sizes="sizes" :alt="alt" data-ll-status="loaded" />
</template>

<script>
export default {
    name: 'ResponsiveImage',
    props: {
        /**
         * @type {string}   Имя файла фото получ с БД.
         */
        imageName: { type: String, required: true },

        /**
         * @type {string}   Папка, в которой хранятся изображения категории.
         */
        folder: { type: String, required: true },

        /**
         * @type {string|number}   id (категории , поста, таблицы), для полного пути к фото 
         */
        id: { type: [String, Number], default: null },
        alt: { type: String, default: '' },

    },

    computed: {

        basePath() {
            return `/storage/images/${this.folder}/${this.id}/resize`;
        }
        ,

        image() {
            // 👉 если нет имени картинки
            if (!this.imageName) {
                return {
                    base: '/storage/images/no-image.jpg',
                    thumb: '/storage/images/no-image.jpg',
                    small400: '/storage/images/no-image.jpg',
                    small: '/storage/images/no-image.jpg',
                    medium: '/storage/images/no-image.jpg',
                    large: '/storage/images/no-image.jpg',
                }
            }

            const [name, ext] = this.imageName.split(/\.(?=[^.]+$)/)

            return {
                base: `${this.basePath}/${this.imageName}`,
                thumb: `${this.basePath}/${name}_150.${ext}`,
                small400: `${this.basePath}/${name}_400.${ext}`,
                small: `${this.basePath}/${name}_600.${ext}`,
                medium: `${this.basePath}/${name}_768.${ext}`,
                large: `${this.basePath}/${name}_1200.${ext}`,
            }
        },

        srcSet() {
            return `
                ${this.image.thumb} 150w, 
                  ${this.image.small400} 400w,
                ${this.image.small} 600w,
                ${this.image.medium} 768w,
                 ${this.image.large} 1200w
            `
        },

        sizes() {
            return `(max-width: 575.98px) 100vw, 
          (max-width: 767.98px) 50vw, 
               (max-width: 991.98px) 33.333vw, 
              33.333vw`;
        }
    },

}
</script>
