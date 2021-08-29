<template>

    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">

        <!--        <div class="flex-1 flex justify-between sm:hidden">-->
        <!--            <div>-->
        <!--                <inertia-link v-if="info.prev_page_url" :href="info.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">-->
        <!--                    Previous-->
        <!--                </inertia-link>-->
        <!--            </div>-->
        <!--            <div>-->
        <!--                <inertia-link v-if="info.next_page_url !== null" :href="info.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500">-->
        <!--                    Next-->
        <!--                </inertia-link>-->
        <!--            </div>-->
        <!--        </div>-->

        <div class="flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ info.from }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ info.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ info.total }}</span>
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <inertia-link :href="firstPageUrl" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">First</span>
                        <ChevronDoubleLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </inertia-link>
                    <inertia-link :href="prevPageUrl" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </inertia-link>
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                        {{ info.current_page }}
                    </span>
                    <inertia-link :href="nextPageUrl" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </inertia-link>
                    <inertia-link :href="lastPageUrl" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Last</span>
                        <ChevronDoubleRightIcon class="h-5 w-5" aria-hidden="true" />
                    </inertia-link>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import { ChevronLeftIcon, ChevronRightIcon, ChevronDoubleLeftIcon, ChevronDoubleRightIcon } from '@heroicons/vue/solid'

export default {
    name: 'Pagination',
    components: {
        ChevronLeftIcon,
        ChevronRightIcon,
        ChevronDoubleLeftIcon,
        ChevronDoubleRightIcon,
    },
    props: {
        info: {
            type: Object,
            default: null
        }
    },
    computed: {
        firstPageUrl () {
            return this.info.first_page_url || this.info.prev_page_url
        },
        prevPageUrl () {
            return this.info.prev_page_url || this.info.first_page_url
        },
        nextPageUrl () {
            return this.info.next_page_url || this.info.last_page_url
        },
        lastPageUrl () {
            return this.info.last_page_url || this.info.next_page_url
        },
    }
}
</script>

<style scoped>

</style>
