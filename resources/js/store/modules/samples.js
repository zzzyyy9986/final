export default {
    actions: {
        loadSamples(ctx) {
            ctx.commit("setSampleLoaded", false)
            axios.get("/getSamples")
                .then((res) => {
                    ctx.commit("setSamples", res.data)
                    ctx.commit("setSampleLoaded", true)

                })
        }
    },
    mutations: {
        setSamples(state, data) {
            state.samples = data
        },
        setSampleLoaded(state, data) {
            state.loaded = data
        }
    },
    state: {
        samples: {},
        loaded: false
    },
    getters: {
        getSamples(state) {
            return state.samples
        },
        isSamplesLoaded(state) {
            return state.loaded
        }
    }
}
