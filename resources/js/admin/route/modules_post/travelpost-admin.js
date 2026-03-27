

const travelAdminPostRoutes = [ 
  

    {   path: '/admin/travelposts', component: () => import('../../travelPost/index.vue'),
        name: 'travelPosts',
        props:true,
    },




    {   path: '/admin/travelposts/edit/:id', component: () => import('../../travelPost/edit.vue'),
        name: 'travelPostEdit',
        props:true,
       
    },
    


   
]

export default travelAdminPostRoutes;