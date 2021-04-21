import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		currentProducts: []
	},

	mutations: {
		populateProducts(state, products) {
			state.currentProducts = products;
		}
	},
	actions: {}
})

export default store;