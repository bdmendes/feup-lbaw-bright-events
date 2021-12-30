<a href=" {{ route('event', ['id' => $event->id]) }} "
    class="container-fluid py-2 my-4 text-dark border rounded row align-items-start"
    style="text-decoration:none;padding:0;">
    <div class="col-4">
        <img class="rounded"
            src="https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F203018239%2F227342121523%2F1%2Foriginal.20211220-101832?w=800&auto=format%2Ccompress&q=75&sharp=10&rect=0%2C24%2C1002%2C501&s=ac1247a6305dd65956da5d4e85685c75"
            alt="Card image cap" style="object-fit:cover;">
    </div>
    <div class="col-8 pt-2">
        <p class="h2">{{ $event->title }}</p>
        <p class="h4">{{ date('d-m-Y', strtotime($event->date)) }} @ {{ $event->location->city }},
            {{ $event->location->country }} </p>
        <div class="pt-3 d-flex justify-content-start">
            <div style="padding-right: 1em;">
                <img class="rounded-circle" style="width:5ch; height:5ch; object-fit:cover;"
                    src="https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F203018239%2F227342121523%2F1%2Foriginal.20211220-101832?w=800&auto=format%2Ccompress&q=75&sharp=10&rect=0%2C24%2C1002%2C501&s=ac1247a6305dd65956da5d4e85685c75"
                    alt="Card image cap">
            </div>
            <div class="align-self-center">
                <div> {{ $event->organizer->name }} </div>
            </div>
        </div>
    </div>
</a>
