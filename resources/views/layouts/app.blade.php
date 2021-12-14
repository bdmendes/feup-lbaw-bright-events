<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <nav>
        <div class="logo">
          Bright events logo
        </div>
        <div class="menuNavigation">
          <a class="button" href="{{ url('events')}}">Events </a>
          <a class="button" href="{{ url('users')}}">Users </a>
        </div>
        <div class="menuUser">
          @if (Auth::check())
          <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
          @else
          <a class="button" href="{{url('login') }}"> Sign-in </a>
          @endif
        </div>
    </nav>
      <section id="content">
        @yield('content')
      </section>

      <footer>
        <span>
          @Bright Events 2021
        </span>
        <div class="footerPages">
          <a class="button" href="{{ url('contact')}}">Contact Us </a>
          <a class="button" href="{{ url('faq')}}">FAQ </a>
          <a class="button" href="{{ url('about')}}">About </a>
        </div>
      </footer>
    </main>
  </body>
</html>
