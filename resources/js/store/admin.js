const adminStore = {
    namespaced: true,
    state: {
        modals: {
            carEdit: false,
            aspectMake: false,
            makeAdd: false,
        },
        carId: null,
        car: null,
        aspectMake: null,
        make: null,
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
