<template>
    <div class="w-full flex flex-wrap">
        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex flex-col">

            <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">
                <img :src="require('@/assets/images/logo.png')">
            </div>

            <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                <p class="text-center text-3xl">Welcome.</p>
                <form class="flex flex-col pt-3 md:pt-8" onsubmit="event.preventDefault();">
                    <div class="flex flex-col pt-4">
                        <label for="email" class="text-lg">Email</label>
                        <input v-model="user.email" type="email" id="email" placeholder="your@email.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="flex flex-col pt-4">
                        <label for="password" class="text-lg">Password</label>
                        <input v-model="user.password" type="password" id="password" placeholder="Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <input @click="authRequest(user)" type="submit" value="Log In" class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8 cursor-pointer">
                </form>
            </div>
        </div>

        <!-- Image Section -->
        <div class="w-1/2 shadow-2xl">
            <img class="object-cover w-full h-screen hidden md:block" src="https://source.unsplash.com/IXUM4cJynP0">
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: "Login",
        data() {
            return {
                user: {
                    email: 'admin@almighty.com',
                    password: 'test1234'
                }
            }
        },
        computed: {
            ...mapState('auth', [
                'status'
            ])
        },
        methods: {
            authRequest: function (user) {
                this.$store.dispatch('auth/authRequest', user).then(() => {
                    this.$router.push('/');
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .middle {
        height: 90vh;
        align-items: center;
        justify-content: center;
    }
</style>
