
const guideAdminPostRoutes = [ 
  
    {   path: '/admin/guideposts', component: () => import('../../guide/index.vue'),
        name: 'guidePosts',
         props:true,
    },


    {   path: '/admin/guideposts/edit/:id', component: () => import('../../guide/edit.vue'),
        name: 'guidePostEdit',
         props:true,
       
    },

    {   path: '/admin/guideImages/:id', component: () => import('../../guide/guideImages.vue'),
        name: 'guideImages',
       props: route=> ({
         id: route.params.id, 
       })
    },

   
]

export default guideAdminPostRoutes;