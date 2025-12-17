
const adviceAdminPostRoutes = [ 
  
    {   path: '/admin/adviceposts', component: () => import('../../advice/index.vue'),
        name: 'advicePosts',
    },
    {   path: '/admin/adviceposts/show', component: () => import('../../advice/show.vue'),
        name: 'adviceShow',
       
    },
    {   path: '/admin/adviceposts/edit', component: () => import('../../advice/edit.vue'),
        name: 'adviceEdit',
       
    },
    {   path: '/admin/adviceImages/:post_id', component: () => import('../../advice/adviceImages.vue'),
        name: 'adviceImages',
       props: route=> ({
          post_id: route.params.post_id, 
       })
    },

 
    

   
]

export default adviceAdminPostRoutes;