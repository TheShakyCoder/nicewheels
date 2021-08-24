<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Makes</h2>
            <admin-nav></admin-nav>
        </template>
        <div class="max-w-2xl mx-auto">
            <ul>
                <li
                    v-for="(make, index) in makes"
                    :key="'make-'+index"
                    class="space-y-1"
                    :class="{ 'bg-gray-200': index % 2, 'py-0': make.depth > 0, 'py-0 pl-6': make.depth === 1, 'pl-12': make.depth === 2 }"
                >
                    <make :make="make" :makes="makes"></make>
                </li>
            </ul>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import AdminNav from '@/Components/Admin/AdminNav'
import Make from "@/Components/Admin/Make"

export default {
    name: "AdminMakesIndex",
    components: {
        AdminNav,
        AppLayout,
        Make
    },
    props: {
        make: {
            type: Object,
            default: null
        },
        makes: {
            type: Object,
            default: null
        }
    }
}
</script>

<style scoped>

</style>
