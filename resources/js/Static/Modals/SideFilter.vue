<template>
    <transition duration="700">
        <div v-show="show" class="fixed inset-0 overflow-hidden z-20" role="dialog" aria-modal="true">
            <div class="absolute inset-0 overflow-hidden">

                <transition
                    enter-active-class="ease-in-out duration-500"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in-out duration-500"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="show" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                </transition>

                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">

                    <transition
                        enter-active-class="transform transition ease-in-out duration-500 sm:duration-700"
                        enter-from-class="translate-x-full"
                        enter-to-class="translate-x-0"
                        leave-active-class="transform transition ease-in-out duration-500 sm:duration-700"
                        leave-from-class="translate-x-0"
                        leave-to-class="translate-x-full"
                    >
                        <div v-show="show" class="relative w-96">

                            <transition
                                enter-active-class="ease-in-out duration-500"
                                enter-from-class="opacity-0"
                                enter-to-class="opacity-100"
                                leave-active-class="ease-in-out duration-500"
                                leave-from-class="opacity-100"
                                leave-to-class="opacity-0"
                            >
                                <div v-show="show" class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                                    <button @click="close" class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                        <span class="sr-only">Close panel</span>
                                        <!-- Heroicon name: outline/x -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </transition>

                            <!-- Slide-over panel, show/hide based on slide-over state. -->
                            <div class="h-full bg-white p-8 overflow-y-auto">
                                <div class="pb-16 space-y-6">

                                    <ul class="text-gray-500">
                                        <li v-for="make in makes" :key="'make-' + make.id" class="flex" :class="'mt-'+(2-(make.depth * 2))">
                                            <a
                                                class="w-full hover:bg-gray-100 px-1"
                                                :class="{ 'text-sm': make.depth > 0, 'bg-cyan-600 text-white': make.full_folder === folder }"
                                                :href="'/used-prices/' + make.full_folder"
                                                :title="make.full_name + ' used prices'"
                                            >{{ "-".repeat(make.depth) }}{{ make.full_name }}</a>
                                        </li>
                                    q</ul>

                                </div>
                            </div>
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "StaticSideFilter",
    props: {
        makes: {
            type: Array,
            default: [],
        },
        folder: {
            type: String,
            default: null
        }
    },
    computed: {
        show () {
            return this.$store.state.static.modals.sideFilter
        }
    },
    methods: {
        close () {
            this.$store.commit('static/toggleModal', { modal: 'sideFilter', state: false })
        }
    }
}
</script>

<style scoped>

</style>
