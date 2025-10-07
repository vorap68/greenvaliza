import  {createRouter, createWebHistory} from 'vue-router';
 import routes from './routes.js';
import axios, { formToJSON } from 'axios';
import { getCurrentUser } from '../../auth.js';

const router = createRouter({
    history: createWebHistory(),
    routes

 });
 

 router.beforeEach(async (to, from, next) => {
  const  user = await getCurrentUser();
  console.log('Current user_from_router:', user); 

  

  // Если маршрут требует авторизацию, а пользователь не залогинен
  if (to.meta.requiresAuth && !user) {
    return next('/login');
  }

  // Если маршрут только для гостей, а пользователь уже залогинен
  if (to.meta.requiresAuth  && user &&to.path!=='/all-users') {
    return next('/all-users');
  }

  // Всё в порядке — переходим
  next();
});


 export default router;