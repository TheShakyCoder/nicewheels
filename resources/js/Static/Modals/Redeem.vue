<template>
    <transition duration="300ms">
        <div v-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div v-if="user" class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                </transition>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div v-show="open" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                        <div>
<!--                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">-->
<!--                                <CheckIcon class="h-6 w-6 text-green-600" aria-hidden="true" />-->
<!--                            </div>-->
                            <div class="mt-3 text-center sm:mt-5">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Redeem Token</h3>
                                <div class="mt-2">
                                    <p>You currently have {{ tokens }} token{{ tokens !== 1 ? 's' : '' }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ tokens ? 'Do you wish to redeem a token on this car?' : 'Do you wish to buy some tokens?' }}
                                    </p>
                                    <small>{{ title }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button
                                type="button"
                                v-if="tokens"
                                class="w-full inline-flex justify-center rounded-md border border-transparent bg-green-600 hover:bg-green-700 shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:col-start-2 sm:text-sm"
                                @click="redeem"
                            >
                                Redeem
                            </button>

                            <button
                                type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent bg-cyan-600 hover:bg-cyan-700 shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 sm:col-start-2 sm:text-sm"
                                v-if="!tokens"
                                @click="buy"
                            >
                                Buy Tokens
                            </button>
                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm" @click="close" ref="cancelButtonRef">
                                Cancel
                            </button>
                        </div>

                    </div>
                </transition>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'ModalRedeem',
    computed: {
        id () {
            return this.$store.state.static.redemptionId
        },
        title () {
            return this.$store.state.static.redemptionTitle
        },
        user () {
            return this.$store.state.static.user
        },
        tokens () {
            return this.user.tokens
        },
        open () {
            return this.$store.state.static.modals.redeem
        }
    },
    methods: {
        redeem () {
            this.$store.commit('static/toggleModal', { modal: 'redeem', state: false })
            axios.post('/api/cars/' + this.id + '/redeem', { api_token: this.user.api_token })
                .then(resp => {
                    this.$store.commit('static/addToCollection', { collection: 'redemptions', item: resp.data.redemption })
                    this.$store.commit('static/setUser', { user: resp.data.user })
                    localStorage.setItem('user', JSON.stringify(resp.data.user))
                    this.$store.commit('static/setRedemption', { id: null, title: null })
                })
        },
        buy () {
            this.$store.commit('static/toggleModal', { modal: 'redeem', show: false })
            this.$store.commit('static/toggleModal', { modal: 'stripe', show: true })
        },
        close () {
            this.$store.commit('static/setRedemption', { id: null, title: null })
            this.$store.commit('static/toggleModal', { modal: 'redeem', show: false })
        }
    }
}
</script>
