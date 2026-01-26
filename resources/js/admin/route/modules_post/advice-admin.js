
const adviceAdminPostRoutes = [ 
  
    {   path: '/admin/adviceposts', component: () => import('../../advice/index.vue'),
        name: 'advicePosts',
        props:true,
    },

    // {   path: '/admin/adviceposts/show/:slug', component: () => import('../../advice/show.vue'),
    //     name: 'adviceShow',
    //      props:true,
       
    // },

    {   path: '/admin/adviceposts/edit/:post_id', component: () => import('../../advice/edit.vue'),
        name: 'advicePostEdit',
         props:true,
       
    },
    
    {   path: '/admin/adviceImages/:post_id', component: () => import('../../advice/adviceImages.vue'),
        name: 'adviceImages',
       props: route=> ({
          post_id: route.params.post_id, 
       })
    },

 
    

   
]

export default adviceAdminPostRoutes;