
const imagesAdminRoutes = [

    {
        path: '/admin/images/imageSearch', component: () => import('../../Images/ImageSearch.vue'),
        name: 'ImageSearch',
    },

    {
        path: '/admin/images/Category', component: () => import('../../Images/CategoryImages.vue'),
        name: 'CategoryImages',
    },

    {
        path: '/admin/images/Card', component: () => import('../../Images/CardImages.vue'),
        name: 'CardImages',
    },

    //роут вызывается в index постов для получ ВСЕХ фото даного поста из таблицы images
    {
        path: '/admin/PostImages/:category/:id', component: () => import('../../Images/PostImages.vue'),
        name: 'PostImages',
        props: route => ({
            id: route.params.id,
            category: route.params.category 
        })
    },
]


export default imagesAdminRoutes;