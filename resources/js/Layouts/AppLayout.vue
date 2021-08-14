<template>
    <div>
        <jet-banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <a :href="route('index')">
                                    <jet-application-mark class="block h-9 w-auto" />
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </jet-nav-link>

                                <jet-nav-link :href="route('purchases')" :active="route().current('purchases')">
                                    Purchases
                                </jet-nav-link>

                                <jet-nav-link :href="route('redemptions')" :active="route().current('redemptions')">
                                    Redemptions
                                </jet-nav-link>

                                <jet-nav-link :href="route('bookmarks')" :active="route().current('bookmarks')">
                                    Bookmarks
                                </jet-nav-link>

                                <jet-nav-link v-if="user.admin" :href="route('admin.index')" :active="route().current('admin')">
                                    Admin
                                </jet-nav-link>
                            </div>
                        </div>

                        <div class="flex items-center ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <!-- Mobile menu button -->
                                <button @click="showingNavigationDropdown = ! showingNavigationDropdown" type="button" class="bg-transparent p-2 rounded-md inline-flex items-center justify-center text-cyan-600 hover:text-cyan-400 hover:bg-gray-100 hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white" aria-expanded="false">
                                    <span class="sr-only">Open main menu</span>
                                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>

        <mobile-modal :open="showingNavigationDropdown" @close="showingNavigationDropdown = false"></mobile-modal>

        <car-edit-modal></car-edit-modal>
        <aspect-make-modal></aspect-make-modal>
        <make-add-modal></make-add-modal>

    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import MobileModal from "../Modals/Mobile"
    import CarEditModal from "../Modals/CarEdit"
    import AspectMakeModal from "../Modals/AspectMake"
    import MakeAddModal from "../Modals/Makes/Add"

    export default {
        components: {
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,

            MobileModal,
            CarEditModal,
            AspectMakeModal,
            MakeAddModal
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        computed: {
            admin () {
                return this.$page.props.user && this.$page.props.user.admin === 1
            },
            user () {
                return this.$page.props.user
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                axios.post('/api/logout', { api_token: this.user.api_token })
                    .then(resp => {
                        if(resp.status === 200) {
                            localStorage.removeItem('user')
                            window.location.href = '/'
                        }
                    })
            },
        }
    }
</script>
