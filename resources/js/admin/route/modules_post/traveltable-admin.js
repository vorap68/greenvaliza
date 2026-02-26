
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
  


]

export default travelAdminTableRoutes;