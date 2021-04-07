<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <script src="{{asset('js/materialize.min.js')}}"></script>
        
    </head>
    <body class="antialiased">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Logo</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li>
                     <span class="new badge cart-item-badge" id="cart-item-badge" data-badge-caption=""></span>
                        <a href="#" class="dropdown-trigger" data-target="dropdown1">
                            <i class="large material-icons">shopping_cart</i>
                        </a>
                </li>
                <!-- <li><a href="badges.html">Components</a></li>
                <li><a href="collapsible.html">JavaScript</a></li> -->
            </ul>
            </div>
        </nav>

        <ul id='dropdown1' class='dropdown-content'>
          
        </ul>

        <div class="row">
            <div class="col s12 m4 l2"><p>s12 m4</p></div>
            <div class="col s12 m4 l8 center-align">
                @foreach ($allProducts->splitIn(3) as $set)
                    <div class="row">
                        @foreach ($set as $product)
                            <div class="col s12 m6 l3">
                                <div class="card large">
                                    <div class="card-image">
                                        <span class="helper"></span>
                                        <img src="{{url($product->image_path)}}" class="product-image">
                                        <span class="product-name" style="width:100%; background: rgba(0, 0, 0, 0.5);">{{ $product->name }} - {{ $product->price }}</span>
                                    </div>
                                    <div class="card-content">
                                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively.</p>
                                    </div>
                                    <div class="product-action-div">
                                        <div class="buttons">
                                            <a class="waves-effect waves-light btn-small buy-button">Buy</a>
                                            <a class="waves-effect waves-light btn-small add-to-cart-button" id="addToCart" onclick="addToCart('{{ $product }}')">Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach    
                    </div>
                @endforeach
            </div>
            <div class="col s12 m4 l2"><p>s12 m4</p></div>
        </div>
    </body>
</html>

<script>
    
    $( document ).ready(function() {
        $('.dropdown-trigger').dropdown({

            onOpenStart: function() {
                $.ajax({
                    method:"GET",
                    url:'/getCartProducts',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success:function(response){
                        $('#dropdown1').html(response);
                        var instance = M.Dropdown.getInstance($('.dropdown-trigger').dropdown());
                        instance.open();
                    }
                });
            },
            onCloseStart: function() {
                $.ajax({
                    method:"GET",
                    url:'/getCartProducts',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success:function(response){
                        $('#dropdown1').html(response);
                    }
                });
            }
        });

        let text = "{{ Session::get('cartItemCount')}}";
        if (text == '') {
            var element = document.getElementById("cart-item-badge");
            element.classList.remove("cart-item-badge");
            element.classList.remove("badge");
            element.classList.remove("new");
        } else {
            $('.cart-item-badge').text(text);
        }
    });




    function addToCart($product) {
        $.ajax({
            method:"POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "product": $product
            },
            url:'/addProductToCart',
            success:function(response){
                var element = document.getElementById("cart-item-badge");
                element.classList.add("cart-item-badge");
                element.classList.add("badge");
                element.classList.add("new");
                element.style.display = 'block';
                $('.cart-item-badge').text(response);
                $.ajax({
                    method:"GET",
                    url:'/getCartProducts',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success:function(response){
                        $('#dropdown1').html(response);
                    }
                });
            }
        });
    }
</script>
