import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from "./store/index";
import axios from 'axios';
import VueAxios from "vue-axios";
import './assets/tailwind.css';
import Notifications from 'vue-notification'

Vue.use(Notifications);

Vue.use(VueAxios, axios.create({
    baseURL: 'http://localhost:8080/api',
}));

const storedItems = JSON.parse(localStorage.getItem('TM'));

if (storedItems.auth.token) {
    Vue.axios.defaults.headers.common['Authorization'] = storedItems.auth.token;
}

Vue.config.productionTip = process.env.NODE_ENV === 'production';

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');
