<ul id="slide-out" class="sidenav">
	<li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>
	<li><a href="#!">Second Link</a></li>
	<li><div class="divider"></div></li>
</ul>

<script>
	window.onscroll = function (e) {
        console.log(window.scrollY);
        if (window.scrollY > 64) {
            $('#slide-out').css('margin-top', 0);
        } else {
            $('#slide-out').css('margin-top', 64 - window.scrollY);
        }
    };
</script>