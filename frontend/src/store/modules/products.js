import axios from 'axios'
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		currentProducts: [],
		productCount: null
	},

	mutations: {
		populateProducts(state, products) {
			state.currentProducts = products;
			state.productCount = products.length;
		}
	},
	actions: {
		populateProducts(context) {
			context.currentProducts = [];
			axios.get('http://localhost:8000/api/getAllProducts')
			.then((response) => {
				context.commit('populateProducts', response.data);
			}, (error) => {
				console.log(error);
			});
		}
	}
})

export default store;