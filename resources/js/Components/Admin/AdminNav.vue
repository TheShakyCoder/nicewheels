<template>
    <ul class="flex mt-2">
        <li><inertia-link :href="route('admin.index')" class="py-1 mr-4" :class="{ 'border-b border-gray-500': route().current('admin.index') }">Index</inertia-link></li>
        <li><inertia-link :href="route('admin.cars.index')" class="py-1 mr-4" :class="{ 'border-b border-gray-500': route().current('admin.cars.index') }">Cars</inertia-link></li>
        <li><inertia-link :href="route('admin.makes.index')" class="py-1 mr-4" :class="{ '': true }">Makes</inertia-link></li>
    </ul>
</template>

<script>

</script>
