<div class="border-start p-2 my-4">
    <div class="d-flex gap-4 event_comment_entry">
        <div class="col-3">
            @include('partials.users.smallCard', ['user' => $comment->author])
        </div>
        <div class="col">
            {{$comment->body}}
        </div>
    </div>
</div>
