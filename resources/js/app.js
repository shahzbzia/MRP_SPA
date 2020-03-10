require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import VueAxios from 'vue-axios';
import axios from 'axios';
import DatePicker from 'vue2-datepicker';

Vue.component('create-booking', require('./components/CreateBooking.vue').default);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.use(VueRouter);

Vue.use(VueAxios, axios);




let app = new Vue({
    el: '#app',

    components: { DatePicker },
    
    router: new VueRouter(routes)
});
