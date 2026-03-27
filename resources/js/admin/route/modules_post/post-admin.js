
const adminPostRoutes = [ 
  
    {   path: '/admin/posts/:category', component: () => import('../../Post/index.vue'),
        name: 'PostAdminIndex',
         props: route=> ({
          category: route.params.category, 
       })
    },

   
    {   path: '/admin/posts/edit/:category/:id', component: () => import('../../Post/edit.vue'),
        name: 'postAdminEdit',
         props: route=> ({
          id: route.params.id, 
          category: route.params.category,
       })
       
    },
  
  
]

export default adminPostRoutes;