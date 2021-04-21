<template>
    <div>
        <ul id="slide-out-right" class="sidenav sidenav-right">
            <li>
                TEST
            </li>
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
        // window.onscroll = function (e) {
        //     if (window.scrollY > 64) {
        //         $('#slide-out-right').css('margin-top', 0);
        //         $('#slide-out-left').css('margin-top', 0);
        //     } else {
        //         $('#slide-out-right').css('margin-top', 64 - window.scrollY);
        //         $('#slide-out-left').css('margin-top', 64 - window.scrollY);
        //     }
        // };
    }
};
</script>