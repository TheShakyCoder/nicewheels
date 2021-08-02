<template>
    <button
        @click="report"
        class="m-0 p-0 rounded-full w-10 h-10 text-white border border-gray-300 bg-gray-400"
    >
        <i class="fas fa-exclamation fa-lg mt-1"></i>
    </button>
</template>

<script>
export default {
    name: "StaticButtonReport",
    methods: {
        report () {
            console.log('report')
        }
    }
}
</script>

<style scoped>

</style>
