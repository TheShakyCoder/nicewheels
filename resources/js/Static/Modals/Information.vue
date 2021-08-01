<template>
    <transition duration="300ms">
        <div v-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                </transition>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div v-show="open" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                            <button @click="close" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div v-if="car" class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Heroicon name: outline/exclamation -->
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Car Information
                                </h3>
                                <div class="mt-2 text-sm">

                                    <ul class="mt-1">
                                        <li class="flex flex-col sm:flex-row sm:justify-between">
                                            <div class="font-bold">ID</div>
                                            <div>{{ car.id }}</div>
                                        </li>
                                        <li class="flex flex-col sm:flex-row sm:justify-between pb-4">
                                            <div class="font-bold">Make</div>
                                            <div>{{ car.make.full_name }}</div>
                                        </li>
                                        <li v-for="aspect in car.aspects" class="text-left py-1 sm:py-0 text-sm flex flex-col sm:flex-row sm:justify-between sm:border-b sm:border-gray-200">
                                            <div class="font-bold">{{ aspect.name }}</div>
                                            <div>{{ aspect.value }}</div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>

                    </div>
                </transition>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "StaticModalInformation",
    computed: {
        open () {
            return this.$store.state.static.modals.information
        },
        car () {
            return this.$store.state.static.informationCar
        }
    },
    methods: {
        close () {
            this.$store.commit('static/toggleModal', { modal: 'information', state: false })
            this.$store.commit('static/setStaticProperty', { key: 'informationCar', value: null })
        }
    }
}
</script>

<style scoped>

</style>
