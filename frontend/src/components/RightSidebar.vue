<template>
    <div class="">
        <ul id="slide-out-right" class="sidenav sidenav-right">
            <div class="sidebar-content-margin">
            <li><a href="#" class="dropdown-trigger8" data-target="dropdown-electronics1"><font-awesome-icon icon="laptop" size="lg"/>   Computers</a></li>
            <li><div class="divider"></div></li>
            <li><a href="#" class="dropdown-trigger9" data-target="dropdown-electronics2"><font-awesome-icon icon="mobile-alt" size="lg"/>  Phones</a></li>
            <li><div class="divider"></div></li>
            </div>
        </ul>

        <ul id='dropdown-electronics1' class='dropdown-content dropdown-content-menu'>
            <div class="sidebar-content-margin">
            <li><a href="#!">two</a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a href="#!">three</a></li>
            <li><a href="#!">four</a></li>
            <li><a href="#!">five</a></li>
            </div>
        </ul>

        <ul id='dropdown-electronics2' class='dropdown-content dropdown-content-menu'>
            <div class="sidebar-content-margin">
            <li><a href="#!">Android</a></li>
            <li>
                <a href="#" class="dropdown-trigger10" data-target="dropdown-electronics3">Iphone</a>
            </li>
            </div>
        </ul>

        <ul id='dropdown-electronics3' class='dropdown-content dropdown-content-iphone'>
            <div class="sidebar-content-margin">
            <li><a href="#!">X</a></li>
            <li><a href="#!">S6</a></li>
            <li><a href="#!">12 Pro</a></li>
            <li><a href="#!">12</a></li>
            <li><a href="#!">SE</a></li>
            <li><a href="#!">11 Pro Max</a></li>
            </div>
        </ul>
    </div>
</template>
<script>

import 'materialize-css';
import 'materialize-css/dist/css/materialize.css'
import M from 'materialize-css/dist/js/materialize.min.js'

export default {
    name: 'LeftSidebar',
    components: {

    },
    
    computed: {

    },
    props: [
    
    ],
    methods: {

    },
    mounted() {
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav-right');
            M.Sidenav.init(elems);
        });

        const options = {
            closeOnClick: false,
            hover: true
        };
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger8');
            M.Dropdown.init(elems, options);
        });

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger9');
            M.Dropdown.init(elems, options);
        });

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.dropdown-trigger10');
            M.Dropdown.init(elems, options);
        });
    }
};
</script>