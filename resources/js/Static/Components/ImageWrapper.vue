<template>
    <button @click="carousel" class="relative group-hover:opacity-75">
        <static-redeemed-amount :id="car.id"></static-redeemed-amount>
        <static-image :id="car.image ? car.image.id : 0"></static-image>
    </button>
</template>

<script>
import StaticRedeemedAmount from "./RedeemedAmount"
import StaticImage from "./Image"

export default {
    name: "StaticImageWrapper",
    components: {
        StaticRedeemedAmount,
        StaticImage
    },
    props: {
        car: null,
    },
    methods: {
        carousel () {
            this.$store.commit('static/setStaticProperty', { key: 'car', value: this.car })
            this.$store.commit('static/toggleModal', { modal: 'carousel', state: true })
        }
    }
}
</script>

<style scoped>

</style>
