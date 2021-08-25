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
                    <div v-if="isLoggedIn">
                        
                            Welcome, {{loggedInUser}} !
                        
                    </div>
                    </li>
                    <li>
                        <div v-if="isLoggedIn">
                             <li><a href="#logout"><font-awesome-icon icon="sign-out-alt" size="lg" @click="logout"/></a></li>
                        </div>
                        <div v-else>
                            <a href="#" class="dropdown-trigger2" data-target="dropdown2">
                                <font-awesome-icon icon="sign-in-alt" size="lg"/>                         
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="#" class="dropdown-trigger1" data-target="dropdown1">
                            <font-awesome-icon icon="shopping-cart" size="lg"/>
                            <span class="new badge cart-item-badge" v-if="cartItemCountVuex > 0" data-badge-caption="">{{ cartItemCountVuex }}</span>                            
                        </a>
                    </li>
                    
                </ul>
            </div>
        </nav>

        <ul id='dropdown2' class='dropdown-content'>
            <div class="alert alert-danger" role="alert" v-if="error !== null">
                {{ error }}
            </div>
            <div v-if="isLogin">
                <div class='login-form'>
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                            <input id="email" type="email" class="form-control login-form-email" v-model="email" required
                                   autofocus autocomplete="off">

                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <input id="password" type="password" class="form-control" v-model="password"
                                   required autocomplete="off">

                    </div>

                    <div class="form-group row mb-0">

                            <button type="submit" class="btn btn-primary" @click="handleLogin">
                                Login
                            </button>


                            <button type="submit" class="btn btn-primary" @click="navigateToRegister">
                                Create new account
                            </button>

                    </div>
                </div>
            </div>
            <div v-else>
                <div class='login-form'>

                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label text-md-right">Name</label>
                        <input id="name" type="email" class="form-control" v-model="name" required
                                   autofocus autocomplete="off">
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                        <input id="email" type="email" class="form-control login-form-email" v-model="email" required
                                   autofocus autocomplete="off">
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <input id="password" type="password" class="form-control" v-model="password"
                                   required autocomplete="off">
                    </div>

                    <div class="form-group row mb-0">

                            <button type="submit" class="btn btn-primary" @click="handleRegisterAccount">
                                Register account
                            </button>


                            <button type="submit" class="btn btn-primary" @click="navigateToLogin">
                                Login
                            </button>

                    </div>
                </div>
            </div>
        </ul>

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
            <div v-else>
                <h5>No products in cart!</h5>
            </div>
        </ul>
    </div>
</template>
<script>

import cartStore from '../store/modules/cart.js';
import productStore from '../store/modules/products.js';
import axios from 'axios'
import 'materialize-css';
import 'materialize-css/dist/css/materialize.css'
import M from 'materialize-css/dist/js/materialize.min.js'

const searchUrl = 'http://localhost:8000/api/search';

export default {
  components: {

  },
  computed: {
        cartItemCountVuex () {
            return cartStore.state.cartItemCount
        },
        cartItemsVuex () {
            if (cartStore.state.cartItems == null) {
                return 0;
            }
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
        name: "",
        email: "",
        password: "",
        error: null,
        isLogin: true,
        loggedInUser: "",
        isLoggedIn: false,
    }
  },
  methods: {
    navigateToLogin() {
        this.isLogin = true;
    },
    navigateToRegister() {
        this.isLogin = false;
    },
    logout(e) {
        console.log('ss')
        e.preventDefault()
            axios.post('http://localhost:8000/api/logout')
                .then(response => {
                    if (response.data.success) {
                        this.isLogin = true;
                        this.loggedInUser = '';
                        this.isLoggedIn = false;
                        setTimeout(function(){ 
                            const options = {
                                closeOnClick: false,
                                coverTrigger: false,
                                autoTrigger: false
                            };

                            var elems = document.querySelectorAll('.dropdown-trigger1');
                            M.Dropdown.init(elems, options);
                            var elems2 = document.querySelectorAll('.dropdown-trigger2');
                            M.Dropdown.init(elems2, options);

                        }, 1000);
                        axios.get('http://localhost:8000/api/getCartProducts')
                        .then((response) => {
                            console.log(response);
                            cartStore.commit('setAllCartItems', response.data.cartData);
                            cartStore.commit('setCurrentCartItemCount', response.data.totalQuantity);
                            cartStore.commit('setCurrentTotalPrice', response.data.totalPrice);
                        }, (error) => {
                            console.log(error);
                        });

                    } else {
                        console.log(response)
                    }
                })
                .catch(function (error) {
                    console.error(error);
                });
        
    },

    handleLogin(e) {
        e.preventDefault()
        if (this.password.length > 0) {

                                    axios.get('http://localhost:8000/sanctum/csrf-cookie').then(response => {
    console.log(response);

                axios.post('http://localhost:8000/api/login', {
                    email: this.email,
                    password: this.password
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data) {
                            axios.get('http://localhost:8000/api/user').then((response) => {
                                
                                if(response.data.name) {
                                    this.isLoggedIn = true;
                                    this.loggedInUser = response.data.name;
                                    this.email = '';
                                    this.password = '';

                                    const options = {
                                            closeOnClick: false,
                                            coverTrigger: false,
                                            autoTrigger: false
                                        };

                                            var elems = document.querySelectorAll('.dropdown-trigger1');
                                            M.Dropdown.init(elems, options);
                                            var elems2 = document.querySelectorAll('.dropdown-trigger2');
                                            M.Dropdown.init(elems2, options);

                                }
                            })
                            
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            });
        }
    },
    handleRegisterAccount(e) {
        e.preventDefault()
        if (this.password.length > 0) {
                axios.post('http://localhost:8000/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                })

                    .then(response => {
                        if (response.data.success) {
                            console.log("REGISTERED ACCOUNT");
                            // window.location.href = "/login"
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
        }
    },
    getImgUrl: function (imagePath) {
        console.log("IMG", imagePath);
        return require('@/assets' + imagePath);
    },
    checkForm: function (e) {
        e.preventDefault();
        productStore.state.currentProducts = [];

        axios.post(searchUrl + "?q=" + this.q)
        .then(response => {
            productStore.commit('populateProducts', response.data);
        });
      
    },

    clearCart: function() {
        axios.get('http://localhost:8000/api/clearCartProducts')
        .then(() => {
            cartStore.commit('RESET_MODULE')
        }, (error) => {
            console.log(error);
        });       
    },

    manageProductQuantity: function(currentCartItems) {
        axios.post("http://localhost:8000/api/manageProductQuantity", {
            products : JSON.stringify(currentCartItems)
        })
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
        
    },

    created: function () {

        axios.get('http://localhost:8000/api/getCartProducts')
        .then((response) => {
            console.log(response);
            cartStore.commit('setAllCartItems', response.data.cartData);
            cartStore.commit('setCurrentCartItemCount', response.data.totalQuantity);
            cartStore.commit('setCurrentTotalPrice', response.data.totalPrice);
        }, (error) => {
            console.log(error);
        });
        const options = {
            closeOnClick: false,
            coverTrigger: false,
            autoTrigger: false
        };
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger1');
            M.Dropdown.init(elems, options);
            var elems2 = document.querySelectorAll('.dropdown-trigger2');
            M.Dropdown.init(elems2, options);
        });
        axios.get('http://localhost:8000/api/user').then((response) => {
            if (response.data.name) {
                this.isLoggedIn = true;
                this.loggedInUser = response.data.name;    
            }
        })
    }
};
</script>