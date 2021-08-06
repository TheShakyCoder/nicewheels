<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Redemptions
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <cars :cars="redemptions.data"></cars>
                    <!-- LINKS -->
                    <pagination :info="redemptions"></pagination>
                </div>


            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Cars from '@/Components/Cars'
    import Pagination from '@/Components/Pagination'

    export default {
        components: {
            AppLayout,
            Cars,
            Pagination
        },
        props: {
            redemptions: {
                type: Object,
                default: null
            }
        }
    }
</script>
