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
                        <td>
                            <a class="waves-effect waves-light btn-small" v-on:click="increase(cartItem)">+</a>
                            {{ cartItem.quantity }} 
                            <a class="waves-effect waves-light btn-small" v-on:click="decrease(cartItem)">-</a>
                        </td>
                    </tr>
                </table>
                <p class="total-price"> Total : {{ totalPrice }} </p>
                <a class="waves-effect waves-light btn-small buy-button">Checkout</a>
                <a class="waves-effect waves-light btn-small add-to-cart-button" v-on:click="clearCart">Clear all</a>
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
    clearCart: function() {
        const requestOptions = {
            method: "GET",
            headers: { "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        };
        fetch("/clearCartProducts", requestOptions).then(store.commit('RESET_MODULE'))       
    },

    manageProductQuantity: function(currentCartItems) {
        const requestOptions = {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ products: JSON.stringify(currentCartItems), "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') })
        };
        fetch("/manageProductQuantity", requestOptions)
            .then(response => console.log(response));
    },

    increase: function(cartItem) {
        let uuid = cartItem.uuid;
        let price = cartItem.price;
        let currentCartItems = this.cartItems;
        currentCartItems.forEach(function(item) {
            if(item.uuid === uuid) {
                item.quantity++;
            }
        });
        this.manageProductQuantity(currentCartItems);

        store.commit('setAllCartItems', currentCartItems);
        store.commit('setCurrentCartItemCount', this.cartItemCount + 1);
        store.commit('addToCurrentTotalPrice', price);
    },

    decrease: function(cartItem) {
        let uuid = cartItem.uuid;
        let price = cartItem.price;
        let currentCartItems = this.cartItems;
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

        store.commit('setAllCartItems', currentCartItems);
        store.commit('setCurrentCartItemCount', this.cartItemCount - 1);
        store.commit('removeFromCurrentTotalPrice', price);
    }
  },

  mounted() {
    $('.dropdown-trigger').dropdown({
        closeOnClick: false,
        coverTrigger: false,
        inDuration: 0,
        outDuration: 0
    });
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
            store.commit('setCurrentCartItemCount', data.totalQuantity);
            store.commit('setCurrentTotalPrice', data.totalPrice);
        });
    }
};
</script>