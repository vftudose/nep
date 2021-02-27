<template>
    <div id="project-page">
        <h2 class="title text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{project.name}}
        </h2>
        <div class="project-container flex flex-row flex-wrap place-content-between h-75">
            <div class="tab-wrapper min-h-full w-1/3">
                <div class="tab rounded bg-purple-500 p-2 min-h-full w-full">
                    <div class="flex justify-between py-1">
                        <h3 class="text-md font-bold text-white">TO DO</h3>
                    </div>
                    <div class="task-container text-sm mt-2 h-full">
                        <draggable v-model="tasks.todo" :animation="200" ghost-class="ghost-card" group="tasks"
                                   :move="syncLists">
                            <div v-bind:key="todoTask.id" v-for="todoTask in tasks.todo"
                                 class="task-card bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter">
                                <div class="flex justify-between items-center pb-1">
                                    <div class="w-2/3">
                                        {{todoTask.name}}
                                    </div>
                                    <div class="w-1/3 flex justify-end">
                                        <img src="https://i.imgur.com/OZaT7jl.png" class="rounded-full"/>
                                    </div>
                                </div>
                                <hr v-if="todoTask.description.length > 0">
                                <div :class="todoTask.description.length > 0 ? 'pt-1' : ''">
                                    {{todoTask.description}}
                                </div>
                            </div>
                        </draggable>

                        <p v-if="isAdmin" class="mt-3 text-white cursor-pointer" @click="isCreateTaskVisible = true">Add
                            a task...</p>
                    </div>
                </div>
            </div>
            <div class="tab-wrapper min-h-full w-1/3">
                <div class="tab rounded bg-purple-500 p-2 min-h-full w-full">
                    <div class="flex justify-between py-1">
                        <h3 class="text-md font-bold text-white">IN PROGRESS</h3>
                    </div>
                    <div class="task-container text-sm mt-2 h-full">
                        <draggable v-model="tasks.inProgress" :animation="200" ghost-class="ghost-card" group="tasks"
                                   :move="syncLists">
                            <div v-bind:key="inProgressTask.id" v-for="inProgressTask in tasks.inProgress"
                                 class="task-card bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter">
                                <div class="flex justify-between items-center pb-1">
                                    <div class="w-2/3">
                                        {{inProgressTask.name}}
                                    </div>
                                    <div class="w-1/3 flex justify-end">
                                        <img src="https://i.imgur.com/OZaT7jl.png" class="rounded-full"/>
                                    </div>
                                </div>
                                <hr v-if="inProgressTask.description.length > 0">
                                <div :class="inProgressTask.description.length > 0 ? 'pt-1' : ''">
                                    {{inProgressTask.description}}
                                </div>
                            </div>
                        </draggable>
                    </div>
                </div>
            </div>
            <div class="tab-wrapper min-h-full w-1/3">
                <div class="tab rounded bg-purple-500 p-2 min-h-full w-full">
                    <div class="flex justify-between py-1">
                        <h3 class="text-md font-bold text-white">DONE</h3>
                    </div>
                    <div class="task-container text-sm mt-2 h-full">
                        <draggable v-model="tasks.done" :animation="200" ghost-class="ghost-card" group="tasks"
                                   :move="syncLists">
                            <div v-bind:key="doneTask.id" v-for="doneTask in tasks.done"
                                 class="task-card bg-white p-2 rounded mt-1 border-b border-grey cursor-pointer hover:bg-grey-lighter">
                                <div class="flex justify-between items-center pb-1">
                                    <div class="w-2/3">
                                        {{doneTask.name}}
                                    </div>
                                    <div class="w-1/3 flex justify-end">
                                        <img src="https://i.imgur.com/OZaT7jl.png" class="rounded-full"/>
                                    </div>
                                </div>
                                <hr v-if="doneTask.description.length > 0">
                                <div :class="doneTask.description.length > 0 ? 'pt-1' : ''">
                                    {{doneTask.description}}
                                </div>
                            </div>
                        </draggable>
                    </div>
                </div>
            </div>
        </div>
        <modal :is-visible="isCreateTaskVisible">
            <template slot="header">
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    Create a task
                </p>
            </template>
            <template slot="content">
                <div>
                    <div class="">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <div class="flex flex-col">
                                <label class="leading-loose">Task Name</label>
                                <input v-model="task.name"
                                       required="required"
                                       ref="task-name"
                                       type="text"
                                       class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                                       placeholder="Task Name">
                            </div>
                            <div class="flex flex-col">
                                <label class="leading-loose">Task Description</label>
                                <textarea
                                        v-model="task.description"
                                        class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none"
                                        rows="4"></textarea>
                            </div>
                            <div class="flex flex-col">
                                <label class="leading-loose">Assign to</label>
                                <select v-model="task.assigned_to"
                                        class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600">
                                    <option :value="''" selected class="border-gray-300 rounded-md text-gray-600">None</option>
                                    <option :value="user.id" v-bind:key="user.id" v-for="user in users"
                                            class="border-gray-300 rounded-md text-gray-600">{{user.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="leading-loose">Attachments</label>

                                <div class="max-w-md rounded-lg overflow-hidden md:max-w-xl">
                                    <div lass="w-full">
                                        <div class="relative border-dotted h-48 rounded-lg border-dashed border-2 border-purple-600 bg-gray-100 flex justify-center items-center">
                                            <div class="absolute">
                                                <div class="flex flex-col items-center"><i
                                                        class="fa fa-folder-open fa-4x text-blue-700"></i> <span
                                                        class="block text-gray-400 font-normal">Attach you files here</span>
                                                </div>
                                            </div>
                                            <input ref="task-files" @change="handleFilesUpload" type="file"
                                                   class="h-full w-full opacity-0" name="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template slot="footer">
                <button @click="isCreateTaskVisible = !isCreateTaskVisible"
                        class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                    Cancel
                </button>
                <button @click="createTask"
                        class="flex w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    <svg v-if="taskLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Create
                </button>
            </template>

        </modal>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import Modal from "../../components/Modal";
    import {mapGetters} from 'vuex';

    export default {
        name: "ViewProject",
        components: {
            Modal,
            draggable
        },
        computed: {
            ...mapGetters('auth', [
                'isAdmin'
            ])
        },
        data() {
            return {
                project: {
                    name: '',
                    description: '',
                    start_date: '',
                    end_date: '',
                    tasks: []
                },
                task: {
                    name: '',
                    description: '',
                    assigned_to: '',
                    files: [],
                },
                users: [],
                tasks: {
                    todo: [],
                    inProgress: [],
                    done: []
                },
                isCreateTaskVisible: false,
                taskLoading: false,
            }
        },
        created() {
            this.fetchProject().then(response => {
                this.project = response.data;
                this.tasks.todo = this.project.tasks.filter(task => task.status === 'to_do');
                this.tasks.inProgress = this.project.tasks.filter(task => task.status === 'in_progress');
                this.tasks.done = this.project.tasks.filter(task => task.status === 'done');
            });

            if (this.isAdmin) {
                this.fetchAllUsers().then(response => {
                    this.users = response.data;
                });
            }
        },
        methods: {
            fetchProject: function () {
                return this.axios.get('/projects/' + this.$route.params.project);
            },
            fetchAllUsers() {
                return this.axios.get('/users');
            },
            updateTaskStatus: function (task) {
                return this.axios.post('/tasks/' + task.id, {
                    _method: 'PATCH',
                    status: task.status
                });
            },
            handleFilesUpload: function () {
                this.task.files = [];

                this.$refs['task-files'].files.forEach(file => {
                    this.task.files.push(file);
                });
            },
            createTask() {
                if (this.task.name.length === 0) {
                    this.$refs['task-name'].focus();

                    this.$notify({
                        group: 'alerts',
                        text: 'The name of the task cannot be empty',
                    });

                    return;
                }

                this.taskLoading = true;

                let formData = new FormData();
                formData.append('file', this.task.files[0]);
                formData.append('name', this.task.name);
                formData.append('description', this.task.description);
                formData.append('assigned_to', this.task.assigned_to);
                formData.append('project_id', this.project.id);

                return this.axios.post('/tasks', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response => {
                    this.tasks.todo.push(response.data);
                    this.isCreateTaskVisible = false;
                    this.task = {
                        name: '',
                        description: '',
                        assigned_to: '',
                        files: [],
                    };
                })).finally(() => this.taskLoading = false);
            },
            syncLists: function () {
                //TODO FIX SMALL DELAY
                setTimeout(() => {
                    this.tasks.todo.map(task => {
                        if (task.status !== 'todo') {
                            task.status = 'to_do';
                            this.updateTaskStatus(task);
                        }
                    });

                    this.tasks.inProgress.map(task => {
                        if (task.status !== 'in_progress') {
                            task.status = 'in_progress';
                            this.updateTaskStatus(task);
                        }
                    });

                    this.tasks.done.map(task => {
                        if (task.status !== 'done') {
                            task.status = 'done';
                            this.updateTaskStatus(task);
                        }
                    })
                }, 1000);
            }
        }
    }
</script>

<style lang="scss">
    #project-page {
        height: 100%;

        .title {
            height: 5%;
            min-height: 40px;
        }

        .project-container {
            height: 95%;

            .tab-wrapper {
                padding-left: 1rem;
                padding-right: 1rem;
                min-width: 350px;
            }

            .tab-wrapper:first-child {
                padding-left: 0;
            }

            .tab-wrapper:last-child {
                padding-right: 0;
            }

            .task-card {
                cursor: default;

                div:first-child {
                    cursor: grab;
                }

                div:first-child:active {
                    cursor: grabbing;
                }
            }
        }

        .ghost-card {
            opacity: 0.5;
            background: #F7FAFC;
            border: 1px solid #4299e1;
        }
    }
</style>
