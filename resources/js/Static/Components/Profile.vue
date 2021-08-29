<template>
    <section aria-labelledby="profile-overview-title" v-if="user">
        <div class="rounded-lg bg-white overflow-hidden shadow">
            <h2 class="sr-only" id="profile-overview-title">Profile Overview</h2>
            <div class="bg-white p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:space-x-5">
                        <div class="flex-shrink-0">
                            <img class="mx-auto h-20 w-20 rounded-full" :src="user.profile_photo_url" alt="" />
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                            <p class="text-sm font-medium text-gray-600">Welcome back,</p>
                            <p class="text-xl font-bold text-gray-900 sm:text-2xl">{{ user.name }}</p>
                            <p class="text-sm font-medium text-gray-600">{{ user.role }}</p>
                        </div>
                    </div>
                    <div class="mt-5 flex justify-center sm:mt-0">
                        <a href="/user/profile" class="flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            View profile
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 bg-gray-50 grid grid-cols-1 divide-y divide-gray-200 sm:grid-cols-3 sm:divide-y-0 sm:divide-x">
                <div class="px-6 py-5 text-sm font-medium text-center">
                    <span class="text-gray-900 font-bold">{{ user.tokens }}</span> <span class="text-gray-600">Tokens</span>
                </div>
                <div class="px-6 py-5 text-sm font-medium text-center">
                    <span class="text-gray-900 font-bold">{{ bookmarks }}</span> <span class="text-gray-600">Bookmarks</span>
                </div>
                <div class="px-6 py-5 text-sm font-medium text-center">
                    <span class="text-gray-900 font-bold">{{ redemptions }}</span> <span class="text-gray-600">Redemptions</span>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Welcome',
    computed: {
        user () {
            return this.$store.state.static.user
        }
    }
}
</script>

<style scoped>

</style>
