<template>
  <div>
      <Navbar />
      <div class="row">
          <div class="col s12 m4 l2"><p>s12 m4</p></div>
          <div class="col s12 m4 l8 center-align">
              <div class="row" v-for="rowIdx in Math.ceil(allproducts.length / 4)">
                  <div class="col s12 m6 l3" v-for="product in allproducts.slice(4 * (rowIdx - 1), 4 * rowIdx)">
                      <div class="card large">
                          <div class="card-image">
                              <span class="helper"></span>
                              <img :src="product.image_path" class="product-image">
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
          <div class="col s12 m4 l2"><p>s12 m4</p></div>
      </div>
  </div>
</template>
<script>
import axios from "axios";
import Navbar from './navbar.vue';
import store from '../store/index.js';

export default {
  components: {
    Navbar
  },
  props: [
    'allproducts'
  ],
  methods: {
    addToCart: function (product) {
      store.commit('INCREMENT');
      store.commit('addItemToCart', product);
      store.commit('addToCurrentTotalPrice', product.price);

      const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ product: JSON.stringify(product), "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') })
      };
      fetch("/addProductToCart", requestOptions)
        .then(response => response.json())
        .then(data => (console.log(data)));
    }
  }
};
</script>