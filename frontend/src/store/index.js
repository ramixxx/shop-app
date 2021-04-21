import cart from './modules/cart'
import products from './modules/products'
import Vuex from 'vuex';


const store = new Vuex.Store({
  modules: {
    cart,
    products
  }
})

export default store;