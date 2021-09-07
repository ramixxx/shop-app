import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		isGuest: false
	},

	mutations: {
		isGuest(state, isGuest) {
			state.isGuest = isGuest;
		}
	},
	actions: {

	}
})

export default store;