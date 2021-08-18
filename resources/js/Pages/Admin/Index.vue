<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin</h2>
            <admin-nav></admin-nav>
        </template>
        <div class="text-lg">
            <ul>
                <li>NOT ASPECTED: {{ notAspectedCount }}</li>
                <li>NOT PROCESSED: {{ notProcessedCount }}</li>
            </ul>

            <ul class="max-w-lg">
                <li v-for="(make, index) in carsNotAssignedToModels" :key="'make-' + index" class="flex justify-between space-y-2">
                    <inertia-link :href="route('admin.makes.show', make.id)">{{ make.name }}</inertia-link>
                    <div>{{ make.quantity }}</div>
                </li>
            </ul>
        
            {{  carsNotAssignedToModels }}
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import AdminNav from '@/Components/Admin/AdminNav'

export default {
    name: 'Admin',
    components: {
        AppLayout,
        AdminNav
    },
    props: {
        notAspectedCount: {
            type: Number,
            default: null
        },
        notProcessedCount: {
            type: Number,
            default: null
        },
        carsNotAssignedToModels: {
            type: Number,
            default: null
        }
    }
}
</script>

<style scoped>

</style>
