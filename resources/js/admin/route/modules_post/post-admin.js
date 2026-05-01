
const postAllAdminRoutes = [ 
  
    /**
     * вызывается в admin/SiderMenu.vue
     * Маршруты для отображения всех постов (кроме travel) в админ панели 
     * выбор по props category, который передается в компонент для фильтрации постов по категории
     */
    {   path: '/admin/posts/:category', component: () => import('../../Post/index.vue'),
        name: 'PostAdminIndex',
         props: route=> ({
          category: route.params.category, 
       })
    },

   /**
    *  вызывается в admin/Post/edit.vue
    * Маршрут для отображения страницы редактирования поста (кроме travel) в админ панели
    * выбор по props category, который передается в компонент для определения категории поста
    *  и id для загрузки данных поста
    */
    {   path: '/admin/posts/edit/:category/:id', component: () => import('../../Post/edit.vue'),
        name: 'postAdminEdit',
         props: route=> ({
          id: route.params.id, 
          category: route.params.category,
       })
       
    },
   
]

export default postAllAdminRoutes;