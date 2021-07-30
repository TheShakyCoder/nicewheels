<template>
    <button @click="filter" class="text-yellow-800">
        <i class="far fa-caret-square-down fa-2x"></i>
    </button>
</template>

<script>
export default {
    name: "ButtonShowSideFilter",
    methods: {
        filter () {
            this.$store.commit('static/toggleModal', { modal: 'sideFilter', state: true })
        }
    }
}
</script>

<style scoped>

</style>
