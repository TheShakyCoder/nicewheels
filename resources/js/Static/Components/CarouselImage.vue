<template>
    <img :src="image" :alt="title + ' - ' + id">
</template>

<script>
export default {
    name: "StaticCarouselImage",
    props: {
        id: null,
        title: null
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
            const url = '/api/car-images/' + this.id
            axios.get(url)
                .then(resp => {
                    this.image = resp.data
                })
                .catch(err => {
                    console.error(err)
                })
        }
    }
}
</script>

<style scoped>

</style>
