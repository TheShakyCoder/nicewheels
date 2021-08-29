<template>
    <div class="p-4 bg-white rounded-lg shadow mb-4">
        <h2 class="text-2xl font-bold mb-1 text-yellow-800 pt-3">{{ title }}</h2>
        <cars :cars="cars" :preserve-state="preserveState"></cars>
        <div v-if="allUrl" class="flex justify-end">
            <a class="text-right text-cyan-800 font-bold hover:text-cyan-500" :href="allUrl">see all</a>
        </div>
    </div>
</template>

<script>
import Cars from './Cars'

export default {
    name: "Top3",
    components: {
        Cars
    },
    props: {
        title: {
            type: String,
            default: null
        },
        cars: {
            type: Object,
            default: null
        },
        preserveState: {
            type: Boolean,
            default: true
        },
        allUrl: {
            type: String,
            default: null
        }
    }
}
</script>

<style scoped>

</style>
