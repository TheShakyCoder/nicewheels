<template>
    <template v-for="car in cars">
        <li>
            <div class="relative group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                <static-redeemed-amount :id="car.id"></static-redeemed-amount>
                <static-image :id="car.image ? car.image.id : 0"></static-image>
                <button type="button" class="absolute inset-0 focus:outline-none">
                    <span class="sr-only">View details for {{ car.title }}</span>
                </button>
            </div>
            <p class="mt-2 block text-sm font-medium text-gray-800 truncate pointer-events-none">{{ car.title }}</p>
            <p class="block text-sm font-medium text-gray-500 truncate pointer-events-none">{{ car.subtitle }}</p>
            <div class="flex mt-3">

                <button-bookmark :id="car.id"></button-bookmark>
                <button-redeem :id="car.id" title="car.title"></button-redeem>

            </div>
        </li>
    </template>

    <li class="flex items-center">
        <button @click="loadMore" class="w-full h-full bg-cyan-600 text-white" v-if="show">
            <i class="fas fa-ellipsis-h fa-4x"></i>
        </button>
    </li>
</template>

<script>
import ButtonBookmark from '../Buttons/Bookmark'
import ButtonRedeem from '../Buttons/Redeem'
import StaticRedeemedAmount from '../Components/RedeemedAmount'
import StaticImage from '../Components/Image'

export default {
    name: "ButtonLoadMore",
    components: {
        ButtonBookmark,
        ButtonRedeem,
        StaticImage,
        StaticRedeemedAmount
    },
    props: {
        ids: {
            type: Array,
            default: []
        },
        makes: {
            type: Object,
            default: []
        }
    },

    data () {
        return {
            show: true
        }
    },

    computed: {
        collection () {
            return this.$store.getters['static/filterCombined']
        },
        cars () {
            return this.$store.state.static.collections.filterCars
        }
    },

    mounted () {
        this.$store.commit('static/setCollection', { collection: 'filterStatic', data: this.ids })
    },

    methods: {
        loadMore () {
            console.log(this.collection)
            axios.post('/api/cars/', { ids: this.collection, makes: this.makes })
                .then(resp => {
                    console.log(resp)
                    this.$store.commit('static/addToCollection', { collection: 'filterMore', item: resp.data.cars.data.map(d => d.id) })
                    this.$store.commit('static/addToCollection', { collection: 'filterCars', item: resp.data.cars.data })
                    if(resp.data.cars.last_page === 1) {
                        this.show = false
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
