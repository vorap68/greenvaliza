
const guideAdminPostRoutes = [ 
  
    {   path: '/admin/guideposts', component: () => import('../../guide/index.vue'),
        name: 'guidePosts',
         props:true,
    },

    // {   path: '/admin/guideposts/show/:slug', component: () => import('../../guide/show.vue'),
    //     name: 'guideShow',
    //      props:true,
       
    // },

    {   path: '/admin/guideposts/edit/:slug', component: () => import('../../guide/edit.vue'),
        name: 'guidePostEdit',
         props:true,
       
    },

    {   path: '/admin/guideImages/:post_id', component: () => import('../../guide/guideImages.vue'),
        name: 'guideImages',
       props: route=> ({
         post_id: route.params.post_id, 
       })
    },

   
]

export default guideAdminPostRoutes;