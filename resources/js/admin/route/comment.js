const commentsForPost =
[
    {
         path: '/admin/comment/:category/:postId', 
        name: 'CommentEdit',
        component: () => import('../Comments/commentEdit.vue'),
           props: route => ({
            category: route.params.category,
             postId: route.params.postId ,
           }) 
    }
]

export  default commentsForPost;