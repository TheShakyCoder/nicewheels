<template>
    <button
        @click="show"
        class="mr-3 p-1 rounded-full w-10 h-10 text-white border border-gray-300 bg-gray-400"
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
    methods: {
        show () {
            axios.get('/api/cars/' + this.id + '/information')
                .then(resp => {
                    console.log(resp)
                    this.$store.commit('static/setStaticProperty', { key: 'informationCar', value: resp.data.car })
                })
            this.$store.commit('static/toggleModal', { modal: 'information', state: true })
        }
    }
}
</script>

<style scoped>

</style>
