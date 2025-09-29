
// import './bootstrap';

import '../sass/app.scss';
import {createApp} from 'vue';
import App from './src/App.vue'; 

import axios  from 'axios';

import $ from 'jquery';
window.$ = $;
window.jQuery = $;

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte';


axios.defaults.withCredentials = true
axios.defaults.baseURL = 'http://localhost:8889' // или из .env

createApp(App).
mount('#app');

// Стили
// import '../css/bootstrap-grid.css';
import '../css/font-awesome.css';
import '../css/slicknav.css';
import '../css/style.css';
import '../css/theme.css';
import '../css/responsive.css';
import '../css/post.css';
import '../css/bootstrap-grid.css';
// custom.php надо переписать в css, если там только стили

// Скрипты
//import './modernizer.js';
import './classie.js';
import './slimscroll.js';
import './slicknav.js';
import './effects.js';
import './skip-link-focus-fix.js';





