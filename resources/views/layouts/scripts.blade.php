<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src={{ asset('js/app.js') }} defer></script>
<script type="text/javascript" src={{ asset('js/comments.js') }} defer></script>
<script type="text/javascript" src={{ asset('js/notification.js') }}></script>
<script type="text/javascript" src={{ asset('js/report.form.js') }}></script>
<script type="text/javascript" src={{ asset('js/polls.js') }}></script>
<script type="text/javascript" src={{ asset('js/style.js') }} defer></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>
<script type="text/javascript" src={{ asset('js/location.js') }}></script>

<script type="text/javascript">
    // Fix for Firefox autofocus CSS bug // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
</script>



<script src="//js.pusher.com/3.1/pusher.min.js"></script>

<script>
    let pusher = new Pusher('5aaef3148145a5edc935', {
        encrypted: true,
        cluster: 'eu'
    });

    // Subscribe to the channel we specified in our Laravel Event
    @if (Auth::check())
        let channel = pusher.subscribe("notification-received-channel-{{ Auth::user()->username }}");

        channel.bind('notification-received', function(data) {
            getNotifications(null, true);

        });
        window.addEventListener('load', getNotifications);

    @endif
</script>
