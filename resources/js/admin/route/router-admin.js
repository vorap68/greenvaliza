/**
 *интегрирование всех роутов для админ панели
 * и експортирование их в admin.js
 */ 
import  {createRouter, createWebHistory} from 'vue-router';
import routesAddinng from './adding-admin.js';
import travelPostAdminRoutes from './modules_post/travelpost-admin.js';
import postAllAdminRoutes from './modules_post/post-admin.js';
import postCardMenuroutes from './post-card.js';
import travelTableAdminRoutes from './modules_post/traveltable-admin.js';
import imagesAdminRoutes from './modules_post/images-admin.js';

const routeradmin = createRouter({
    history: createWebHistory(),
    routes: [
        ...routesAddinng,
        ...travelPostAdminRoutes,
        ...postAllAdminRoutes,
        ...postCardMenuroutes,
        ...travelTableAdminRoutes,
        ...imagesAdminRoutes,
    ]
 });
 
 export default routeradmin;