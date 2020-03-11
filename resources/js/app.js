require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import VueAxios from 'vue-axios';
import axios from 'axios';
import DatePicker from 'vue2-datepicker';

Vue.use(VueRouter);

Vue.use(VueAxios, axios);

let app = new Vue({
    el: '#app',
    
    router: new VueRouter(routes)
});
