<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" static class="fixed z-10 inset-0 overflow-y-auto" @close="open = false" :open="open">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div class="absolute top-0 right-0 pt-4 pr-4">
                            <button type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="close">
                                <span class="sr-only">Close</span>
                                <XIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>
                        <div class="flex flex-col items-start">

                            <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    Edit Car
                                </DialogTitle>
                                <div class="flex mt-2">
                                    <div>

                                        <div>
                                            <label for="make_id" class="block text-sm font-medium text-gray-700">Make</label>
                                            <select v-model="form.make_id" id="make_id" name="make_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="">--  none selected --</option>
                                                <option v-for="make in makes" :value="make.id">{{ "-".repeat(make.depth) }}{{ make.name }}</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                            <div class="mt-1">
                                                <input v-model="form.title" type="text" name="title" id="title" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="eg. Alfa Romeo 159">
                                            </div>
                                        </div>

                                        <div>
                                            <label for="subtitle" class="block text-sm font-medium text-gray-700">SubTitle</label>
                                            <div class="mt-1">
                                                <input v-model="form.subtitle" type="text" name="subtitle" id="subtitle" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="eg. GTi">
                                            </div>
                                        </div>

                                        <div>
                                            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                                            <div class="mt-1">
                                                <input v-model="form.year" type="text" name="year" id="year" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="eg. 2010">
                                            </div>
                                        </div>

                                        <div>
                                            <label for="mileage" class="block text-sm font-medium text-gray-700">Mileage</label>
                                            <div class="mt-1">
                                                <input v-model="form.mileage" type="text" name="mileage" id="mileage" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="eg. 100234">
                                            </div>
                                        </div>


                                        <SwitchGroup as="div" class="flex items-center mt-2">
                                            <Switch v-model="form.used_price" :class="[form.used_price ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
                                                <span aria-hidden="true" :class="[form.used_price ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']" />
                                            </Switch>
                                            <SwitchLabel as="span" class="ml-3">
                                                <span class="text-sm font-medium text-gray-900">Used Price</span>
                                            </SwitchLabel>
                                        </SwitchGroup>



                                    </div>
                                    <div>
                                        <img src="" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 flex flex-row">
                            <div class="flex-grow">
                                <button type="button" class="w-full inline-flex flex flex-grow justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="delete">
                                    Delete
                                </button>
                            </div>
                            <div>
                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="close">
                                    Cancel
                                </button>
                                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="save">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import { Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationIcon, XIcon } from '@heroicons/vue/outline'
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

export default {
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
        XIcon,

        Switch,
        SwitchGroup,
        SwitchLabel,
    },
    data () {
        return {
            form: {
                make_id: null
            }
        }
    },
    computed: {
        open () {
            return this.$store.state.admin.modals.carEdit
        },
        car () {
            return this.$store.state.admin.car
        },
        makes () {
            return this.$store.state.admin.makes
        }
    },
    watch: {
        car (n, o) {
            this.form = n
            this.form.used_price = n.used_price === 1
        }
    },
    methods: {
        close () {
            this.$store.commit('admin/setSingleProperty', { key: 'carId', value: null })
            this.$store.commit('admin/toggleModal', { modal: 'carEdit', state: false })
        },
        save () {
            this.$inertia.patch('/admin/cars/' + this.car.id, this.form, {
                preserveScroll: true
            })
            this.$store.commit('admin/toggleModal', { modal: 'carEdit', state: false })
        },
        delete () {
            this.$inertia.delete('/admin/cars/' + this.car.id, {
                onBefore: () => confirm('Are you sure you want to delete this car?'),
                preserveScroll: true
            })
            this.$store.commit('admin/toggleModal', { modal: 'carEdit', state: false })
        }
    }
}
</script>
