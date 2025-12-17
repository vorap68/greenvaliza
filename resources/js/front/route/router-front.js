import  {createRouter, createWebHistory} from 'vue-router';
 import routes from './index-front.js';
import axios, { formToJSON } from 'axios';
import CategoryView from '../CategoryView.vue';

const routerfront = createRouter({
    history: createWebHistory(),
    routes

 });
 
 export default routerfront;