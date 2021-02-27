<template>
    <div v-if="isVisible" class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
        <div class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl" role="dialog">
            <div class="mt-4 mb-6">
                <slot name="header"></slot>

                <slot name="content"></slot>
            </div>
            <footer class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                <slot name="footer"></slot>
            </footer>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Modal",
        props: {
            isVisible: {
                required: false,
                default: true
            }
        }
    }
</script>

<style scoped>

</style>
