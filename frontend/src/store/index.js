import Vue from 'vue'
import Vuex from 'vuex'
import auth from "./modules/auth/index";
import VuexPersistence from 'vuex-persist'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

const vuexLocal = new VuexPersistence({
    key: 'TM',
    storage: window.localStorage,
    modules: ['auth']
});

export default new Vuex.Store({
    modules: {
        auth,
    },
    strict: debug,
    plugins: [vuexLocal.plugin]
})
