<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <top3 title="Recently Bookmarked" :cars="bookmarks"></top3>
                    <top3 title="Recently Redeemed" :cars="redemptions"></top3>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Top3 from '@/Components/Top3'

    export default {
        components: {
            AppLayout,
            Top3
        },
        props: {
            bookmarks: {
                type: Object,
                default: null
            },
            redemptions: {
                type: Object,
                default: null
            }
        }
    }
</script>
