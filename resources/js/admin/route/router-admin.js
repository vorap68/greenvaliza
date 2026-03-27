import  {createRouter, createWebHistory} from 'vue-router';
 import routesAddinng from './adding-admin.js';
 import travelAdminPostRoutes from './modules_post/travelpost-admin.js';
 import adminPostRoutes from './modules_post/post-admin.js';
import postCardMenuroutes from './post-card.js';
import travelAdminTableRoutes from './modules_post/traveltable-admin.js';
import imagesAdminRoutes from './modules_post/images-admin.js';

const routeradmin = createRouter({
    history: createWebHistory(),
    routes: [
        ...routesAddinng,
        ...travelAdminPostRoutes,
        ...adminPostRoutes,
        ...postCardMenuroutes,
        ...travelAdminTableRoutes,
        ...imagesAdminRoutes,
    ]
 });
 
 export default routeradmin;