export default {
    isAuthenticated: state => {
        return !!state.token
    },
    authStatus: state => state.status,
    isAdmin: state => state.user.role === 'admin',
    isClient: state => state.user.role === 'client'
}
