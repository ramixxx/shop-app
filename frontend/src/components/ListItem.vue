<template>
<div class="listItemComponent">
    
    <li v-on:click="active = !active" class="listItem"><a href="#" >
      <font-awesome-icon :icon=iconName size="lg"/>   {{itemName}}</a>
    </li>
    <div class="list-opened" v-if="active">
        <div v-for="(item) in items" :key="item.id">
            <li v-on:click="searchType(item.name)"><a href="#"> {{item.name}}</a></li>
        </div>
    </div>
</div>
</template>


<script>

import axios from 'axios'
import productStore from '../store/modules/products.js';

export default {
  data() {
    return {active:false}
  },
  computed: {

  },
  props: ['iconName', 'itemName', 'items'],
  methods:{
    searchType(type) {
        // productStore.state.currentProducts = [];
        productStore.commit('resultStatus', 'finding');
        const searchUrl = 'http://localhost:8000/api/searchType';
        axios.post(searchUrl + "?q=" + type)
        .then(response => {
            if (response.data.length == 0) {
                productStore.commit('resultStatus', 'nothing');
            } else {
                productStore.commit('resultStatus', 'result');
                productStore.commit('populateProducts', response.data);
            }
            
        });
    }
  },

  mounted() {

  }
};
</script>