<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cars</h2>
            <admin-nav></admin-nav>
        </template>
        <div class="max-w-3xl mx-auto">

            <button @click="add" class="p-2 px-3 rounded bg-green-600 text-white m-2">Add</button>
            <pagination :info="aspectMakes"></pagination>

            <ul>
                <li v-for="(aspectMake, index) in aspectMakes.data" :key="'aspect-make' + index" class="flex justify-between p-2" :class="{'bg-gray-200': index % 2}">
                    <div>{{ aspectMake.aspect_make }} {{ aspectMake.aspect_model }}</div>
                    <button @click="choose(aspectMake)" class="flex-grow text-right">{{ aspectMake.make ? aspectMake.make.full_name : '--' }}</button>
                </li>
            </ul>
            <pagination :info="aspectMakes"></pagination>
        </div>

    </app-layout>
</template>

<script>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid'
import AppLayout from '@/Layouts/AppLayout'
import Pagination from "../../../Components/Pagination"
import AdminNav from '@/Components/Admin/AdminNav'

export default {
    name: 'AdminAspectMakesIndex',
    components: {
        ChevronLeftIcon,
        ChevronRightIcon,

        AppLayout,

        AdminNav,
        Pagination
    },
    props: {
        aspectMakes: {
            type: Object,
            default: null
        },
        makes: {
            type: Object,
            default: null
        }
    },
    methods: {
        choose (aspectMake) {
            console.log('choose')
            this.$store.commit('admin/setSingleProperty', { key: 'aspectMake', value: aspectMake })
            this.$store.commit('admin/setSingleProperty', { key: 'makes', value: this.makes })
            this.$store.commit('admin/toggleModal', { modal: 'aspectMake', state: true })
        },
        add () {
            this.$store.commit('admin/setSingleProperty', { key: 'aspectMake', value: {} })
            this.$store.commit('admin/setSingleProperty', { key: 'makes', value: this.makes })
            this.$store.commit('admin/toggleModal', { modal: 'addAspectMake', state: true })
        }
    }
}
</script>

<style scoped>

</style>
