import  {createRouter, createWebHistory} from 'vue-router';
 import routes from './routes.js';
import axios, { formToJSON } from 'axios';

const router = createRouter({
    history: createWebHistory(),
    routes

 });
 

 

 export default router;