<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ make.full_name }}</h2>
            <admin-nav></admin-nav>
        </template>
        <div class="max-w-7xl mx-auto flex">
            <div class="flex-grow">
                <div class="p-2 m-2 bg-white rounded-xl border border-gray-300 shadow">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1">
                            <input v-model="form.name" type="text" name="name" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="eg. Alfa Romeo">
                        </div>
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                        <div class="mt-1">
                            <input v-model="form.slug" type="text" name="slug" id="slug" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="eg. Alfa Romeo">
                        </div>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Belongs To</label>
                        <select v-model="form.parent_id" id="parent-id" name="parent_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="">-- none --</option>
                            <option v-for="m in makes" :value="m.id">{{ "-".repeat(m.depth) }} {{ m.name }}</option>
                        </select>
                    </div>

                    <SwitchGroup as="div" class="flex items-center my-2">
                        <Switch v-model="form.live" :class="[form.live ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                            <span aria-hidden="true" :class="[form.live ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']" />
                        </Switch>
                        <SwitchLabel as="span" class="ml-3">
                            <span class="text-sm font-medium text-gray-900">Live</span>
                        </SwitchLabel>
                    </SwitchGroup>

                    <button @click="save" type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>

                <div class="p-2 m-2 bg-white rounded-xl border border-gray-300 shadow">
                    <h3 class="text-xl font-bold">Cars</h3>
                    <ul>
                        <li v-for="car in cars" class="space-y-1 p-1 my-1" :class="{ 'bg-red-600 text-white': !car.used_price }">
                            <div class="flex justify-between items-center">
                                <div class="flex-grow">
                                    <div>{{ car.title }}</div>
                                    <div class="text-sm">{{ car.subtitle }}</div>
                                </div>
                                <div class="mr-2 p-1 flex flex-col items-center">
                                    <div>{{ car.year }}</div>
                                    <div class="text-sm">{{ car.mileage }}</div>
                                </div>
                                <div>{{ car.ended_at }}</div>
                                <button @click="editCar(car)" class="p-2 px-3">edit</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-80">
                <div class="p-2 m-2 bg-white rounded-xl border border-gray-300 shadow">
                    <h3 class="text-xl font-bold">Ancestors</h3>
                    <ul>
                        <li v-for="m in ancestors">
                            <inertia-link :title="m.id" :href="route('admin.makes.show', m.id)">{{ m.name }}</inertia-link>
                        </li>
                    </ul>
                </div>
                <div class="p-2 m-2 bg-white rounded-xl border border-gray-300 shadow">
                    <div class="flex justify-between">
                        <h3 class="text-xl font-bold">Children</h3>
                        <button @click="addMake">Add</button>
                    </div>
                    <ul>
                        <li v-for="child in children" class="flex justify-between">
                            <inertia-link :title="child.id" class="flex-grow" :href="route('admin.makes.show', child.id)">{{ child.name }} [{{ child.ebay_items_count }}]</inertia-link>
                            <inertia-link :preserve-scroll="true" :preserve-state="true" method="post" as="button" :href="route('admin.makes.up', child.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">Up</inertia-link>
                            <inertia-link :preserve-scroll="true" :preserve-state="true" method="post" as="button" :href="route('admin.makes.down', child.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">Down</inertia-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import AdminNav from '@/Components/Admin/AdminNav'
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'
import Button from "../../../Jetstream/Button";

export default {
    name: "AdminMakesShow",
    components: {
        Button,
        AdminNav,
        AppLayout,

        Switch,
        SwitchGroup,
        SwitchLabel
    },
    props: {
        make: {
            type: Object,
            default: null
        },
        children: {
            type: Object,
            default: null
        },
        ancestors: {
            type: Object,
            default: null
        },
        makes: {
            type: Object,
            default: null
        },
        cars: {
            type: Object,
            default: null
        }
    },
    data () {
        return {
            form: {
                name: null,
                parent_id: null
            }
        }
    },
    mounted () {
        this.form.id = this.make.id
        this.form.name = this.make.name
        this.form.slug = this.make.slug
        this.form.parent_id = this.make.parent_id
        this.form.live = this.make.live === 1
    },
    methods: {
        save () {
            this.$inertia.patch('/admin/makes/' + this.make.id, this.form)
        },
        editCar(car) {
            this.$store.commit('admin/setSingleProperty', { key: 'car', value: car })
            this.$store.commit('admin/setSingleProperty', { key: 'makes', value: this.makes })
            this.$store.commit('admin/toggleModal', { modal: 'carEdit', state: true })
        },
        addMake () {
            this.$store.commit('admin/setSingleProperty', { key: 'make', value: { name: null, slug: null, parent_id: this.make.id } })
            this.$store.commit('admin/setSingleProperty', { key: 'makes', value: this.makes })
            this.$store.commit('admin/toggleModal', { modal: 'makeAdd', state: true })
        }
    }
}
</script>

<style scoped>

</style>
