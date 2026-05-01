/**
 * Роуты для добавления постов , таблиц , фото 
 * все вызываются в admin/SiderMenu.vue
 */
const routes = [
    {
        path: '/admin/', component: () => import('../Main.vue'),
        name: 'adminMain',
    },

    {
        path: '/admin/post-single-add', component: () => import('../Adding/post-single-add.vue'),
        name: 'AddingPostSingle',
    },

    {
        path: '/admin/post-table-add', component: () => import('../Adding/post-table-add.vue'),
        name: 'AddingPostTable',
    },

    {
        path: '/admin/post-for-table-add', component: () => import('../Adding/post-for-table-add.vue'),
        name: 'AddingPostForTable',
    },

    {
        path: '/admin/menuadd', component: () => import('../Adding/menuadd.vue'),
        name: 'AddingMenu',
    },

    {
        path: '/admin/image/imageadd', component: () => import('../Adding/Image/imageadd.vue'),
        name: 'AddingImage',
    },
]

export default routes;