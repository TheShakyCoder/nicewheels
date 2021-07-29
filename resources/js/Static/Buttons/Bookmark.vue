<template>
    <button
        :id="'bookmark-' + id"
        @click="bookmarker"
        class="mr-3 p-1 rounded-full w-10 h-10 text-white border border-gray-300"
        :class="{ 'bg-green-600': bookmark, 'bg-gray-400 text-white': !bookmark }"
    >
        <i class="fas fa-bookmark fa-lg mt-1"></i>
    </button>
</template>

<script>
export default {
    name: "StaticButtonBookmark",
    props: {
        id: 0
    },
    computed: {
        user () {
            return this.$store.state.static.user
        },
        bookmark () {
            return this.$store.state.static.collections.bookmarks.filter(b => b.id === this.id)[0]
        }
    },
    methods: {
        bookmarker () {
            //  is guest?
            if(!this.user) {
                this.$store.commit('static/toggleModal', { modal: 'guest', state: true })
            } else {
                axios.post('/api/cars/' + this.id + '/bookmark', { api_token: this.user.api_token })
                    .then(resp => {
                        if(resp.data.action === 'create') {
                            this.$store.commit('static/addToCollection', { collection: 'bookmarks', item: resp.data.bookmark })
                        } else if(resp.data.action === 'delete') {
                            this.$store.dispatch('static/removeFromCollection', { collection: 'bookmarks', item: resp.data.bookmark })
                        }
                    })
            }

        }
    }
}
</script>

<style scoped>

</style>
