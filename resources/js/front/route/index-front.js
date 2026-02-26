//import travelMenuRoutes from './modules/travelMenuRoutes';

const routesfront = [
    {
        path: '/', component: () => import('../Main.vue'),
        name: 'Main',
    },

    {
        path: '/:slug',
        name: 'Category',
        props: true,
        component: () => import('../CategoryView.vue'),
    },

    {
        path: '/travel/:slug',
        name: 'travel-postmenu',
        component: () => import('../travel/PostView.vue'),
        props: route => ({
            slug: route.params.slug,
            type: route.query.type
        })
    },
    {
        path: '/travel/final/:slug',
        name: 'travel-final-post',
        component: () => import('../travel/endPosts/travel-post.vue'),
        props: route => ({
            slug: route.params.slug,
            type: route.query.type
        })
    },
    {
        path: '/travel/table/:slug',
        name: 'travel-table-post',
        component: () => import('../travel/tablePosts/travel-table.vue'),
        props: route => ({
            slug: route.params.slug,
            type: route.query.type
        })
    },
    
    {
        path: '/guide/:slug',
        name: 'guide-post',
        component: () => import('../guide/guide-post.vue'),
        props: route => ({
            slug: route.params.slug,
          
        })
    },
    {
        path: '/advice/:slug',
        name: 'advice-post',
        component: () => import('../advice/advice-post.vue'),
        props: route => ({
            slug: route.params.slug,
          
        })
    },
    
    {
        path: '/mybook/:slug',
        name: 'mybook-post',
        component: () => import('../mybook/mybook-post.vue'),
        props: route => ({
            slug: route.params.slug,
          
        })
    }






   
]

export default routesfront; 