const routesAuthFront = [
    // роуты для подключ компон ogi register
    {
          path: '/login-front',
        name: 'LoginFront',
       component: () => import('../authenticate/LoginFront.vue'),
    },
    
    {
          path: '/register-front',
        name: 'RegisterFront',
       component: () => import('../authenticate/RegisterFront.vue'),
    },

    {
          path: '/auth-comment-form',
        name: 'AuthCommentForm',
       component: () => import('../comments/AuthCommentForm.vue'),
    },

    {
          path: '/comment=panel',
        name: 'CommentPanel',
       component: () => import('../comments/CommentPanel.vue'),
    }
]
export default routesAuthFront;