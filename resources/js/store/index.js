import Vuex from "vuex"
import Vue from "vue"
import patterns from "./modules/samples";
import modal from "./modules/modal";
import message from "./modules/message";
Vue.use(Vuex)

export default new Vuex.Store( {
    modules: {patterns,modal,message}
})
