<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
</head>

<body class="site-body">

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

    <script src="{{ elixir('js/app.js') }}"></script>

    <!-- Scripts -->
    @yield('footer-scripts')

</body>

</html>