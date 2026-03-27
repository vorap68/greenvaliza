
const travelAdminTableRoutes = [

    //роут для просмотра
    {
        path: '/admin/traveltable', component: () => import('../../travelTable/index.vue'),
        name: 'travelTables',
        props: true,
    },


    {
        path: '/admin/traveltable/edit/:id', component: () => import('../../travelTable/edit.vue'),
        name: 'travelTableEdit',
        props: true, 
    },
    
        {   path: '/admin/traveltable/images/:id', component: () => import('../../travelTable/images.vue'),
        name: 'travelTableImages',
       props: route=> ({
           
            id: route.params.id, 
       })
    },
  


]

export default travelAdminTableRoutes;