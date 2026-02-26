

const travelAdminPostRoutes = [ 
  

    {   path: '/admin/travelposts', component: () => import('../../travelPost/index.vue'),
        name: 'travelPosts',
        props:true,
    },




    {   path: '/admin/travelposts/edit/:id', component: () => import('../../travelPost/edit.vue'),
        name: 'travelPostEdit',
        props:true,
       
    },
    

        {   path: '/admin/travelposts/images/:id', component: () => import('../../travelPost/images.vue'),
        name: 'travelPostImages',
       props: route=> ({
           
            id: route.params.id, 
       })
    },

   
]

export default travelAdminPostRoutes;