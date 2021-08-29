<template>
    <ul class="flex flex-col">
        <li v-for="car in cars.data" :key="car.id" class="m-4 my-6 p-2 border border-gray-200 shadow-lg rounded-lg">
            <admin-car :car="car"></admin-car>
        </li>
    </ul>
</template>

<script>
import AdminCar from './Car'

export default {
    name: "Cars",
    components: {
        AdminCar
    },
    props: {
        cars: {
            type: Object,
            default: null
        }
    }
}
</script>

<style scoped>

</style>
