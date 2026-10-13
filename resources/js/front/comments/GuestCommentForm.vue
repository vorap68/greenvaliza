<template>
    <div>        
        <p>
                    Вы вошли как
                    <strong>Гость</strong>
                </p>
                <div>
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
            <h3>Уже есть аккаунт </h3>
            <router-link :to="{
                path: '/login-front',
                query: {
                    redirect: $route.fullPath
                }
            }"> Войти</router-link>
            <h3>Регистрация</h3>
            <router-link :to="{
                path: '/register-front',
                query: {
                    redirect: $route.fullPath
                }
            }"> Регистрация</router-link>
        </div>
    </div>
</template>

<script>

import axois from 'axios'


export default {
    name: 'GuestCommentForm',

    data() {
        return {
            content: '',
        };
    },

    methods: {
        async submitComment() {

            if (!this.comment.trim()) {
                return;
            }
            console.log('CommentForm submit:', this.comment);
            this.$emit('comment-created_guest', this.comment);
            this.content = '';
        },
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