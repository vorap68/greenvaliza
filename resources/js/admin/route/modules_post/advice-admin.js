
const adviceAdminPostRoutes = [ 
  
    {   path: '/admin/adviceposts', component: () => import('../../advice/index.vue'),
        name: 'advicePosts',
        props:true,
    },

   
    {   path: '/admin/adviceposts/edit/:id', component: () => import('../../advice/edit.vue'),
        name: 'advicePostEdit',
         props: route=> ({
          id: route.params.id, 
       })
       
    },
    
    {   path: '/admin/adviceImages/:id', component: () => import('../../advice/adviceImages.vue'),
        name: 'adviceImages',
       props: route=> ({
          id: route.params.id, 
       })
    },

 
    

   
]

export default adviceAdminPostRoutes;