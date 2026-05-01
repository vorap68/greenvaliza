const routesfront = [
    {
        /**
         * Главная страница фронта 
         */
        path: '/', component: () => import('../Main.vue'),
        name: 'Main',
    },

    /**
     * Маршруты для разделов "Путешествия", "Советы", "Гиды" и "Моя книга"
     */
    {
        path: '/travel',
        name: 'Travel',
       component: () => import('../travel/Menu.vue'),
    },
    {
        path: '/advice',
        name: 'Advice',
       component: () => import('../advice/Menu.vue'),
    },
    {
        path: '/guide',
        name: 'Guide',
       component: () => import('../guide/Menu.vue'),
    },
    {
        path: '/mybook',
        name: 'Mybook',
       component: () => import('../mybook/Menu.vue'),
    },
   

    /**
     * Маршруты для отображения отдельных постов в разделах "Путешествия", "Советы", "Гиды" и "Моя книга"
     */

     /**
    * @type {string} slug используется для идентификации конкретного поста, который нужно отобразить.
    * Он передается в компонент PostView.vue через props,
    * @type {string} type используется для определения типа поста.Здесь 2 варианта: 
    * 1- "tble"  для отображения постов в виде таблицы,
    * 2- "post"   single-пост + final-пост, 
     */
    {
        /**
         * Маршрут для отображения single-поста в разделе "Путешествия"
         */
        path: '/travel/:slug',
        name: 'travel-postmenu',
        component: () => import('../travel/PostView.vue'),
        props: route => ({
          
            slug: route.params.slug,

            type: route.query.type
        })
    },

    {
          /**
         * Маршрут для отображения final-поста в разделе "Путешествия"
         */
        path: '/travel/final/:slug',
        name: 'travel-final-post',
        component: () => import('../travel/endPosts/travel-post.vue'),
        props: route => ({
            slug: route.params.slug,
            type: route.query.type
        })
    },

    {
           /**
         * Маршрут для отображения table-поста в разделе "Путешествия"
         */
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