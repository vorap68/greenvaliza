<template>
  
                    <!-- Ответ администрации -->
                    <div class="admin-reply-card mt-4">

                        <textarea id="adminReply" ref="replyInput" v-model="reply" class="form-control reply-textarea"
                            rows="5" maxlength="5000" placeholder="Введите ответ на комментарий...">
                           
                        </textarea>

                        <div class="d-flex justify-content-between mt-2">
                            <small class="text-muted">
                                Ответ будет отображаться под комментарием
                            </small>

                            <small class="text-muted">
                                <!-- {{ reply.length }} / 5000 -->
                            </small>
                        </div>

                        <div class="text-right mt-3">
                            <button class="btn btn-outline-secondary mr-2" type="button" @click="removeAdminReply">
                               Удалить ответ
                            </button>

                            <button class="btn btn-success" type="button" @click="saveReply"> 
                                <i class="fas fa-save mr-1"></i>
                                Сохранить ответ
                            </button>
                        </div>

                    </div>

    
</template>

<script>
import { defineComponent } from 'vue';
import axios from 'axios';


export default defineComponent({
    name: 'CommentEdit',

   data() {
    return {
        reply: '',
        answer: null,
    }
        },

    props: {
       
        comment:{}
      
    },

   mounted(){
        this.reply = this.comment.admin_reply || '';
   },

    methods: {
        async saveReply() {
            try {
                console.log('Добавление  комментов от админа ' ,this.reply);
                const response = await axios.post(`api/admin/comments/${this.comment.id}/add`,
                    {
                     text:this.reply
                    }
                );
                this.answer = response.data;
                console.log('Answer from Admin', this.answer);
            } catch (error) {
                console.error('Error fetching  comments:', error);
            }
        },


        async removeAdminReply() {
            try {
                console.log('Удаление  комментов от админа ' );
                 const response = await axios.delete(`api/admin/comments/${this.comment.id}/reply-delete`);
                   console.log('реакция на удаление админ-ответа', response);
                   
            } catch (error) {
                console.error('Error fetching  comments:', error);
            }
          
        },
    }
});
</script>


<style scoped>

.admin-reply-card {
    background: #f3faf6;
    border: 1px solid #c3e6d1;
    border-radius: 7px;
    padding: 22px;
}

.admin-reply-card h5 {
    color: #246b45;
}

.reply-textarea {
    resize: vertical;
    min-height: 130px;
    line-height: 1.6;
    border-radius: 5px;
}

.reply-textarea:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
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

    .admin-reply-card {
        padding: 15px;
    }
}
</style>
