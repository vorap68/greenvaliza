import  {createRouter, createWebHistory} from 'vue-router';
 import routesAddinng from './index-admin-add.js';
 import travelAdminPostRoutes from './modules_post/travelpost-admin.js';
 import guideAdminPostRoutes from './modules_post/guide-admin.js';
 import adviceAdminPostRoutes from './modules_post/advice-admin.js';
import mybookAdminPostRoutes from './modules_post/mybook-admin.js';
import postCardMenuroutes from './post-card.js';
import travelAdminTableRoutes from './modules_post/traveltable-admin.js';

const routeradmin = createRouter({
    history: createWebHistory(),
    routes: [
        ...routesAddinng,
        ...travelAdminPostRoutes,
        ...guideAdminPostRoutes,
        ...adviceAdminPostRoutes,
        ...mybookAdminPostRoutes,
        ...postCardMenuroutes,
        ...travelAdminTableRoutes
    ]
 });
 
 export default routeradmin;