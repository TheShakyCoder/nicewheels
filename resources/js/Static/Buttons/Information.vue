<template>
    <button
        @click="show"
        class="m-0 p-0 rounded-full w-10 h-10 text-white border border-gray-300 bg-gray-400"
    >
        <i class="far fa-window-restore fa-lg mt-1"></i>
    </button>
</template>

<script>
export default {
    name: "StaticButtonInformation",
    props: {
        id: null
    },
    computed: {
        user () {
            return this.$store.state.static.user
        }
    },
    methods: {
        show () {
            this.$store.commit('static/toggleModal', { modal: 'information', state: true })
            axios.get('/api/cars/' + this.id + '/information', { api_token: this.user.api_token })
                .then(resp => {
                    this.$store.commit('static/setStaticProperty', { key: 'car', value: resp.data.car })
                })
        }
    }
}
</script>

<style scoped>

</style>
