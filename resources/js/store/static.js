const staticStore = {
    namespaced: true,
    state: {
        modals: {
            mobile: false,
            profile: false,
            login: false,
            guest: false,
            redeem: false,
            stripe: false
        },
        collections: {
            bookmarks: [],
            redemptions: [],
            filterStatic: [],
            filterMore: [],
            filterCars: [],
        },
        user: null,
        redemptionId: 0,
        redemptionTitle: null
    },

    getters: {
        filterCombined (state) {
            return state.collections.filterStatic.concat(state.collections.filterMore)
        }
    },

    actions: {
        removeFromCollection ({ commit, state }, data) {
            const itemIndex = state.collections[data.collection].map(function(e) { return e.id; }).indexOf(data.item.id)
            commit('removeFromCollection', { itemIndex, collection: data.collection })
        }
    },
    mutations: {
        toggleModal (state, data) {
            state.modals[data.modal] = data.state ? data.state : !state.modals[data.modal]
        },
        setUser (state, data) {
            state.user = data.user
        },
        setCollection (state, data) {
            state.collections[data.collection] = data.data
        },
        setRedemption (state, data) {
            state.redemptionId = data.id
            state.redemptionTitle = data.title
        },
        addToCollection (state, data) {
            if(Array.isArray(data.item)) {
                data.item.forEach(i => state.collections[data.collection].push(i))
            } else {
                state.collections[data.collection].push(data.item)
            }
        },
        removeFromCollection (state, data) {
            state.collections[data.collection].splice(data.itemIndex, 1)
        }
    }
}

export default staticStore
