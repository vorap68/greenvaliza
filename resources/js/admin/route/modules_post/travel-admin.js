

const travelAdminPostRoutes = [ 
  

    {   path: '/admin/travelposts', component: () => import('../../travel/index.vue'),
        name: 'travelPosts',
    },
    {   path: '/admin/travelposts/show', component: () => import('../../travel/show.vue'),
        name: 'travelShow',
       
    },
    {   path: '/admin/travelposts/edit', component: () => import('../../travel/edit.vue'),
        name: 'travelEdit',
       
    },
    {   path: '/admin/travelImages/:post_id', component: () => import('../../travel/travelImages.vue'),
        name: 'travelImages',
       props: route=> ({
           
            post_id: route.params.post_id, 
       })
    },

   
]

export default travelAdminPostRoutes;