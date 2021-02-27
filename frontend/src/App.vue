<template>
    <component v-bind:is="layout"></component>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: 'App',
        components: {
            authenticated: () => import('./components/layout/Authenticated'),
            guest: () => import('./components/layout/Guest'),
        },
        computed: {
            ...mapGetters('auth', [
                'isAuthenticated'
            ]),
            layout: function () {
                return this.isAuthenticated ? 'authenticated' : 'guest';
            },
        }
    };
</script>

<style lang="scss">

</style>
