<template>
     <div class="comment">
        
        <div class="comment-author">
            Комментарий от:
            <strong>{{ comment.author_name || comment.user?.name || 'Гость' }}</strong>
        </div>
        <div class="comment-content">
            {{ comment.content }}
        </div>
           <div v-if="comment.admin_reply" class="admin-reply">
            <strong>Ответ администрации:</strong>
            <p>{{ comment.admin_reply }}</p>
        </div>
           
        </div>

</template>

<script >
import axios from 'axios';

export default{
    name: 'CommentItem',
    props:{
        comment:{
            type:Object,
            required:true,
        }
    }
}
</script>

<style scoped>
.comment {
    padding: 12px 15px;
    margin-bottom: 10px;
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.comment-author {
    margin-bottom: 8px;
    color: #555;
    font-size: 14px;
}

.comment-content {
    font-size: 16px;
}
.admin-reply {
    margin-top: 15px;
    padding: 12px 15px;
    background-color: #e8f4ea;
    border-left: 4px solid #4caf50;
    border-radius: 4px;
    color: #333;
}

.admin-reply strong {
    display: block;
    margin-bottom: 6px;
    color: #2e7d32;
    font-size: 14px;
}

.admin-reply p {
    margin: 0;
    line-height: 1.5;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}
</style>