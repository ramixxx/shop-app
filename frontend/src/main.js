import Vue from 'vue';
import App from './App.vue';
import store from './store';
import 'materialize-css';
import 'materialize-css/dist/css/materialize.css'
import 'materialize-css/dist/js/materialize.min.js'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faShoppingCart, faLaptop, faMobileAlt } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faShoppingCart)
library.add(faLaptop)
library.add(faMobileAlt)

Vue.component('font-awesome-icon', FontAwesomeIcon)

new Vue({
  render: h => h(App),
  store,
  components: { App }
}).$mount('#app')