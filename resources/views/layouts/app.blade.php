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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/notification.js') }}></script>
    <script type="text/javascript" src={{ asset('js/comments.js') }}></script>
    <script type="text/javascript" src={{ asset('js/polls.js') }}></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>

    <script>
        var pusher = new Pusher('5aaef3148145a5edc935', {
            encrypted: true,
            cluster: 'eu'
        });

        function subscribeNotifications(user) {

        }
        // Subscribe to the channel we specified in our Laravel Event
        @if (Auth::check())
            var channel = pusher.subscribe("notification-received-channel-{{ Auth::user()->username }}");
        
            channel.bind('notification-received', function(data) {
            getNotifications(null, true);
        
            });
        
        @endif
        // Bind a function to a Event (the full Laravel class)
    </script>

</head>

<body>

    @include('layouts.navbar')

    <div class="w-100 position-relative">
        <div id="growls">

        </div>
        <section id="content">

            @yield('content')
        </section>
    </div>

    @include('layouts.footer')

    @include('layouts.scripts')

</body>

</html>
