import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
	state: {
		cartItemCount: 0,
		cartItems: [],
		totalPrice: 0
	},

	mutations: {
		INCREMENT(state) {
			state.cartItemCount++
		},
		addItemToCart(state, product) {
			state.cartItems.push(product);
		},
		setAllCartItems(state, products) {
			Vue.set(state, 'cartItems', products);
		},
		setCurrentCartItemCount(state, count) {
			state.cartItemCount = count;
		},
		setCurrentTotalPrice(state, totalPrice) {
			state.totalPrice = totalPrice;
		},
		addToCurrentTotalPrice(state, priceToAdd) {
			state.totalPrice += Number(priceToAdd);
		},
		removeFromCurrentTotalPrice(state, priceToAdd) {
			state.totalPrice -= Number(priceToAdd);
		},
		RESET_MODULE (state) {
		  	Vue.set(state, "cartItemCount", 0);
		  	Vue.set(state, "cartItems", []);
		  	Vue.set(state, "totalPrice", 0);
		}
	},
	actions: {}
})

export default store;