<template>
    <section class="comments-block">

        <h2>Добавить комментарий</h2>

        <div class="comment-panel">

            <!-- Пока проверяем авторизацию -->
            <div v-if="loading" class="auth-loading">
                Проверяем авторизацию...
            </div>

            <!-- Не авторизован -->
            <GuestCommentForm v-else-if="!user"
             @comment-created_guest='handleChildEvent' />

            <!-- Авторизован -->
            <AuthCommentForm v-else :user="user"
             @comment-created_auth='handleChildEvent' 
              @logout="handleLogout" />

        </div>
    </section>
</template>

<script>
import axios from 'axios';
import Comments from './Comments.vue';
import GuestCommentForm from './GuestCommentForm.vue';
import AuthCommentForm from './AuthCommentForm.vue';

export default {

    name: 'CommentPanel',

    components: {
        AuthCommentForm,
        GuestCommentForm
    },

    props: {

        postType: {
            type: String,
            required: true
        },
        postId:{
            type: String,
            required: true
        }
    },

    data() {
        return {
            user: null,
            loading: true,
            content: ''
        }
    },

    async mounted() {

        try {

            console.log('Компонент открыт');

            const response = await axios.get('/api/user');

            this.user = response.data;
         console.log('AUTH USER:', this.user);

        } catch (error) {
            this.user = null;
            console.log('Пользователь не авторизован');

        } finally {

            this.loading = false;

        }
    },

    methods: {
       async handleChildEvent(content) {
            
            this.content = content;
            const postType = this.postType.charAt(0).toUpperCase() + this.postType.slice(1);

            const commentableType = `App\\Models\\Posts\\${postType}Post`; 
            
            console.log('postId:',this.postId);
            console.log('commentable_type:', commentableType);
          
            console.log('Комментарий от дочернего компонента:', this.content );
                 const data = {
                content:  this.content,
                 commentable_type: commentableType,
               commentable_id:this.postId
            };
            console.log('Отправляем:', data);
            let url;
             url = `/api/${this.postType}/${this.postId}/comments`;
             console.log('url',url);
            const response = await axios.post(url, data);
           console.log(response.data);
           //await this.fetchComments();
        },

        handleLogout() {
            this.user = null;
        }

    }

}

</script>

<style scoped>
.comments-block {
    background: #f5f5f5;
    padding: 25px;
    margin-top: 30px;
}
</style>