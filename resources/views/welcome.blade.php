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
        <div id="app">
            <app :allProducts='{{ json_encode($allProducts) }}'></app>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>

<script>
    $( document ).ready(function() {
        $('.sidenav').sidenav();
    });
</script>
