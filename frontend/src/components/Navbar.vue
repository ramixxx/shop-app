<template>
    <div>
        <nav>
            <div class="nav-wrapper">
                <form id="app" @submit="checkForm" method="post">
                    <input type="text" v-model="q" placeholder="Search.." class="search-input">
                    <button class="waves-effect waves-light btn-small search-submit-button"><input  type="submit" value="Search"></button>
                </form>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li>
                        <a href="#" class="dropdown-trigger" data-target="dropdown1">
                            <font-awesome-icon icon="shopping-cart" size="lg"/>
                            <span class="new badge cart-item-badge" v-if="cartItemCountVuex > 0" data-badge-caption="">{{ cartItemCountVuex }}</span>
                            
                            
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <ul id='dropdown1' class='dropdown-content'>
            <div v-if="cartItemsVuex.length > 0">
                <table class="cart-table">
                    <tr v-for="(cartItem,index) in cartItemsVuex" v-bind:key="index">
                        <td><img :src="getImgUrl(cartItem.image_path)" class="product-image-cart"></td>
                        <td>{{ cartItem.name }}</td>
                        <td>{{ cartItem.price }}</td>
                        <td>
                            <a class="waves-effect waves-light btn-small" v-on:click="increase(cartItem)">+</a>
                            {{ cartItem.quantity }} 
                            <a class="waves-effect waves-light btn-small" v-on:click="decrease(cartItem)">-</a>
                        </td>
                    </tr>
                </table>
                <p class="total-price"> Total : {{ totalPriceVuex }} </p>
                <div class="cart-actions">
                    <a class="waves-effect waves-light btn-small buy-button">Checkout</a>
                    <a class="waves-effect waves-light btn-small add-to-cart-button" v-on:click="clearCart">Clear all</a>
                </div>
            </div>
        </ul>
    </div>
</template>
<script>

import cartStore from '../store/modules/cart.js';
import axios from 'axios'
import 'materialize-css';
import 'materialize-css/dist/css/materialize.css'
import M from 'materialize-css/dist/js/materialize.min.js'

const searchUrl = '/search';

export default {
  components: {

  },
  computed: {
        cartItemCountVuex () {
            return cartStore.state.cartItemCount
        },
        cartItemsVuex () {
            return cartStore.state.cartItems
        },
        totalPriceVuex () {
            return cartStore.state.totalPrice
        }
  },
  props: [
    
  ],
  data: function () {
    return {
        q: '',
    }
  },
  methods: {
    getImgUrl: function (imagePath) {
        return require('@/assets' + imagePath);
    },
    checkForm: function (e) {
      e.preventDefault();

        const requestOptions = {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ q: this.q, "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') })
        };

        fetch(searchUrl, requestOptions)
        .then(res => {
            res.json().then(data => {
                this.$emit('populateCurrentProducts', data)
            })
            .catch((error) => {
              console.error('Error:', error);
            });
        });
      
    },

    clearCart: function() {
        axios.get('http://127.0.0.1:8000/api/clearCartProducts')
        .then((response) => {
            cartStore.commit('RESET_MODULE')
        }, (error) => {
            console.log(error);
        });       
    },

    manageProductQuantity: function(currentCartItems) {
        const requestOptions = {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ products: JSON.stringify(currentCartItems)})
        };
        fetch("/manageProductQuantity", requestOptions)
            .then(response => console.log(response));
    },

    increase: function(cartItem) {
        let uuid = cartItem.uuid;
        let price = cartItem.price;
        let currentCartItems = this.cartItemsVuex;
        currentCartItems.forEach(function(item) {
            if(item.uuid === uuid) {
                item.quantity++;
            }
        });
        this.manageProductQuantity(currentCartItems);

        cartStore.commit('setAllCartItems', currentCartItems);
        cartStore.commit('setCurrentCartItemCount', this.cartItemCountVuex + 1);
        cartStore.commit('addToCurrentTotalPrice', price);
    },

    decrease: function(cartItem) {
        let uuid = cartItem.uuid;
        let price = cartItem.price;
        let currentCartItems = this.cartItemsVuex;
        currentCartItems.forEach(function(item, index) {
            if(item.uuid === uuid) {
                if (item.quantity == 1) {
                    currentCartItems.splice(index, 1);
                } else {
                    item.quantity--;    
                }
            }
        });
        this.manageProductQuantity(currentCartItems);        

        cartStore.commit('setAllCartItems', currentCartItems);
        cartStore.commit('setCurrentCartItemCount', this.cartItemCountVuex- 1);
        cartStore.commit('removeFromCurrentTotalPrice', price);
    }
  },

  mounted() {
    const options = {
        closeOnClick: false,
        coverTrigger: false
    };
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.dropdown-trigger');
        M.Dropdown.init(elems, options);
    });
  },

  created: function () {
        axios.get('http://127.0.0.1:8000/api/getCartProducts')
        .then((response) => {
            console.log(response);
            cartStore.commit('setAllCartItems', response.data.cartData);
            cartStore.commit('setCurrentCartItemCount', response.data.totalQuantity);
            cartStore.commit('setCurrentTotalPrice', response.data.totalPrice);
        }, (error) => {
            console.log(error);
        });
    }
};
</script>