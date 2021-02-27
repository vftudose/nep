export default {
    authRequest: function ({commit}, user) {
        return new Promise((resolve, reject) => {
            commit('SET_STATUS', 'loading');
            this._vm.axios.post('/authenticate', user).then(resp => {
                this._vm.axios.defaults.headers.common['Authorization'] = resp.data.token;
                commit('SET_TOKEN', resp.data.token);
                commit('SET_STATUS', 'success');
                commit('SET_USER', resp.data.user);
                resolve(resp);
            }).catch(err => {
                commit('SET_STATUS', 'error');
                reject(err)
            });
        });
    },
    authLogout: function ({commit}) {
        return new Promise(resolve => {
            commit('SET_TOKEN', "");
            commit('SET_STATUS', "");
            commit('SET_USER', {});
            delete this._vm.axios.defaults.headers.common['Authorization'];
            resolve();
        });
    }
}
