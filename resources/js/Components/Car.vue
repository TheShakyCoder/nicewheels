<template>
    <li>
        <div class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
            <div v-if="redeemedAmount" class="absolute z-10 top-0 left-0 right-0 bg-white bg-opacity-75 h-10 pt-1 text-center text-2xl text-green-800 font-bold">
                {{ redeemedAmount }}
            </div>
            <img :src="image" alt="" class="object-cover pointer-events-none group-hover:opacity-75" />
            <button type="button" class="absolute inset-0 focus:outline-none">
                <span class="sr-only">View details for {{ car.title }}</span>
            </button>
        </div>
        <p class="mt-2 block text-sm font-medium text-gray-800 truncate pointer-events-none">{{ car.title }}</p>
        <p class="block text-sm font-medium text-gray-500 truncate pointer-events-none">{{ car.subtitle }}</p>
        <div class="flex mt-3">

            <button
                @click="bookmarker"
                class="mr-3 p-1 rounded-full w-10 h-10 text-white border border-gray-300"
                :class="{ 'bg-green-600': bookmark, 'bg-gray-100 text-gray-600': !bookmark }"
            >
                <i class="fas fa-bookmark mt-1"></i>
            </button>

            <button
                @click="redeemer"
                class="mr-3 p-1 rounded-full w-10 h-10 border border-gray-200 text-white"
                :class="{ 'bg-yellow-500': redeemedAmount, 'bg-gray-100 text-gray-600': !redeemedAmount }"
            >
                <i class="fas fa-coin"></i>
            </button>

            <button @click="info" class="ml-auto rounded-full w-10 h-10 border border-gray-400">
                <i class="fal fa-window-restore"></i>
            </button>

        </div>
    </li>
</template>

<script>
export default {
    name: "Car",
    props: {
        car: {
            type: Object,
            default: null
        },
        preserveState: {
            type: Boolean,
            default: true
        }
    },
    data () {
        return {
            image: null
        }
    },
    computed: {
        user () {
            return this.$page.props.user ?? null
        },
        bookmark () {
            return this.car.bookmarks && this.car.bookmarks.length === 1
        },
        redeemedAmount () {
            if(!this.car.redemptions || !this.car.redemptions[0]) {
                return false
            }
            var formatter = new Intl.NumberFormat('en-GB', {
                style: 'currency',
                currency: 'GBP',
                maximumFractionDigits: 0
            });
            return formatter.format(this.car.redemptions[0].amount);
        }
    },

    watch: {
        'this.car.image': function(n, o) {
            console.log('watch', n, o)
        }
    },

    mounted () {
        this.getImage()
    },

    methods: {
        getImage() {
            const url = '/api/car-images/' + this.car.image.id
            console.log('url', url)
            axios.get(url)
                .then(resp => {
                    this.image = resp.data
                })
                .catch(err => {
                    console.error(err)
                })
        },
        bookmarker () {
            console.log('bookmarker')
            if(this.user) {
                this.$inertia.post('/cars/' + this.car.id + '/bookmark', {}, {
                    preserveScroll: true,
                    preserveState: this.preserveState
                })
            } else {
                this.$store.commit('showModal', { modal: 'guest', show: true, id: this.car.id })
            }
        },
        redeemer () {
            console.log('redeemer')
            if(this.user) {
                this.$store.commit('showModal', { modal: 'redeem', show: true, id: this.car.id })
            } else {
                this.$store.commit('showModal', { modal: 'guest', show: true, id: this.car.id })
            }
        },
        info () {
            console.log('info', this.car.id)
            this.$store.commit('showModal', { modal: 'info', show: true, id: this.car.id })
        }
    }
}
</script>

<style scoped>

</style>
