import axios from 'axios'
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		currentProducts: [],
		productCount: null,
		resultStatus: null
	},

	mutations: {
		populateProducts(state, products) {
			state.currentProducts = products;
			state.productCount = products.length;
		},

		resultStatus(state, status) {
			state.resultStatus = status;
		}
	},
	actions: {
		populateProducts(context) {
			context.commit('resultStatus', 'finding');
			context.currentProducts = [];
			axios.get('http://localhost:8000/api/getAllProducts')
			.then((response) => {
				context.commit('resultStatus', 'result');
				context.commit('populateProducts', response.data);
			}, (error) => {
				console.log(error);
			});
		}
	}
})

export default store;