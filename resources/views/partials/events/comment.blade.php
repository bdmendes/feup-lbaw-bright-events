<div class="border-start p-2 my-4 event_comment" id="event_comment_{{ $comment->id }}">
    <div class="d-flex gap-4">
        <div class="col-3">
            @include('partials.users.smallCard', ['user' => $comment->author])
        </div>
        <div class="col">
            {{ $comment->body }}
        </div>
        @if (Auth::check() && Auth::id() == $comment->commenter_id)
            <div style="margin-left: auto; padding-left: 1em;">
                <button onclick="deleteComment({{ $comment->event_id }},{{ $comment->id }});"
                    id="comment_{{ $comment->id }}_delete_btn" type="button" class="m-0 p-2"><i
                        class="bi bi-trash"></i></button>
            </div>
        @endif
    </div>
</div>
