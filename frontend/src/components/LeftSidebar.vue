<template>

        <ul id="slide-out-left" class="sidenav sidenav-left">
            <div class="sidebar-content-margin">
                <ListItem v-for="item in items" :key="item.id" :iconName=item.iconName :itemName=item.itemName :id=item.id :items=item.items />
                <!-- <ListItem iconName="mobile-alt" itemName="Phones" id="list2" items=this.items /> -->
                <!-- <li @mouseover="active = !active"><a href="#" class="dropdown-trigger8" data-target="dropdown-electronics1">
                    <font-awesome-icon icon="laptop" size="lg"/>   Computers</a>
                </li>
                <div class="computers-opened" v-if="active">
                    hello222
                </div>
                <li><div class="divider"></div></li>
                <li><a href="#" class="dropdown-trigger9" data-target="dropdown-electronics2"><font-awesome-icon icon="mobile-alt" size="lg"/>  Phones</a></li>
                <div class="phones-opened">

                </div>
                <li><div class="divider"></div></li> -->
            </div>
        </ul>


</template>
<script>

import 'materialize-css';
import 'materialize-css/dist/css/materialize.css'
import ListItem from './ListItem.vue';

export default {
    name: 'LeftSidebar',
    data() {
        return {
            items: [
                {id:1, iconName:"laptop", itemName:"Computers", items:[{id:1, name:"Desktops - AI Dev Boxes"}, {id:2, name:"Desktops - Gaming"},{id:3, name:"Desktops - Home/Office"}] },
                {id:2, iconName:"mobile-alt", itemName:"Phones", items:[{id:1, name:"Apple"}, {id:2, name:"Android"}] },
                {id:3, iconName:"microchip", itemName:"Components", items:[{id:1, name:"Motherboards"}, {id:2, name:"Cases"}, {id:3, name:"Graphics card"}, {id:4, name:"Memory - RAM"}, {id:5, name:"Coolers"}, {id:6, name:"Processors"}] }
                
            ]
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

    }
};
</script>