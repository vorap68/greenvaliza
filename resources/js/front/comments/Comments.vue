<template>
    <section class="comments-block">

        <h2>Комментарии</h2>
        <div v-if="comments.length">
            <h3>Комментарии к посту</h3>
            <CommentItem v-for="comment in comments" :key="comment.id" :comment="comment" />
        </div>
        <div v-else>
            Комментариев пока нет.
        </div>
    </section>
</template>
<script>

import axios from 'axios';
import CommentItem from './CommentItem.vue';


export default {
    name: 'Comments',

    components: {
        CommentItem,
    },

    props: {
        postId: {
            type: String,
            required: true,
        },
        postType: {
            type: String,
            required: true,
        }
    },

    data() {
        return {
            comments: [],
            content: '',
            commentable_type: this.postType,
            parent_id: null,
            loading: false,
        };
    },

    async mounted() {
        await this.fetchComments(); 
    },

    methods: {

        async fetchComments() {
            this.loading = true;

            try {
                let url;
                url = `/api/${this.postType}/${this.postId}/comments`;
                console.log('COMMENTS URL:', url);
                const response = await axios.get(url);
                this.comments = response.data.comments;
                console.log('comments', this.comments);

            } catch (error) {
                console.error('Error fetching comments:', error);
            }
        },
    },
}


</script>

<style scoped>
.comments-block {
    background: #f5f5f5;
    padding: 25px;
    margin-top: 30px;
}
</style>