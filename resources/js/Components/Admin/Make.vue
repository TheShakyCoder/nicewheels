<template>

        <div class="flex-grow">{{ "-".repeat(make.depth) }}{{ make.name }}</div>
        <div>
            <select v-model="form.parent_id" name="parent_id" id="parent_id">
                <option value="">-- root --</option>
                <option v-for="m in makes" :value="m.id">{{ m.name }}</option>
            </select>
            <button @click="change">Change</button>
        </div>
        <inertia-link :preserve-scroll="true" method="post" as="button" :href="route('admin.makes.up', make.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">Up</inertia-link>
        <inertia-link :preserve-scroll="true" method="post" as="button" :href="route('admin.makes.down', make.id)" class="p-1 px-2 rounded border border-gray-200 ml-2">Down</inertia-link>

</template>

<script>
export default {
    name: "AdminMakeComponent",
    props: {
        make: {
            type: Object,
            default: null
        },
        makes: {
            type: Object,
            default: null
        }
    },
    data () {
        return {
            form: {
                parent_id: null
            }
        }
    },
    mounted () {
        this.form.parent_id = this.make.parent_id
    },
    methods: {
        change () {
            this.$inertia.patch('/admin/makes/' + this.make.id, this.form)
        }
    }
}
</script>

<style scoped>

</style>
