

const mybookAdminPostRoutes = [ 
  

    {   path: '/admin/mybookposts', component: () => import('../../mybook/index.vue'),
        name: 'mybookPosts',
          props:true,
    },
   
    
    {   path: '/admin/mybookposts/edit/:id', component: () => import('../../mybook/edit.vue'),
        name: 'mybookPostEdit',
          props:true,
       
    },
    {   path: '/admin/mybookImages/:id', component: () => import('../../mybook/mybookImages.vue'),
        name: 'mybookImages',
       props: route=> ({
          id: route.params.id, 
       })
    },

   
]

export default mybookAdminPostRoutes;