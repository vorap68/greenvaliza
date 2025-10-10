import { createApp } from 'vue'
import App from './App.vue'
import router from './src/route/router.js'; 

const app = createApp(App);
app.use(router);
app.mount('#app');

 import '../sass/app.scss';

 import axios  from 'axios';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte';


axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8889' // или из .env

// Стили
import '../css/bootstrap-grid.css';
import '../css/font-awesome.css';
import '../css/slicknav.css';
import '../css/style.css';
import '../css/theme.css';
import '../css/responsive.css';
import '../css/post.css';



// Скрипты

 import './classie.js';
 import './skip-link-focus-fix.js';
 






