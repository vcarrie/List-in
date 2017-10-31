<!doctype html>
<html class="no-js" lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>List'In - @yield('title')</title>

        <link rel="author" type="text/plain" href="humans.txt" />
        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <link rel="icon" type="image/png" href="favicon.png">

        <link rel="stylesheet" href="css/all.css"/>
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <div class="container-fluid">

            @include('include.header')

            <main class="row">
                @yield('main')
            </main>

            @include('include.footer')

        </div>

        <script type="text/javascript" src="js/all.js"></script>
    </body>
</html>
