import cart from './modules/cart'
import products from './modules/products'
import session from './modules/session'
import Vuex from 'vuex';


const store = new Vuex.Store({
  modules: {
    cart,
    products,
    session
  }
})

export default store;