<template>
    <li v-for="car in cars">
        <div class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
            <static-redeemed-amount :id="car.id"></static-redeemed-amount>
            <static-image :id="car.image ? car.image.id : 0"></static-image>
            <button type="button" class="absolute inset-0 focus:outline-none">
                <span class="sr-only">View details for {{ car.title }}</span>
            </button>
        </div>
        <p class="mt-2 block text-sm font-medium text-gray-800 truncate pointer-events-none">{{ car.title }}</p>
        <p class="block text-sm font-medium text-gray-500 truncate pointer-events-none">{{ car.subtitle }}</p>
        <div class="flex mt-3">

            <button-bookmark :id="car.id"></button-bookmark>
            <button-redeem :id="car.id" title="car.title"></button-redeem>

        </div>
    </li>
</template>

<script>
import ButtonBookmark from "../Buttons/Bookmark";
import ButtonRedeem from "../Buttons/Redeem";
import StaticImage from "./Image";
import StaticRedeemedAmount from "./RedeemedAmount";

export default {
    name: "ComponentLoadMore",
    components: {
        ButtonBookmark,
        ButtonRedeem,
        StaticImage,
        StaticRedeemedAmount
    },
    computed: {
        collection () {
            return this.$store.getters['static/filterCombined']
        },
        cars () {
            return this.$store.state.static.collections.filterCars
        }
    },
}
</script>

<style scoped>

</style>
