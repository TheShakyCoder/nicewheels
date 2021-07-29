<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div v-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <transition duration="300ms">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <transition enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div v-show="open" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                </transition>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <transition enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="open" class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full sm:p-6">
                        <div>

                            <div class="mt-3 text-center sm:mt-5">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Buy Tokens
                                </h3>
                                <div class="mt-2 flex flex-col max-w-80">

                                    <h4 class="text-xl font-bold mt-4 mb-1">Quantity</h4>
                                    <price-radios @price="selected"></price-radios>

                                    <h4 class="text-xl font-bold mt-4 mb-1">Payment</h4>
                                    <div class="mb-2">
<!--                                        <label for="card-holder-name" class="block text-left text-sm font-medium text-gray-700">Cardholders Full Name</label>-->
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <!-- Heroicon name: solid/users -->
                                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                    </svg>
                                                </div>
                                                <input type="text" name="card_holder_name" id="card-holder-name" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300" placeholder="Cardholders Full Name"  v-model="customer.cardHolderName">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stripe Elements Placeholder -->
                                    <div class="p-2 shadow-sm">
                                        <div id="card-element"></div>
                                    </div>
<!--                                    <button @click="process" id="card-button">Process Payment</button>-->

                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button
                                @click="process"
                                id="card-button"
                                type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-cyan-600 text-base font-medium text-white hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm"
                                :disabled="!clickable"
                            >
                                Process Payment
                            </button>
                            <button @click="close" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js'
import PriceRadios from '../Components/PriceRadios'

export default {
    name: "ModalStripe",
    components: {
        PriceRadios
    },
    data () {
        return {
            stripe: {
                stripe: null,
                elements: null,
                cardElement: null,
                cardButton: null,
                style: {
                    base: {
                        color: "#32325d",
                        fontFamily: 'Arial, sans-serif',
                        fontSmoothing: "antialiased",
                        fontSize: "16px",
                        "::placeholder": {
                            color: "#32325d"
                        },
                    },
                    invalid: {
                        fontFamily: 'Arial, sans-serif',
                        color: "#fa755a",
                        iconColor: "#fa755a"
                    }
                }
            },
            customer: {
                cardHolderName: null,
            },
            metadata: {
                price: 2,
                quantity: 20
            },
            clickable: true
        }
    },
    computed: {
        open () {
            return this.$store.state.static.modals.stripe
        },
        redemptionId () {
            return this.$store.state.static.redemptionId
        },
        user () {
            return this.$store.state.static.user
        }
    },
    async mounted () {
        axios.get('/api/get-stripe-publishable')
            .then(resp => {
                this.setStripe(resp.data)
            })
    },
    methods: {
        close() {
            this.$store.commit('static/toggleModal', { modal: 'stripe', state: false })
        },

        async setStripe (publishable) {
            this.stripe.stripe = await loadStripe(publishable)
            this.stripe.elements = this.stripe.stripe.elements();
            this.stripe.cardElement = this.stripe.elements.create('card', { style: this.stripe.style });
            this.stripe.cardElement.mount('#card-element');
        },

        selected (price) {
            this.metadata.price = price.price
            this.metadata.quantity = price.tokens
        },

        async process () {

            this.clickable = false

            const { paymentMethod, error } = await this.stripe.stripe.createPaymentMethod(
                'card', this.stripe.cardElement, {
                    billing_details: {
                        name: this.customer.cardHolderName,
                        email: this.user.email
                    },
                    metadata: this.metadata
                }
            );

            if (error) {
                // TODO: Display "error.message" to the user...
                console.error(error)
                this.clickable = true
            } else {
                // The card has been verified successfully...
                console.log('success', paymentMethod)
                this.customer = Object.assign(this.customer, paymentMethod)
                this.customer.metadata = this.metadata
                console.log('data', this.customer)
                axios.post('/api/stripe-purchase', this.customer)
                    .then(resp => {
                        //  increment local tokens
                        let user = JSON.parse(localStorage.getItem('user'))
                        user['tokens'] = parseInt(user['tokens']) + parseInt(resp.data.quantity)
                        localStorage.setItem('user', JSON.stringify(user))
                        this.clickable = true
                        this.$store.commit('static/setUser', { user })
                        this.$store.commit('static/toggleModal', { modal: 'stripe', state: false })
                        if(this.redemptionId) {
                            this.$store.commit('static/toggleModal', { modal: 'redeem', state: true })
                        }
                    })
                    .catch(err => {
                        alert(err)
                        this.clickable = true
                    })
            }
        }
    }
}
</script>

<style scoped>

</style>
