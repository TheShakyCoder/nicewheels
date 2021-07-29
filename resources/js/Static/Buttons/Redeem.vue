<template>
    <button
        :id="'redeem-' + id"
        @click="redeemer"
        class="mr-3 p-1 rounded-full w-10 h-10 border border-gray-200 text-white"
        :class="{ 'bg-yellow-500': redemption, 'bg-gray-400 text-white': !redemption }"
    >
        <i class="fas fa-coin fa-lg mt-1"></i>
    </button>
</template>

<script>
export default {
    name: "StaticButtonRedeem",
    props: {
        id: 0,
        title: null
    },
    computed: {
        redemption () {
            return this.$store.state.static.collections.redemptions.filter(r => r.id === this.id)[0]
        },
        user () {
            return this.$store.state.static.user
        }
    },
    methods: {
        redeemer () {
            console.log('TITLE', this.title)
            if(!this.$store.state.static.collections.redemptions.filter(r => r.id === this.id).length && this.user) {
                this.$store.commit('static/setRedemption', { id: this.id, title: this.title })
                // this.$store.commit('static/setRedemptionId', { redemptionId: this.id })
                this.$store.commit('static/toggleModal', { modal: 'redeem', state: true })
            }
        }
    }
}
</script>

<style scoped>

</style>
