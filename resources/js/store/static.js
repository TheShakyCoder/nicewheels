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
            redemptions: []
        },
        user: null,
        redemptionId: 0,
        redemptionTitle: null
    },
    actions: {
        removeFromCollection ({ commit, state }, data) {
            const itemIndex = state.collections[data.collection].map(function(e) { return e.id; }).indexOf(data.item.id)
            commit('removeFromCollection', { itemIndex, collection: data.collection })
        }
        // deleteUser(context, data) {
        //     const roomIndex = state.rooms.map(function(e) { return e.roomId; }).indexOf(data.chatId)
        //     const userIndex = state.rooms[roomIndex].users.map(function(u) { return u._id }).indexOf(data.userId)
        //     context.commit('deleteUser', { roomindex, userIndex })
        // },
        // deleteRoom(context, data) {
        //     const roomIndex = state.rooms.map(function(e) { return e.roomId; }).indexOf(data.chatId)
        //     context.commit('deleteRoom', { roomIndex })
        // },
        // resetIncrementUnread(state, data) {
        //     const roomIndex = state.rooms.map(function(e) { return e.roomId; }).indexOf(data.chatId)
        //     context.commit('resetIncrementUnread', { roomIndex })
        // }
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
        // setRedemptionId (state, data) {
        //     state.redemptionId = data.redemptionId
        // },
        addToCollection (state, data) {
            state.collections[data.collection].push(data.item)
        },
        removeFromCollection (state, data) {
            state.collections[data.collection].splice(data.itemIndex, 1)
        }
    },
    getters: {

    }
}

export default staticStore
