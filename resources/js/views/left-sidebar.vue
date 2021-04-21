<template>
    <div>
        <ul id="slide-out-left" class="sidenav sidenav-left">
            <li><a href="#" class="dropdown-trigger8" data-target="dropdown-electronics1"><i class="material-icons">computer</i>Computers</a></li>
            <li><div class="divider"></div></li>
            <li><a href="#" class="dropdown-trigger9" data-target="dropdown-electronics2"><i class="material-icons">phone_iphone</i>Phones</a></li>
            <li><div class="divider"></div></li>
        </ul>

        

        

        <ul id='dropdown-electronics1' class='dropdown-content dropdown-content-menu'>
            <li><a href="#!">two</a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a href="#!">three</a></li>
            <li><a href="#!">four</a></li>
            <li><a href="#!">five</a></li>
        </ul>

        <ul id='dropdown-electronics2' class='dropdown-content dropdown-content-menu'>
            <li><a href="#!">Android</a></li>
            <li>
                <a href="#" class="dropdown-trigger10" data-target="dropdown-electronics3">Iphone</a>
            </li>
        </ul>

        <ul id='dropdown-electronics3' class='dropdown-content dropdown-content-iphone'>
            <li><a href="#!">X</a></li>
            <li><a href="#!">S6</a></li>
            <li><a href="#!">12 Pro</a></li>
            <li><a href="#!">12</a></li>
            <li><a href="#!">SE</a></li>
            <li><a href="#!">11 Pro Max</a></li>
        </ul>
    </div>
</template>
<script>
import store from '../store/index.js';

export default {
    components: {

    },
    
    computed: {

    },
    props: [
    
    ],
    methods: {

    },
    mounted() {
        $('.dropdown-trigger8').dropdown({
            closeOnClick: false,
            hover: false
        });

        $('.dropdown-trigger9').dropdown({
            closeOnClick: false,
            hover: false
        });

        $('.dropdown-trigger10').dropdown({
            closeOnClick: false,
            hover: true
        });
    }
};
</script>