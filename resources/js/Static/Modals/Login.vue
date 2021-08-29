<template>
    <transition duration="300ms">
        <div v-show="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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

                        <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                            <button @click="close" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="sm:mx-auto sm:w-full sm:max-w-md">
                            <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                                Sign in to your account
                            </h2>
                            <p class="mt-2 text-center text-sm text-gray-600">
                                Or
                                <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    register a new account
                                </a>
                            </p>
                        </div>

                        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">
                                            Email address
                                        </label>
                                        <div class="mt-1">
                                            <input v-model="form.email" id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">
                                            Password
                                        </label>
                                        <div class="mt-1">
                                            <input v-model="form.password" id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                                Remember me
                                            </label>
                                        </div>

                                        <div class="text-sm">
                                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                                Forgot your password?
                                            </a>
                                        </div>
                                    </div>

                                    <div>
                                        <button @click="login" type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Sign in
                                        </button>
                                    </div>

                            </div>
                        </div>
                    </div>

                </transition>
            </div>
        </div>
    </transition>
</template>

<script>

export default {
    data () {
        return {
            form: {
                email: null,
                password: null
            }
        }
    },
    computed: {
        open () {
            return this.$store.state.static.modals.login
        }
    },
    methods: {
        close () {
            this.$store.commit('static/toggleModal', { modal: 'login', state: false })
        },
        login () {
            console.log('login')
            axios.post('/api/login', this.form)
                .then(resp => {
                    console.log(resp)
                    localStorage.setItem('user', JSON.stringify(resp.data.user))
                    this.$store.commit('static/setUser', { user: resp.data.user })
                    this.$store.commit('static/toggleModal', { modal: 'login', state: false })
                    if(this.$store.state.static.redemptionId) {
                        this.$store.commit('static/toggleModal', { modal: 'redeem', state: true})
                    }
                })
        }
    }
}
</script>
