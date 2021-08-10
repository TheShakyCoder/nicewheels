<template>
    <div class="flex justify-between items-center p-3" :class="{ 'bg-red-600 text-white': !make.live }">
        <inertia-link :href="route('admin.makes.show', make.id)" class="flex-grow">{{ "-".repeat(make.depth) }}{{ make.name }}</inertia-link>
        <inertia-link :preserve-scroll="true" method="post" as="button" :href="route('admin.makes.up', make.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">Up</inertia-link>
        <inertia-link :preserve-scroll="true" method="post" as="button" :href="route('admin.makes.down', make.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">Down</inertia-link>
    </div>
</template>

<script>
export default {
    name: "AdminMakeComponent",
    props: {
        make: {
            type: Object,
            default: null
        }
    }
}
</script>

<style scoped>

</style>
