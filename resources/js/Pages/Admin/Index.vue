<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin</h2>
            <admin-nav></admin-nav>
        </template>
        <div>INDEX</div>
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
}
</script>

<style scoped>

</style>
