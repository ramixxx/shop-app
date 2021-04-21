import axios from 'axios'
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
	actions: {
		populateProducts(context) {
			axios.get('http://127.0.0.1:8000/api')
			.then((response) => {
				context.commit('populateProducts', response.data);
			}, (error) => {
				console.log(error);
			});
		}
	}
})

export default store;