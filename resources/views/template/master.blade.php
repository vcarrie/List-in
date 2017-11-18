<!doctype html>
<html class="no-js" lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>List'In - @yield('title')</title>

    <link rel="author" type="text/plain" href="../../../public/humans.txt"/>
    <link rel="manifest" href="../../../public/site.webmanifest">
    <link rel="apple-touch-icon" href="../../../public/icon.png">
    <link rel="icon" type="image/png" href="../../../public/favicon.ico">

    <link rel="stylesheet" href="../../../public/css/all.css"/>
</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->

<div class="container-fluid">

    <header class="row">
        @include('include.header')
    </header>

    <main class="row">
        @yield('main')
    </main>

    <footer class="row">
        @include('include.footer')
    </footer>
</div>
<script type="text/javascript" src="../../../public/js/all.js"></script>
<script type="text/javascript" src="../../../public/js/article-search.js"></script>
</body>
</html>
