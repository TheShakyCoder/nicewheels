<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Substitutions</h2>
            <admin-nav></admin-nav>
        </template>


        <div class="max-w-2xl mx-auto">
            <button @click="add" class="p-2 px-3 rounded bg-green-600 text-white m-2">Add</button>
            <pagination :info="substitutions"></pagination>
            <ul>
                <li
                    v-for="(substitution, index) in substitutions.data"
                    :key="'substitution-' + substitution.id"
                    class="space-y-1 py-0 pl-6"
                     :class="{'bg-gray-200': index % 2}"
                >
                    <div class="w-full flex justify-between items-center">
                        <div>
                            <div>{{ substitution.search }}</div>
                            <div>{{ substitution.make.name }}</div>
                        </div>
                        <div>{{ substitution.new_make.full_name }}</div>
                    </div>
                </li>
            </ul>
        </div>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import AdminNav from '@/Components/Admin/AdminNav'
import Pagination from "../../../Components/Pagination"

export default {
    components: {
        AppLayout,
        AdminNav,
        Pagination
    },
    props: {
        substitutions: {
            type: Object,
            default: null
        },
        makes: {
            type: Object,
            default: null
        }
    },
    methods: {
        add () {
            this.$store.commit('admin/setSingleProperty', { key: 'substitution', value: {} })
            this.$store.commit('admin/setSingleProperty', { key: 'makes', value: this.makes })
            this.$store.commit('admin/toggleModal', { modal: 'addSubstitution', state: true })
        }
    }
}
</script>
