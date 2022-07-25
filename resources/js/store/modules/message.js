export default {
    state: {
        msg: "",
        status: 0
    },
    mutations: {
        setSuccessMsg(state, msg) {
            state.msg = msg
            state.status = 1;
        },
        setErrorMsg(state, msg) {
            state.msg = msg
            state.status = -1;
        },
        setInfoMsg(state, msg) {
            state.msg = msg
            state.status = 2;
        },
        setDefaultMsg(state) {
            state.msg = ""
            state.status = 0;
        },
    },
    getters: {
        getMsg(state) {
            return {
                msg: state.msg,
                status: state.status
            }
        }
    }
}
