<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Car Edit</h2>
            <admin-nav></admin-nav>
        </template>

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <div class="w-full pr-0 sm:pr-4">
                <!-- LEFT -->
                <form v-if="form" class="space-y-8 divide-y divide-gray-200">
                    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
                        <div>

                            <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">

                                <div class="flex flex-col">
                                    <label for="make_id" class="text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Make</label>
                                    <select v-model="form.make_id" id="make_id" name="make_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-lg border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">- no make -</option>
                                        <!--                                <option value="-1">- new make -</option>-->
                                        <option :value="make.id" v-for="make in makes" :selected="parseInt(make.id) === parseInt(form.make_id)">{{ '>'.repeat(make.depth) + ' ' }}{{ make.name }}</option>
                                    </select>
                                </div>

                                <div class="flex flex-col">
                                    <label for="title" class="text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Title</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="max-w-lg flex rounded-md shadow-sm">
                                            <input v-model="form.title" type="text" name="title" id="title" autocomplete="title" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col">
                                    <label for="subtitle" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Subtitle</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="max-w-lg flex rounded-md shadow-sm">
                                            <input v-model="form.subtitle" type="text" name="subtitle" id="subtitle" autocomplete="subtitle" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col">
                                    <label for="mileage" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Mileage</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="max-w-lg flex rounded-md shadow-sm">
                                            <input v-model="form.mileage" type="text" name="mileage" id="mileage" autocomplete="mileage" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col">
                                    <label for="year" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Year</label>
                                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                                        <div class="max-w-lg flex rounded-md shadow-sm">
                                            <input v-model="form.year" type="text" name="year" id="year" autocomplete="year" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300" />
                                        </div>
                                    </div>
                                </div>

                                <SwitchGroup as="div" class="flex items-center">
                                    <Switch v-model="form.used_price" :class="[Boolean(Number(form.used_price)) ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                                        <span aria-hidden="true" :class="[form.used_price ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']" />
                                    </Switch>
                                    <SwitchLabel as="span" class="ml-3">
                                        <span class="text-sm font-medium text-gray-900">Used Price </span>
                                    </SwitchLabel>
                                </SwitchGroup>

                            </div>
                        </div>
                    </div>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button @click="update" type="button" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- IMAGES -->
            <div>
                <ul class="w-48 max-w-48 mb-4">
                    <car :car="car" :title="form.title" :subtitle="form.subtitle"></car>
                </ul>
                <ul class="w-80 min-w-80">
                    <car :car="car" :title="form.title" :subtitle="form.subtitle"></car>
                </ul>
            </div>

        </div>

        <div class="my-8 p-4 shadow-lg bg-red-100">
            <h3 class="text-xl font-bold">Aspects</h3>
            <ul class="flex flex-wrap">
                <li class="flex flex-col w-full md:w-1/2" v-for="aspect in car.aspects">
                    <div class="font-bold">{{ aspect.name }}</div>
                    <div class="">{{ aspect.value }}</div>
                </li>
            </ul>
        </div>

        <div class="mt-2 p-2 border border-gray-400 shadow-lg">
            <div class="mt-2">
                <div class="text-lg font-bold">ebay category</div>
                <div>{{ car.ebay_category.name }}</div>
            </div>
            <div class="mt-2">
                <div class="text-lg font-bold">primary category</div>
                <div>{{ car.primary_category.name }}</div>
            </div>
            <div class="mt-2">
                <div class="text-lg font-bold">ebay url</div>
                <a :href="car.ebay_url" target="_BLANK">{{ car.ebay_url }}</a>
            </div>
            <div class="mt-2">
                <div class="text-lg font-bold">gallery url</div>
                <a :href="car.gallery_url">{{ car.gallery_url }}</a>
            </div>
            <div class="mt-2">
                <div class="text-lg font-bold">bids</div>
                <div>{{ car.bids }}</div>
            </div>
            <div class="mt-2">
                <div class="text-lg font-bold">Ended At</div>
                <div>{{ car.ended_at }}</div>
            </div>
            <div class="mt-2">
                <div class="text-lg font-bold">Final Amount</div>
                <div>{{ car.final_amount }}</div>
            </div>
        </div>






<!--        <div class="mt-4 flex">-->
<!--            <div class="w-full sm:w-3/4">-->

<!--                <div class="my-8 p-4 shadow-lg bg-blue-100">-->
<!--                    <h3 class="text-xl font-bold">Filters</h3>-->
<!--                    <ul class="flex flex-wrap">-->
<!--                        <li class="flex flex-col w-full sm:w-1/2" v-for="filter in car.filters">-->
<!--                            <div class="font-bold">{{ filter.category.name }}</div>-->
<!--                            <div class="">{{ filter.name }}</div>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->

<!--            </div>-->

<!--        </div>-->

<!--        <modal-add-make :show="modals.addMake" :makes="makes" :parent="ebayItem.make_id" :name="aspectModel" @close="modals.addMake = false"></modal-add-make>-->

    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import AdminNav from '@/Components/Admin/AdminNav'
import Car from "@/Components/Admin/Static/Car"
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

export default {
    name: 'CarsEdit',
    components: {
        Switch, SwitchGroup, SwitchLabel,

        AppLayout,
        AdminNav,
        Car,
    },
    props: {
        car: {
            type: Object,
            default: null
        },
        makes: {
            type: Object,
            default: {}
        }
    },
    data () {
        return {
            form: {
                make_id: null,
                title: null,
                subtitle: null,
                mileage: null,
                year: null,
                used_price: null,
                _method: 'PATCH',
                _token: this.$page.props.csrf_token
            },
            modals: {
                addMake: false
            },
            updateable: false
        }
    },
    computed: {
        aspectModel () {
            return this.car.aspects.filter(a => a.name === 'Model').length > 0 ? this.car.aspects.filter(a => a.name === 'Model')[0].value : null
        }
    },
    mounted () {
        console.log('this.car')
        console.log(this.car)
        this.setForm()
    },
    methods: {
        setForm () {
            this.form.make_id = this.car.make_id
            this.form.title = this.car.title
            this.form.subtitle = this.car.subtitle
            this.form.mileage = this.car.mileage
            this.form.year = this.car.year
            this.form.used_price = this.car.used_price
        },
        update () {
            this.$inertia.post('/admin/cars/' + this.car.id, this.form)
        }
    }
}
</script>

<style scoped>

</style>
