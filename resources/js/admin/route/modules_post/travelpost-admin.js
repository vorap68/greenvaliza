const travelPostAdminRoutes = [ 
  
    /**
     * вызывается в admin/SiderMenu.vue
     * Маршруты для управления постами о путешествиях в админ панели
     * Касается всех постов и final и single
     */
    {   path: '/admin/travelposts', component: () => import('../../travelPost/index.vue'),
        name: 'travelPosts',
        props:true,
    },

    /**
     * вызывается в admin/travelPost/edit.vue
     * Маршрут для отображения страницы редактирования поста о путешествии в админ панели
     * выбор по id для загрузки данных поста
     * Касается всех постов и final и single
     */
    {   path: '/admin/travelposts/edit/:id', component: () => import('../../travelPost/edit.vue'),
        name: 'travelPostEdit',
        props:true,
           },
    
]

export default travelPostAdminRoutes;