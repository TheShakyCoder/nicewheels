<template>
    <ul role="list" class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-3 truncate">
        <car :car="car" v-for="car in cars" :preserve-state="preserveState"></car>
    </ul>
</template>

<script>
import Car from './Car'

export default {
    components: {
        Car
    },
    props: {
        cars: {
            type: Object,
            default: null
        },
        preserveState: {
            type: Boolean,
            default: true
        }
    }
}
</script>
