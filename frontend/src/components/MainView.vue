<template>
  <div>
    
    <Navbar/>
    <div>
    <div class="row">
        <div class="col s12 m4 l2"><LeftSidebar /></div>
        <div class="col s12 m4 l8 center-align" id="mid-view">
            <div class="row" v-for="(rowIdx, index) in Math.ceil(currentProductsVuex.length / 4)" v-bind:key="index">
                <div class="col s12 m6 l3" v-for="(product, index) in currentProductsVuex.slice(4 * (rowIdx - 1), 4 * rowIdx)" v-bind:key="index">
                    <div class="card large">
                        <div class="card-image">
                            <span class="helper"></span>
                            <img :src="getImgUrl(product.image_path)" class="product-image">
                            <span class="product-name" style="width:100%; background: rgba(0, 0, 0, 0.5);">{{product.name}} - {{product.price}}</span>
                        </div>
                        <div class="card-content">
                            <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
                        </div>
                        <div class="product-action-div">
                            <div class="buttons">
                                <a class="waves-effect waves-light btn-small buy-button">Buy</a>
                                <a class="waves-effect waves-light btn-small add-to-cart-button" id="addToCart" v-on:click="addToCart(product)">Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l2"><RightSidebar /></div>
    </div>
    </div>
    
  </div>
</template>
<script>
// import { mapState } from 'vuex';
import Navbar from './Navbar.vue';
import LeftSidebar from './LeftSidebar.vue';
import RightSidebar from './RightSidebar.vue';
import cartStore from '../store/modules/cart.js';
import productStore from '../store/modules/products.js';

export default {
    name: 'MainView',
    components: {
      Navbar,
      LeftSidebar,
      RightSidebar
    },
    computed: {
        currentProductsVuex () {
          return productStore.state.currentProducts
        },
        // ...mapState({
        //     cartItems: state => state.cartItems,
        //     totalPrice: state => state.totalPrice,
        //     currentProducts: state => state.currentProducts
        // })
    },
    methods: {
        getImgUrl: function (imagePath) {
            return require('@/assets' + imagePath);
        },
        addToCartPost: function(product) {
            product['quantity'] = 1;
            cartStore.commit('INCREMENT');
            cartStore.commit('addToCurrentTotalPrice', product.price);
            cartStore.commit('addItemToCart', product);
            
            const requestOptions = {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ product: JSON.stringify(product) })
            };
            fetch("http://127.0.0.1:8000/api/addProductToCart", requestOptions)
              .then(response => console.log(response));
        },

        addToCart: function (product) {
            let uuid = product.uuid;
            let currentCartItems = this.currentProductsVuex;

            var i;
            if (currentCartItems.length == 0) {
              this.addToCartPost(product);
            } else {
                for (i = 0; i < currentCartItems.length; i++) {
                    if(currentCartItems[i].uuid === uuid) {
                        currentCartItems[i].quantity++;
                        cartStore.commit('INCREMENT');
                        cartStore.commit('addToCurrentTotalPrice', product.price);
                        cartStore.commit('setAllCartItems', currentCartItems);
                        break;
                    } else {
                        this.addToCartPost(product);
                        break;
                    }
                } 
            }
        }
    },

    created() {
      productStore.dispatch('populateProducts');
    }
};
</script>