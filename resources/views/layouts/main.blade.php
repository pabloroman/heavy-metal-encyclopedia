<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@if(!Request::is('/'))@yield('title') | @endif{{ config('app.name') }}</title>

    <meta name="google-site-verification" content="3C9_Diq982XSryTiVet-CVSVxqSyW-0PXU6dWogpyec" />
    <meta name="referrer" content="no-referrer-when-downgrade">
    <meta name="robots" content="all">
    <meta name="keywords" content="metal, heavy metal">
    <meta name="description" content="@yield('description')">
    <link rel="canonical" href="{{ URL::current() }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <link rel="dns-prefetch" href="//s3.amazonaws.com/">
</head>

<body class="@yield('body-class')">

    @section('navigation')
    @show

    <div class="content">
        @yield('content')

    @section('footer')
    @show

    <div class="container">
        @include('layouts._footer')
    </div>

    </div>

    <script src="{{ mix('js/app.js') }}"></script>

    <!-- Scripts -->
    @yield('footer-scripts')

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-8049835-4', 'auto');
        ga('send', 'pageview');
    </script>

</body>

</html>