export default {
    state: {
        currentModal: ""
    },
    mutations: {
        setCurrentModal(state, modal) {
            state.currentModal = modal
        }
    },
    getters: {
        getCurrentModal(state) {
            return state.currentModal
        }
    }
}
