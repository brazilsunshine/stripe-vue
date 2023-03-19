import './bootstrap';

import axios from 'axios';
import Vue from 'vue';
import VueRouter from 'vue-router';
import VueToastify from 'vue-toastify';


import RootContainer from './components/RootContainer';

window.axios = axios;

Vue.use(VueRouter);

Vue.use(VueToastify, {
    theme: 'light',
    errorDuration: 5000,
});


let app = new Vue({
    el: '#app',
    components: {
        RootContainer,
    }
});

