<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/materialize.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <script src="{{asset('js/materialize.min.js')}}"></script>
        
    </head>
    <body class="antialiased">
        @include('sidebar')

        
    <div id="app">
        <app :allProducts='{{ json_encode($allProducts) }}'></app>
    </div>
        <!-- <div class="row">
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
        </div> -->
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

<script>
    $( document ).ready(function() {
        $('.sidenav').sidenav();
    });
</script>
