

const mybookAdminPostRoutes = [ 
  

    {   path: '/admin/mybookposts', component: () => import('../../mybook/index.vue'),
        name: 'mybookPosts',
    },
    {   path: '/admin/mybookposts/show', component: () => import('../../mybook/show.vue'),
        name: 'MyBookhow',
       
    },
    {   path: '/admin/mybookposts/edit', component: () => import('../../mybook/edit.vue'),
        name: 'mybookEdit',
       
    },
    {   path: '/admin/mybookImages/:post_id', component: () => import('../../mybook/mybookImages.vue'),
        name: 'mybookImages',
       props: route=> ({
          post_id: route.params.post_id, 
       })
    },

   
]

export default mybookAdminPostRoutes;