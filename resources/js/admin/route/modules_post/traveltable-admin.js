
const travelTableAdminRoutes = [

    /**
     * Маршруты для управления таблицей путешествий в админ панели
     * вызывается в admin/SiderMenu.vue
     */
    {
        path: '/admin/traveltable', component: () => import('../../travelTable/index.vue'),
        name: 'travelTables',
        props: true,
    },

/**
 * Маршрут для отображения страницы редактирования таблицы путешествий в админ панели
 * выбор по id для загрузки данных таблицы путешествий
 * вызывается в admin/travelTable/edit.vue
 */
    {
        path: '/admin/traveltable/edit/:id', component: () => import('../../travelTable/edit.vue'),
        name: 'travelTableEdit',
        props: true, 
    },
    

]

export default travelTableAdminRoutes;