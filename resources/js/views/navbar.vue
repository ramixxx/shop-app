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
                <div class="cart-actions">
                    <a class="waves-effect waves-light btn-small buy-button">Checkout</a>
                    <a class="waves-effect waves-light btn-small add-to-cart-button" v-on:click="clearCart">Clear all</a>
                </div>
            </div>
        </ul>
    </div>
</template>
<script>
import { mapState } from 'vuex';
import cartStore from '../store/index.js';
import productStore from '../store/products.js';

const searchUrl = '/search';

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
  data: function () {
    return {
        q: '',
    }
  },
  methods: {
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
        const requestOptions = {
            method: "GET",
            headers: { "_token": document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        };
        fetch("/clearCartProducts", requestOptions).then(cartStore.commit('RESET_MODULE'))       
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

        cartStore.commit('setAllCartItems', currentCartItems);
        cartStore.commit('setCurrentCartItemCount', this.cartItemCount + 1);
        cartStore.commit('addToCurrentTotalPrice', price);
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

        cartStore.commit('setAllCartItems', currentCartItems);
        cartStore.commit('setCurrentCartItemCount', this.cartItemCount - 1);
        cartStore.commit('removeFromCurrentTotalPrice', price);
    }
  },

  mounted() {
    $('.dropdown-trigger').dropdown({
        closeOnClick: false,
        coverTrigger: false
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
            cartStore.commit('setAllCartItems', data.cartData);
            cartStore.commit('setCurrentCartItemCount', data.totalQuantity);
            cartStore.commit('setCurrentTotalPrice', data.totalPrice);
        });
    }
};
</script>