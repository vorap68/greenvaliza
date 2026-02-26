 
const routes = [ 
    {
        path: '/admin/', component: () => import('../Main.vue'), 
        name: 'adminMain',
    },
    
    {
        path: '/admin/post-single-add', component: () => import('../Adding/post-single-add.vue'), 
        name: 'AddingPostSingle', 
        props:true,
    },
    {
        path: '/admin/post-table-add', component: () => import('../Adding/post-table-add.vue'), 
        name: 'AddingPostTable', 
        props:true,
    },

    {
        path: '/admin/post-for-table-add', component: () => import('../Adding/post-for-table-add.vue'), 
        name: 'AddingPostForTable', 
        props:true,
    },

    {
        path: '/admin/menuadd', component: () => import('../Adding/menuadd.vue'), 
        name: 'AddingMenu',
    },
    {
        path: '/admin/imageadd', component: () => import('../Adding/imageadd.vue'), 
        name: 'AddingImage',
    },
]

export default routes;