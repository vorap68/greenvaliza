 
const routes = [ 
    {
        path: '/admin/', component: () => import('../Main.vue'), 
        name: 'adminMain',
    },
    
    {
        path: '/admin/postadd', component: () => import('../Adding/postadd.vue'), 
        name: 'AddingPost', 
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