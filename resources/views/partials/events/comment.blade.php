<div class="border-start p-2 my-4 event_comment {{ $comment->parent == null ? 'event_parent_comment' : '' }}"
    id="event_comment_{{ $comment->id }}">
    <div class="d-flex gap-4">
        <div class="col-4 col-md-3">
            @include('partials.users.smallCard', ['user' => $comment->author])
            @if ($comment->parent == null)
                <div class="mt-3" style="display: inline-block; cursor: pointer;"
                    onclick="switchCommentReplyAreaDisplay({{ $comment->id }});">
                    @if (Auth::check() && !Auth::user()->is_admin)
                        <button class="p-0 m-0" style="height: 20px;">Reply</button>
                    @endif
                    <span class="ms-2">
                        <span id="comment_{{ $comment->id }}_reply_count">{{ $comment->children()->count() }}</span>
                        replies
                    </span>
                </div>
            @endif
        </div>
        <div class="col">
            {{ $comment->body }}
        </div>
        @if (Auth::check() && Auth::id() == $comment->commenter_id)
            <div style="margin-left: auto; padding-left: 1em;">
                <button
                    onclick="deleteComment({{ $comment->event_id }},{{ $comment->id }},{{ $comment->parent_id }});"
                    id="comment_{{ $comment->id }}_delete_btn" type="button" class="m-0 p-2"><i
                        class="bi bi-trash"></i></button>
            </div>
        @endif
        @if (Auth::check() && Auth::id() != $comment->commenter_id)
            <div class="col col-2 align-self-end">
                <a class="link-primary">
                    <span id="report_comment_{{ $comment->id }}" style="font-size: 0.9em;" type="button"
                        onclick="">Report
                        comment</span>
                </a>
            </div>
        @endif
    </div>

    @if ($comment->parent == null)
        <div id="comment_{{ $comment->id }}_reply_area" class="mt-4"
            style="margin-left: 5%; display: none;">
            @if (Auth::check() && !Auth::user()->is_admin)
                <form class="mt-4">
                    <input type="text" id="comment_{{ $comment->id }}_reply_body" name="body"
                        placeholder="What's your thought about this user's input?">
                    <button id="submit_comment_button" class="mt-2 p-0 m-0" style="height: 20px; " type="button"
                        onclick="submitReply({{ $comment->id }});">Submit</button>
                </form>
            @endif
            <div id="comment_{{ $comment->id }}_replies">
                @include('partials.events.commentList', ['comments' =>
                $comment->children()->getQuery()->orderBy('date','desc')->get()])
            </div>
        </div>
    @endif
</div>
