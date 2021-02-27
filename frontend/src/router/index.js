import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from '../views/Login';
import Store from '../store/index';
import Dashboard from "../views/Dashboard";
import CreateProject from "../views/projects/CreateProject";
import ViewProject from "../views/projects/ViewProject";

Vue.use(VueRouter);

const ifNotAuthenticated = (to, from, next) => {
    if (!Store.getters['auth/isAuthenticated']) {
        next();
        return
    }

    next('/');
};

const ifAuthenticated = (to, from, next) => {
    if (Store.getters['auth/isAuthenticated']) {
        next();
        return
    }

    next('/login')
};

const isAdmin = (to, from, next) => {
    if (Store.getters['auth/isAdmin']) {
        next();
        return
    }

    next('/');
};

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: ifNotAuthenticated
    },
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard,
        beforeEnter: ifAuthenticated
    },
    {
        path: '/projects/create',
        name: 'create-project',
        component: CreateProject,
        beforeEnter: ifAuthenticated && isAdmin
    },
    {
        path: '/projects/:project',
        name: 'view-project',
        component: ViewProject,
        beforeEnter: ifAuthenticated
    },
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

export default router
