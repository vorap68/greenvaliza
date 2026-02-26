<template>
    <div class="card shadow-sm border-0 rounded-3 p-3" style="max-width: 28rem;">

        <!-- Текущее изображение -->
        <img v-if="postCard.image"
            :src="`/storage/images/categoryMenu/${category_name}/${postCard.id}/${postCard.image}`"
            class="card-img-top mb-3 rounded" alt="Изображение поста">

        <div class="card-body">

            <!-- Заголовок -->
          
<h3 class="fw-bold mb-3">
    {{ postCard.title }}
</h3>

          <!-- Описание -->
            <label class="fw-bold">Описание</label>
            <textarea v-model="postCard.description" class="form-control mb-3"></textarea>

            <!-- Новая картинка -->
            <label class="fw-bold">Новое изображение</label>
            <input type="file" @change="onImageChange" class="form-control mb-3" />

            <!-- Дата -->
            <p class="text-secondary small">
                <i class="bi bi-calendar3"></i>
                Дата публикации: <strong>{{ postCard.date }}</strong>
            </p>



            <div class="mt-3 text-end">
                <button class="btn btn-primary" @click="saveChanges">
                    💾 Сохранить изменения
                </button>
            </div>

        </div>
    </div>
</template>

<script>
import axios from "axios";
import { defineComponent } from "vue";

export default defineComponent({
    name: "PostCardEdit",

    props: ["category_name", "slug"],

    data() {
        return {
            postCard: {},
            newImage: null // здесь будет храниться выбранное новое изображение
        };
    },

    mounted() {
        this.loadPostCard();
    },

    methods: {
        // Загружаем данные карточки 
        async loadPostCard() {
            try {
                const response = await axios.get(
                    `/api/admin/postcard/${this.category_name}/${this.slug}`
                );
                console.log("Загруженная карточка редактирования:", response.data);
                this.postCard = response.data;

            } catch (error) {
                console.error("Ошибка при загрузке карточки:", error);
            }
        },

        // Обработка выбора нового изображения
        onImageChange(event) {
            this.newImage = event.target.files[0];
        },

        // Сохранение изменений
        async saveChanges() {
            try {
                const formData = new FormData();
                formData.append("title", this.postCard.title);
                formData.append("description", this.postCard.description);

                if (this.newImage) {
                    formData.append("image", this.newImage);
                }

                const response = await axios.post(
                    `/api/admin/postcard/update/${this.category_name}/${this.slug}`,
                    formData,
                    { headers: { "Content-Type": "multipart/form-data" } }
                );
                //console.log("Изменения:", response.data.data);
                console.log("Изменения:", response.data);
                alert("Изменения успешно сохранены!");
                this.$router.push({ name: 'postCardMenu', params: { category_name: this.category_name } });


            } catch (error) {
                console.error("Ошибка сохранения:", error);
                alert("Ошибка при сохранении");
            }
        }
    }
});
</script>
