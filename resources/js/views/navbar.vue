<template>
    <div>
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Logo</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li>
                    <a href="#" class="dropdown-trigger" data-target="dropdown1">
                        <span class="new badge cart-item-badge" v-if="cartItemCount > 0" data-badge-caption="">{{ cartItemCount }}</span>
                        <i class="large material-icons shopping-cart-icon">shopping_cart</i>
                        
                    </a>
                </li>
            </ul>
            </div>
        </nav>

        <ul id='dropdown1' class='dropdown-content'>
            <div v-if="cartItems.length > 0">
                <table class="cart-table">
                    <tr v-for="cartItem in cartItems">
                      <td><img :src="cartItem.image_path" class="product-image-cart"></td>
                      <td>{{ cartItem.name }}</td>
                      <td>{{ cartItem.price }}</td>
                    </tr>
                </table>
                <p class="total-price"> Total : {{ totalPrice }} </p>
                <a class="waves-effect waves-light btn-small buy-button">Buy</a>
                <a class="waves-effect waves-light btn-small add-to-cart-button" v-on:click="clearCart">Clear all</a>
            </div>
            <div v-else>
                <p>You dont have anything in cart!</p>
            </div>
        </ul>
    </div>
</template>
<script>
import { mapState } from 'vuex';
import store from '../store/index.js';

export default {
  components: {

  },
  computed: {
    ...mapState({
        cartItemCount: state => state.cartItemCount,
        cartItems: state => state.cartItems,
        totalPrice: state => state.totalPrice
    })
  },
  props: [
  ],
  methods: {
    clearCart: function () {
        const requestOptions = {
            method: "GET",
            headers: { "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        };
        fetch("/clearCartProducts", requestOptions).then(store.commit('RESET_MODULE'))
            
    }
    
  },

  mounted() {
    $('.dropdown-trigger').dropdown({});
  },

  created: function () {
    const requestOptions = {
        method: "GET",
        headers: { "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
    };
    fetch("/getCartProducts", requestOptions)
        .then(response => response.json())
        .then(data => {
            store.commit('setAllCartItems', data.cartData);
            store.commit('setCurrentCartItemCount', data.cartData.length);
            store.commit('setCurrentTotalPrice', data.totalPrice);
        });
    }
};
</script>