

const routes = [
    {
        path: '/', component: () => import('../Main.vue'),
        name: 'Main',
    },

    {
        path: '/category/:slug',
        name: 'Category',
        props: true,
        component: () => import('../CategoryView.vue'),
    }
]

export default routes;