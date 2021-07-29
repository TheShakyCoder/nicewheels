<template>
    <img :src="image" alt="" class="mb-2 rounded-lg w-80">
</template>

<script>
export default {
    name: 'EbayItemImage',
    props: {
        ebayItemImage: {
            type: Object,
            default: null
        }
    },
    data () {
        return {
            image: null
        }
    },
    mounted () {
        const url = '/api/car-images/' + this.ebayItemImage.id
        axios.get(url)
            .then(resp => {
                this.image = resp.data
            })
    }
}
</script>

<style scoped>

</style>
