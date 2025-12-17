
const guideAdminPostRoutes = [ 
  
    {   path: '/admin/guideposts', component: () => import('../../guide/index.vue'),
        name: 'guidePosts',
    },

    {   path: '/admin/guideposts/show', component: () => import('../../guide/show.vue'),
        name: 'guideShow',
       
    },

    {   path: '/admin/guideposts/edit', component: () => import('../../guide/edit.vue'),
        name: 'guideEdit',
       
    },

    {   path: '/admin/guideImages/:post_id', component: () => import('../../guide/guideImages.vue'),
        name: 'guideImages',
       props: route=> ({
         post_id: route.params.post_id, 
       })
    },

   
]

export default guideAdminPostRoutes;