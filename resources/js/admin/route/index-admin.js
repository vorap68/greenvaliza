 
const routes = [ 
    {
        path: '/admin/', component: () => import('../Main.vue'), 
        name: 'adminMain',
    },
    
    {
        path: '/admin/postadd', component: () => import('../Adding/postadd.vue'), 
        name: 'AddingPost',
    },

    {
        path: '/admin/menuadd', component: () => import('../Adding/menuadd.vue'), 
        name: 'AddingMenu',
    },
]

export default routes;