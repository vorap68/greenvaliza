

const mybookAdminPostRoutes = [ 
  

    {   path: '/admin/mybookposts', component: () => import('../../mybook/index.vue'),
        name: 'mybookPosts',
          props:true,
    },
    // {   path: '/admin/mybookposts/show/:slug', component: () => import('../../mybook/show.vue'),
    //     name: 'MyBookShow',
    //       props:true,
       
    // },
    {   path: '/admin/mybookposts/edit/:slug', component: () => import('../../mybook/edit.vue'),
        name: 'mybookPostEdit',
          props:true,
       
    },
    {   path: '/admin/mybookImages/:post_id', component: () => import('../../mybook/mybookImages.vue'),
        name: 'mybookImages',
       props: route=> ({
          post_id: route.params.post_id, 
       })
    },

   
]

export default mybookAdminPostRoutes;