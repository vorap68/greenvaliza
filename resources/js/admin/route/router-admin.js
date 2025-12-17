import  {createRouter, createWebHistory} from 'vue-router';
 import routes from './index-admin.js';
 import travelAdminPostRoutes from './modules_post/travel-admin.js';
 import guideAdminPostRoutes from './modules_post/guide-admin.js';
 import adviceAdminPostRoutes from './modules_post/advice-admin.js';
import mybookAdminPostRoutes from './modules_post/mybook-admin.js';
import postCardMenuroutes from './post-card.js';

const routeradmin = createRouter({
    history: createWebHistory(),
    routes: [
        ...routes,
        ...travelAdminPostRoutes,
        ...guideAdminPostRoutes,
        ...adviceAdminPostRoutes,
        ...mybookAdminPostRoutes,
        ...postCardMenuroutes
    ]
 });
 
 export default routeradmin;