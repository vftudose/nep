<template>
    <div>
        <notifications group="alerts" position="bottom right" />
        <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
            <aside class="z-20 shadow-lg w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
                <div class="py-4 text-gray-500 dark:text-gray-400">
                    <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                        TM
                    </a>
                    <ul class="mt-6">
                        <div class="px-6 my-6" v-if="isAdmin">
                            <button @click="navigateTo('create-project')" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Create Project
                                <span class="ml-2" aria-hidden="true">+</span>
                            </button>
                        </div>
<!--                        <li class="relative px-6 py-3">-->
<!--                              <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"-->
<!--                                    aria-hidden="true">-->
<!--                              </span>-->
<!--                            <router-link to="/" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">-->
<!--                                <svg class="w-5 h-5"-->
<!--                                    aria-hidden="true"-->
<!--                                    fill="none"-->
<!--                                    stroke-linecap="round"-->
<!--                                    stroke-linejoin="round"-->
<!--                                    stroke-width="2"-->
<!--                                    viewBox="0 0 24 24"-->
<!--                                    stroke="currentColor">-->

<!--                                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>-->
<!--                                </svg>-->
<!--                                <span class="ml-4">Dashboard</span>-->
<!--                            </router-link>-->
<!--                        </li>-->
                        <div class="px-6 my-6">
                            <select @change="onProjectChanged" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600">
                                <option :value="project.id" v-bind:key="project.id" v-for="project in projects"
                                        class="border-gray-300 rounded-md text-gray-600">{{project.name}}
                                </option>
                            </select>
                        </div>
                    </ul>
                </div>
            </aside>
            <div class="flex flex-col flex-1 w-full">
                <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
                    <div class="flex items-center justify-end h-full px-6 text-purple-600 dark:text-purple-300">
                        <ul class="flex items-center flex-shrink-0 space-x-6">
                            <!-- Profile menu -->
                            <li class="relative">
                                <button
                                        @click="isProfileMenuOpen = !isProfileMenuOpen"
                                        class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                                        aria-label="Account"
                                        aria-haspopup="true"
                                >
                                    <img class="object-cover w-8 h-8 rounded-full"
                                         src="https://images.unsplash.com/photo-1502378735452-bc7d86632805?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&s=aa3a807e1bbdfd4364d1f449eaa96d82"
                                         alt=""
                                         aria-hidden="true"
                                    />
                                </button>
                                <template v-if="isProfileMenuOpen">
                                    <ul class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                                        aria-label="submenu"
                                    >
                                        <li class="flex">
                                            <a @click.prevent="authLogout"
                                               class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                               href="#"
                                            >
                                                <svg
                                                        class="w-4 h-4 mr-3"
                                                        aria-hidden="true"
                                                        fill="none"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        viewBox="0 0 24 24"
                                                        stroke="currentColor"
                                                >
                                                    <path
                                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                                                    ></path>
                                                </svg>
                                                <span>Log out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </template>
                            </li>
                        </ul>
                    </div>
                </header>

                <main class="h-full">
                    <div id="main-container">
                        <router-view :key="$route.fullPath"></router-view>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex';

    export default {
        name: "Authenticated",
        computed: {
            ...mapState('auth', [
                'user'
            ]),
            ...mapGetters('auth', [
                'isAdmin'
            ])
        },
        data() {
            return {
                isProfileMenuOpen: false,
                projects: [],
                selectedProject: null
            };
        },
        created() {
          this.getAllProjects().then(() => {
              if (this.projects.length > 0) {
                  this.selectedProject = this.projects[0];
              }
          });
        },
        methods: {
            authLogout: function () {
                this.$store.dispatch('auth/authLogout').then(() => {
                    this.$router.push('/login');
                })
            },
            navigateTo: function (to) {
                this.$router.push({name: to});
            },
            getAllProjects: function () {
                return this.axios.get('/projects').then((response) => {
                    this.projects = response.data;
                });
            },
            onProjectChanged: function (event) {
                this.selectedProject = this.projects.find(project => project.id == event.target.value);
            }
        },
        watch:{
            selectedProject: function () {
                this.$router.replace({name: 'view-project', params: {project: this.selectedProject.id}});
            }
        }
    }
</script>

<style scoped>
    #main-container {
        height: 100%;
        width: 100%;
        padding: 1.5rem;
    }
</style>
