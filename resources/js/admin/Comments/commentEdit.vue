<template>
    <div class="container-fluid comment-admin-page">
          <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="mb-1">Редактирование комментария</h2>
                </div>
            </div>
  <!-- Информация о посте -->
                    <div v-if="post" class="post-info mt-3">
                        <span>Пост: </span>
                        <strong>{{ post.title }}</strong>
                        <span>   Id: </span>
                        <strong>{{ post.id }}</strong>
                    </div>

        <div v-for="comment in comments" :key="comment.id"
         class="comment-item">
            <!-- Заголовок -->
          
            <!-- Основная карточка -->
            <div class="card comment-card">

                <div class="card-body">

                    <!-- Информация об авторе -->
                    <div class="d-flex align-items-center mb-3 flex-wrap">

                        <div class="ml-3">
                            <h5 class="mb-1">Автор: {{ comment.author_name }}</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 flex-wrap">

                          <span v-if="Number(comment.status) === 0">
                            Статус: Скрыт
                        </span>

                        <span v-else>
                            Статус: Опубликован
                        </span>
                    </div>

                    <!-- Текст комментария -->
                    <div class="comment-content">
                        {{ comment.content }}
                    </div>

                  
                    <!-- Действия администратора -->
                    <div class="comment-actions mt-4">
                        <button class="btn btn-danger" type="button" @click="removeComment(comment)">
                            Удалить
                        </button>
                        <button @click="changeStatus(comment)" class="btn btn-info" type="button"> 
                            Изменить статус
                        </button>
                    </div>
                 <CommentAddAdmin :comment = "comment"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';
import commentsForPost from '../route/comment';
import CommentAddAdmin from './commentAddAdmin.vue';
 

export default defineComponent({
    name: 'CommentEdit',

components:{
    CommentAddAdmin,
},

    data() {
        return {
            post:null,
            comments: [],
        }
    },

    props: {
        /**
         * @type {string} - категория постов 
         */
        category: {
            type: String,
            required: true
        },

        postId: {
            type: String,
            required: true
        },
       
    },

    mounted() {
        console.log('Получаем пост');
        this.getPost();
        console.log('Получаем комменты к посту:', this.postId, 'Категории:', this.category);
        this.getComments();
    },


    methods: {
        async getPost()
        {
            try{
                console.log('Загрузка  поста ');
                const response = await axios.get(`/api/admin/${this.category}/${this.postId}`);
                this.post = response.data.data;
                console.log('current post :', this.post);
           } catch (error) {
                console.error('Error fetching  comments:', error);
            }
           
        },

        async getComments() {
            try {
                console.log('Загрузка  комментов ');
                const response = await axios.get(`api/admin/${this.category}/${this.postId}/comments`);
                this.comments = response.data.comments;
                console.log('Comments for this post', this.comments);
            } catch (error) {
                console.error('Error fetching  comments:', error);
            }
        },

        async changeStatus(comment) {

            console.log('commentId:', comment.id);

            const response = await axios.post(`api/admin/comments/${comment.id}/changeStatus`);
            console.log('новый статус', response.data);
            comment.status = response.data.change;
        },

        async removeComment(comment) {
            try {
                // Отправляем прямой DELETE-запрос
              console.log('commentId:', comment.id);
            const response = await axios.delete(`api/admin/comments/${comment.id}/remove`);
                 this.comments = this.comments.filter(
            item => item.id !== comment.id
        );

        alert('Запись успешно удалена!');

            } catch (error) {
                console.error('Ошибка при удалении:', error);
            }
           }
    }
});
</script>


<style scoped>
.comment-admin-page {
    padding: 25px;
    color: #343a40;
}

.comment-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.comment-content {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 20px;
    line-height: 1.7;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.post-info {
    padding: 10px 0;
    color: #6c757d;
    border-bottom: 1px solid #e9ecef;
}

.comment-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    flex-wrap: wrap;
}
/* Разделение комментариев */
.comment-item {
    margin-bottom: 25px;
    padding-bottom: 25px;
    border-bottom: 1px solid #dee2e6;
}


@media (max-width: 576px) {
    .comment-admin-page {
        padding: 10px;
    }

    .comment-actions {
        justify-content: flex-start;
    }

    .comment-actions .btn {
        flex: 1 1 auto;
    }

    
}
</style>
