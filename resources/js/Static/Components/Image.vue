<template>
    <img :src="image" alt="" class="object-cover pointer-events-none" />
</template>

<script>
export default {
    name: "StaticImage",
    props: {
        id: {
            type: Number,
            default: null
        }
    },
    data () {
        return {
            image: null
        }
    },
    mounted () {
        this.getImage()
    },
    methods: {
        getImage() {
            if(!this.id) {
                return
            }
            const url = '/api/car-images/' + this.id
            axios.get(url)
                .then(resp => {
                    this.image = resp.data
                })
                .catch(err => {
                    console.error(err)
                })
        },
    }
}
</script>

<style scoped>

</style>
