<template>

        <ul id="slide-out-left" class="sidenav sidenav-left">
            <div class="sidebar-content-margin">
                <ListItem v-for="item in items" :key="item.id" :iconName=item.icon_name :itemName=item.item_name :id=item.id :items=item.sidebar_child_item />
            </div>
        </ul>


</template>
<script>

import 'materialize-css';
import 'materialize-css/dist/css/materialize.css'
import ListItem from './ListItem.vue';
import axios from 'axios'

export default {
    name: 'LeftSidebar',
    data() {
        return {
            items: []
        }
    },
    components: {
        ListItem
    },
    
    computed: {

    },
    props: [
    
    ],
    methods: {
        mouseOver: function(){
            alert("EEE");
            // this.active = !this.active;   
        }
    },
    mounted() {
        const searchUrl = 'http://localhost:8000/api/sidebarLinks';
        axios.get(searchUrl)
        .then(response => {
            this.items = response.data;
            
        });
    }
};
</script>