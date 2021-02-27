<template>
    <div>
        <h2 class=" text-center my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Create Project
        </h2>
        <div class="flex justify-center">
            <div class="form-container mx-auto relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                <div class="max-w-md">
                    <div class="">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <div class="flex flex-col">
                                <label class="leading-loose">Project Name</label>
                                <input required="required"
                                        v-model="project.name"
                                        type="text"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                        placeholder="Project Name">
                            </div>
                            <div class="flex items-center justify-between space-x-4">
                                <div class="flex flex-col">
                                    <label class="leading-loose">Start</label>
                                    <div class="relative focus-within:text-gray-600 text-gray-400">
                                        <input v-model="project.start_date"
                                               type="text"
                                               class="pr-4 pl-10 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                               placeholder="25-02-2020">
                                        <div class="absolute left-3 top-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <label class="leading-loose">End</label>
                                    <div class="relative focus-within:text-gray-600 text-gray-400">
                                        <input v-model="project.end_date"
                                               type="text"
                                               class="pr-4 pl-10 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                               placeholder="26-02-2020">
                                        <div class="absolute left-3 top-2">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <label class="leading-loose">Project Description</label>
                                <textarea v-model="project.description"
                                          class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none"
                                          rows="4"></textarea>
                            </div>
                        </div>
                        <div class="pt-4 flex justify-center space-x-4">
                            <button @click="createProject"
                                    class="bg-purple-500 flex justify-center items-center text-white px-4 py-3 rounded-md focus:outline-none">
                                <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Create
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CreateProject",
        data() {
            return {
                project: {
                    name: '',
                    start_date: '',
                    end_date: '',
                    description: ''
                },
                loading: false
            }
        },
        methods: {
            createProject: function () {
                this.loading = true;
                this.axios.post('/projects', this.project).then((response) => {
                    this.$router.push({path: '/projects/' + response.data.id});
                }).finally(() => this.loading = false);
            }
        }
    }
</script>

<style scoped>
     .form-container {
         width: fit-content;
     }
</style>
