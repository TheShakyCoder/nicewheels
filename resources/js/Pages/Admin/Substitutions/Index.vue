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
                    class="space-y-1"
                     :class="{'bg-gray-200': index % 2}"
                >
                    <div class="w-full flex justify-between items-center">
                        <div class="w-8 p-2">{{ substitution.sort }}</div>
                        <div class="w-40">
                            <div>{{ substitution.search }}</div>
                            <div>{{ substitution.make.name }}</div>
                        </div>
                        <div class="flex-grow">{{ substitution.new_make.full_name }}</div>

                        <div>
                            <inertia-link :preserve-scroll="true" :preserve-state="true" method="post" as="button" :href="route('admin.substitutions.up', substitution.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">&#x2191;</inertia-link>
                            <inertia-link :preserve-scroll="true" :preserve-state="true" method="post" as="button" :href="route('admin.substitutions.down', substitution.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">&#x2193;</inertia-link>
                        </div>

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

    created () {
        console.log('created', new Date())
    },

    mounted () {
        console.log('mounted', new Date())
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
