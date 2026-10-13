import  {createRouter, createWebHistory} from 'vue-router';
 import routesFront from './index-front.js';
 import routesAuthFront from './router-auth-comment.js';

const routerfront = createRouter({
    history: createWebHistory(),
      routes: [
        ...routesFront,
        ...routesAuthFront,
      ]

 });
 
 export default routerfront; 