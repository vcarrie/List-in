<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>List'In - @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/plain" rel="author" href="humans.txt"/>
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Placer favicon.ico à la racine -->

    <link rel="stylesheet" href="../../../public/css/app.css"/>
</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->

<div class="container-fluid">
    @include('layouts.header')
    @yield('content')
    @include('layouts.footer')
</div>

<script type="text/javascript" src="../../../public/js/app.js"></script>
</body>
</html>
