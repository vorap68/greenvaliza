

const travelAdminPostRoutes = [ 
  

    {   path: '/admin/travelposts', component: () => import('../../travelPost/index.vue'),
        name: 'travelPosts',
        props:true,
    },



    {   path: '/admin/travelposts/show/:slug', component: () => import('../../travelPost/show.vue'),
        name: 'travelPostShow',
        props:true,
       
    },

    {   path: '/admin/travelposts/edit/:slug', component: () => import('../../travelPost/edit.vue'),
        name: 'travelPostEdit',
        props:true,
       
    },
    

        {   path: '/admin/travelposts/images/:post_id', component: () => import('../../travelPost/images.vue'),
        name: 'travelPostImages',
       props: route=> ({
           
            post_id: route.params.post_id, 
       })
    },

   
]

export default travelAdminPostRoutes;