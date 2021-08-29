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
                    <div v-show="open" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full sm:p-6">
                        <div class="absolute top-0 right-0 pt-4 pr-4">
                            <button @click="close" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div v-if="car" class="h-80 overflow-y-scroll">


                            <static-carousel-image v-for="image in car.images" :id="image.id"></static-carousel-image>





                        </div>

                    </div>
                </transition>
            </div>
        </div>
    </transition>
</template>

<script>
import StaticCarouselImage from '../Components/CarouselImage'

export default {
    name: "StaticModalInformation",
    components: {
        StaticCarouselImage
    },
    data () {
        return {
            images: {}
        }
    },
    computed: {
        open () {
            return this.$store.state.static.modals.carousel
        },
        car () {
            return this.$store.state.static.car
        }
    },

    methods: {
        close () {
            setTimeout(() => this.$store.commit('static/setStaticProperty', { key: 'car', value: null }), 500)
            this.$store.commit('static/toggleModal', { modal: 'carousel', state: false })
        }
    }
}
</script>

<style scoped>

</style>
