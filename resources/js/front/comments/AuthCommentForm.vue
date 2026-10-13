<template>
    <p>
        Вы вошли как
        <strong>{{ user.name }}</strong>
    </p>
    <button type="button" class="logout-button" @click="logout"> Выйти </button>

    <form @submit.prevent="submitComment">

        <div class="form-group">

            <label for="comment">
                Ваш комментарий
            </label>

            <textarea id="comment" v-model="comment" rows="5" placeholder="Введите комментарий..."></textarea>

        </div>

        <button type="submit" class="comment-button">
            Отправить комментарий
        </button>

    </form>
    
</template>

<script>

import axios from 'axios'

export default {

    name: 'AuthCommentForm',
    props: {

        user: {
            type: Object,
            required: true
        },

      },

    data() {
        return {
            comment: '',
        }
    },



    methods: {

        async submitComment() {

            if (!this.comment.trim()) {
                return;
            }
            console.log('CommentForm submit:', this.comment);
            this.$emit('comment-created_auth', this.comment);
            this.content = '';
           
        },
        async logout() {

            try {
                await axios.post('/logout');
                console.log('Пользователь вышел'); // Сообщаем CommentPanel,  что авторизации больше нет 
                this.$emit('logout');
            } catch (error) {
                console.log('LOGOUT ERROR:', error);
            }
        }
    }

}

</script>

<style scoped>

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 7px;
    font-weight: 600;
}

.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: vertical;
    font-family: inherit;
    font-size: 15px;
    box-sizing: border-box;
}

.form-group textarea:focus {
    outline: none;
    border-color: #888;
}

.comment-button {
    margin-top: 15px;
    padding: 11px 20px;
    border: none;
    border-radius: 5px;
    background: #333;
    color: #fff;
    cursor: pointer;
}

.comment-button:hover {
    background: #555;
}

.comment-auth__loading {
    padding: 25px;
    text-align: center;
    color: #777;
}
</style>