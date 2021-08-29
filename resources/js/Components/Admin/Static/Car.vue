<template>
    <div class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
        <static-image :id="car.image.id"></static-image>
        <button type="button" class="absolute inset-0 focus:outline-none">
            <span class="sr-only">View details for </span>
        </button>
    </div>
    <p class="mt-2 block text-sm font-medium text-gray-800 truncate pointer-events-none">{{ title }}</p>
    <p class="block text-sm font-medium text-gray-500 truncate pointer-events-none">{{ subtitle }}</p>
</template>

<script>
import StaticImage from './Image'

export default {
    name: "AdminComponentsStaticCar",
    components: {
        StaticImage
    },
    props: {
        car: null,
        title: null,
        subtitle: null
    }
}
</script>

<style scoped>

</style>
