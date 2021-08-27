<template>
    <header class="pb-24 bg-gradient-to-r from-sky-800 to-cyan-600">
        <div class="max-w-3xl mx-auto px-2 lg:max-w-7xl">
            <div class="relative flex flex-wrap items-center justify-between">
                <!-- Logo -->
                <div class="py-5 flex-shrink-0">
                    <a href="/">
                        <span class="sr-only">Nicewheels Used Prices</span>
                        <div class="bg-cyan-200 p-2 rounded">
                            <img src="https://fig-de.fra1.digitaloceanspaces.com/fig/images/logo.png" alt="Nicewheels used car prices">
                        </div>
                    </a>
                </div>

                <h2 class=" hidden sm:inline text-center text-white text-2xl italic pb-2">Used Prices</h2>

                <!-- Right section on desktop -->
                <div class="ml-4 flex items-center py-5 pr-0.5">
                    <button type="button" class="flex-shrink-0 p-1 text-cyan-200 rounded-full hover:text-white hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white">
                        <span class="sr-only">View notifications</span>
                        <!-- Heroicon name: outline/bell -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <!-- Mobile menu button -->
                    <button @click="$store.commit('static/toggleModal', { modal: 'mobile' })" type="button" class="bg-transparent p-2 rounded-md inline-flex items-center justify-center text-cyan-200 hover:text-white hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                </div>

            </div>
        </div>

        <static-mobile-modal></static-mobile-modal>

        <h2 class=" sm:hidden text-center text-white text-2xl italic pb-2">Used Car Prices</h2>

    </header>
</template>

<script>
import StaticMobileModal from "./Modals/Mobile"

export default {
    name: "StaticHeader",
    components: {
        StaticMobileModal
    },
    computed: {
        mobileModal () {
            return this.$store.state.static.modals.mobile
        }
    }
}
</script>

<style scoped>

</style>
