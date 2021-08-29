<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" static class="fixed z-10 inset-0 overflow-y-auto" @close="close" :open="open">
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
                        <div v-if="substitution" class="flex flex-col items-start">

                            <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                                    Add Substitution
                                </DialogTitle>
                                <div class="mt-2">
                                    <div>
                                        <div>
                                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                            <div class="mt-1">
                                                <input v-model="substitution.search" type="text" name="search" id="search" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="eg. Alfa Romeo">
                                                {{ result }} results
                                            </div>
                                        </div>

                                        <div>
                                            <label for="make-id" class="block text-sm font-medium text-gray-700">in Make</label>
                                            <select v-model="substitution.make_id" id="make-id" name="make_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="">--  none selected --</option>
                                                <option v-for="make in makes" :key="'make-' + make.id" :value="make.id">{{ "-".repeat(make.depth) }}{{ make.name }}</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="to-make-id" class="block text-sm font-medium text-gray-700">to Make</label>
                                            <select v-model="substitution.to_make_id" id="to-make-id" name="to_make_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="">--  none selected --</option>
                                                <option v-for="make in makes" :key="'to-make-' + make.id" :value="make.id">{{ "-".repeat(make.depth) }}{{ make.name }}</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 sm:mt-4 flex flex-row">
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
import {Dialog, DialogOverlay, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import { ExclamationIcon, XIcon } from '@heroicons/vue/outline'

export default {
    name: "AddSubstitution",
    components: {
        Dialog,
        DialogOverlay,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
        XIcon,
    },

    data () {
        return {
            result: 0,
            searching: false,
            delay: 500,
            timeout: null
        }
    },

    computed: {
        open () {
            return this.$store.state.admin.modals.addSubstitution
        },
        makes () {
            return this.$store.state.admin.makes
        },
        substitution: {
            get () {
                return this.$store.state.admin.substitution
            },
            set (substitution) {
                this.$store.commit('admin/setSingleProperty', { key: 'substitution', value: substitution })
            }
        }
    },

    watch: {
        substitution: {
            handler(val, oldVal) {
                if(val) {
                    if(this.searching) {
                        clearTimeout(this.timeout)
                    }
                    if(val.search === '' || this.substitution.make_id === undefined) {
                        clearTimeout(this.timeout)
                        return
                    }
                    this.timeout = setTimeout(() => {
                        this.searching = true
                        this.searchSubstitution(val.search)
                    }, this.delay)
                }
            },
            deep: true
        }
    },

    methods: {
        save () {
            this.$inertia.post('/admin/substitutions/', this.substitution, {
                preserveScroll: true
            })
            setTimeout(() => this.$store.commit('admin/setSingleProperty', { key: 'substitution', value: null }))
            this.$store.commit('admin/toggleModal', { modal: 'addSubstitution', state: false })
        },
        close () {
            setTimeout(() => this.$store.commit('admin/setSingleProperty', { key: 'substitution', value: null }), 500)
            this.$store.commit('admin/setSingleProperty', { key: 'makes', value: [] })
            this.$store.commit('admin/toggleModal', { modal: 'addSubstitution', state: false })
        },
        searchSubstitution (search) {
            axios.get('/api/substitutions/count/' + this.substitution.make_id + '/' + encodeURI(search))
                .then(resp => {
                    this.result = resp.data.count
                })
                .catch(error => {
                    console.error('searchSubstitution', error)
                })
        }
    }
}
</script>

<style scoped>

</style>
