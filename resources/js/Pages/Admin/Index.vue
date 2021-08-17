<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin</h2>
            <admin-nav></admin-nav>
        </template>
        <div>
            <ul>
                <li>NOT ASPECTED: {{ notAspectedCount }}</li>
                <li>NOT PROCESSED: {{ notProcessedCount }}</li>
            </ul>
        
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
    }
}
</script>

<style scoped>

</style>
