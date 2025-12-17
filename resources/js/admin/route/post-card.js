
const postCardMenuroutes = [

    {
        path: '/admin/postCard/:category_name',
        name: 'postCardMenu',
        component: () => import('../postCard/index.vue'),
        props: route => ({
            category_name: route.params.category_name
        }),
    },

    {
        path: '/admin/postCard/edit/:category_name/:slug',
        name: 'postCardEdit',
        component: () => import('../postCard/edit.vue'),
        props: route => ({
            category_name: route.params.category_name,
            slug: route.params.slug
        })

    },

    

]

export default postCardMenuroutes;