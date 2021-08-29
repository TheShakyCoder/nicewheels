<template>
    <div class="flex flex-col-reverse sm:flex-row sm:justify-between">
        <div class="flex flex-col">
            <h2 class="text-lg sm:text-2xl">{{ car.title }}</h2>
            <h3 class="text-sm sm:text-lg">{{ car.subtitle }}</h3>
            <h3 class="text-sm sm:text-lg">{{ make }}</h3>
            <hr>
            <div>{{ car.full_make }}</div>
            <div class="flex justify-start items-end flex-1 mt-2">
                <button type="button" class="w-12 h-12 mr-2 rounded-full bg-red-600 text-white flex items-center justify-center pl-1" @click="delete"></button>
                <button type="button" class="w-12 h-12 mr-2 rounded-full bg-cyan-600 text-white flex items-center justify-center pl-1" @click="edit"></button>
            </div>
        </div>
        <img class="bg-black rounded-lg sm:w-60 h-80 sm:h-40 object-cover sm:object-cover" :src="image" :alt="car.title" />
    </div>
</template>

<script>
export default {
    name: 'AdminCar',
    props: {
        car: {
            type: Object,
            default: null
        }
    },
    data () {
        return {
            image: null
        }
    },
    computed: {
        make () {
            return this.car.make ? this.car.make.name : '----'
        }
    },
    mounted () {
        this.getImage()
    },
    updated () {
        this.getImage()
    },
    methods: {
        getImage() {
            if(this.car.image === null) {
                console.log('no image')
                return
            }
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
        delete () {
            this.$inertia.delete('/admin/cars/' + this.car.id, {
                onBefore: () => confirm('Are you sure you want to delete this car?'),
                preserveScroll: true
            })
        },
        edit() {
            this.$store.commit('admin/setSingleProperty', { key: 'car', value: this.car })
            this.$store.commit('admin/toggleModal', { modal: 'carEdit', state: true })
        },
    }
}
</script>

<style scoped>

</style>
