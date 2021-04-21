<template>
    <div>
        <ul id="slide-out-left" class="sidenav sidenav-left">
            <div class="sidebar-content-margin">
                <li>
                    TESTddd
                </li>
            </div>
        </ul>
    </div>
</template>
<script>

import 'materialize-css';
import 'materialize-css/dist/css/materialize.css'
import M from 'materialize-css/dist/js/materialize.min.js'

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
        const sidenavOptions = {
            edge: 'right'
        };
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav-left');
            M.Sidenav.init(elems, sidenavOptions);
        });
        // window.onscroll = function () {
        //     if (window.scrollY > 64) {
        //             let right = document.getElementById("slide-out-right");
        //             let left = document.getElementById("slide-out-left");
        //             right.style.marginTop = '0px';
        //             left.style.marginTop = '0px';
        // //         $('#slide-out-right').css('margin-top', 0);
        // //         $('#slide-out-left').css('margin-top', 0);
        //     } else {
        //             let right = document.getElementById("slide-out-right");
        //             let left = document.getElementById("slide-out-left");
        //             right.style.marginTop = '64px' - window.scrollY;
        //             left.style.marginTop = '64px' - window.scrollY;
        // //         $('#slide-out-right').css('margin-top', 64 - window.scrollY);
        // //         $('#slide-out-left').css('margin-top', 64 - window.scrollY);
        //     }
        // };
    }
};
</script>