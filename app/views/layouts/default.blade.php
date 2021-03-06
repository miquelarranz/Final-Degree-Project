<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Events project</title>
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="/css/style.css"/>
        <link href="/css/simple-sidebar.css" rel="stylesheet">
        <link href="/css/jquery.datetimepicker.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <script src="https://apis.google.com/js/platform.js" async defer>
            {lang: 'en'}
        </script>
    </head>
    <body>

        @include('layouts.partials.nav')
        <div class="container">
            @include('flash::message')

            @yield('content')
        </div>

        <script src="/scripts/jquery.min.js"></script>
        <script src="/scripts/bootstrap.min.js"></script>
        <script src="/scripts/jquery.datetimepicker.js"></script>
        <script src="/scripts/scripts.js"></script>
        <script type="text/javascript"
              src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAmQxRfEPNPtJbz_hTyU_tkQ3vcZTbC8X0&sensor=TRUE">
        </script>
        @yield('scripts')
    </body>
</html>