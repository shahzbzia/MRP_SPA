require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import VueAxios from 'vue-axios';
import axios from 'axios';

// Vue.component('index', require('./components/Index.vue').default);

Vue.use(VueRouter);

Vue.use(VueAxios, axios);


let app = new Vue({
    el: '#app',
    
    router: new VueRouter(routes)
});
