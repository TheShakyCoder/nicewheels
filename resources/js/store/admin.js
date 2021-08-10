const adminStore = {
    namespaced: true,
    state: {
        modals: {
            carEdit: false,
        },
        carId: null,
        car: null,
        makes: []
    },

    mutations: {
        toggleModal (state, data) {
            state.modals[data.modal] = data.state ? data.state : !state.modals[data.modal]
        },
        setSingleProperty (state, data) {
            state[data.key] = data.value
        }
    }
}

export default adminStore
