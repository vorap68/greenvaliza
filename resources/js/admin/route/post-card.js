const postCardMenuroutes = [

    /**
     * Посты для карточек 
     *  вызываются в admin/SiderMenu.vue
     * 
     */
    {
        path: '/admin/postCard/:category_name',
        name: 'postCardMenu',
        component: () => import('../postCard/index.vue'),
        props: route => ({
            category_name: route.params.category_name
        }),
    },

    /**
     * Маршрут для отображения страницы редактирования поста для карточки
     *  вызывается в admin/postCard/index.vue
     * 
     */
    {
        path: '/admin/postCard/edit/:category_name/:id',
        name: 'postCardEdit',
        component: () => import('../postCard/edit.vue'),
        props: route => ({
            category_name: route.params.category_name,
            id: route.params.id
        })

    },

    

]

export default postCardMenuroutes;