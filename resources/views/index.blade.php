<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style href="{{asset('css/app.css')}}" ></style>
</head>
<body>
<div id="app">

    <app/>
</div>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
