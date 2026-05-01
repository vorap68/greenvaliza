
const imagesAdminRoutes = [

    /**
     *  РоутРоут вызывается в admin/SiderMenu.vue  для поиска изображений  
     */
    {
        path: '/admin/images/imageSearch', component: () => import('../../Images/ImageSearch.vue'),
        name: 'ImageSearch',
    },

    /** 
     * Роут вызывается в admin/SiderMenu.vue для отображения всех  изображений по категориям 
     */
    {
        path: '/admin/images/Category', component: () => import('../../Images/CategoryImages.vue'),
        name: 'CategoryImages',
    },
 
        /** 
         * Роут Роут вызывается в admin/SiderMenu.vue для отображения всех  изображений для карточек меню по категориям 
         */
    {
        path: '/admin/images/Card', component: () => import('../../Images/CardImages.vue'),
        name: 'CardImages',
    },

    //роут вызывается в index постов для получ ВСЕХ фото данного поста из таблицы images
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