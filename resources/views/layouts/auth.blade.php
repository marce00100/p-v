<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>Pivot V</title>

       <link rel="stylesheet" href="{{ asset('css/style-login.css') }}">
    </head>
    <body>
        @yield('content')


        {{-- <script src='http://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js'></script> --}}
        <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script  src="{{ asset('js/login.js') }}"></script>
        <script type="text/javascript">
          $(document).ready(function(){
             $(document).ready(function () {
                   $('#login-button').fadeIn(2000);
             });
          });
        </script>
    </body>
</html>
