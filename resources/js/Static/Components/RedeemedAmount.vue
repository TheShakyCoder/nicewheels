<template>
    <div v-if="redemption" class="absolute z-10 top-0 left-0 right-0 bg-white bg-opacity-75 h-10 pt-1 text-center text-2xl text-green-800 font-bold">
        {{ amount }}
    </div>
</template>

<script>
export default {
    name: "StaticRedeemedAmount",
    props: {
        id: {
            type: Number,
            default: 0
        }
    },
    computed: {
        redemption () {
            return this.$store.state.static.collections.redemptions.filter(r => r.id === this.id)[0]
        },
        amount () {
            var formatter = new Intl.NumberFormat('en-GB', {
                style: 'currency',
                currency: 'GBP',
                maximumFractionDigits: 0
            });
            return formatter.format(this.redemption.redemptions[0].amount)
        }
    }
}
</script>

<style scoped>

</style>
