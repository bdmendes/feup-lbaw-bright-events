<div class="border p-3 event-comment {{ $comment->parent == null ? 'event_parent_comment' : '' }}"
    id="event_comment_{{ $comment->id }}">
    <div class="d-flex gap-4 justify-content-between">
        <div class="col-auto">
            <div>
                @include('partials.users.smallCard', ['user' => $comment->author])
            </div>
        </div>
        @if (Auth::check() && Auth::id() != $comment->commenter_id && !isset($is_report))
            <div class="col-auto align-self-end text-decoration-none d-flex flex-column align-items-center" onclick="getReportModal('comment', {{ $comment->id }});" type="button">
                <i class="bi bi-exclamation-triangle"></i>
                <p>Report user</p>
            </div>
        @endif
    </div>

    <div class="col comment-body my-4">
            {{ $comment->body }}
        </div>

        <div class="mt-3 d-flex align-items-center gap-3">
            @if ($comment->parent == null)
                @if (Auth::check() && !Auth::user()->is_admin)
                <button onclick="switchCommentReplyAreaDisplay({{ $comment->id }});" class="px-3 m-0 btn btn-custom">
                    Reply
                </button>
            @endif
            <span class="span-btn d-flex flex-colum align-items-center" style="cursor:pointer">
                <span onclick="switchCommentReplyAreaDisplay({{ $comment->id }});" id="comment_{{ $comment->id }}_reply_count" style="border-bottom: 1px solid black">
                    Replies
                </span>
            </span>
            @endif
            <div class="d-flex justify-content-between align-items-center gap-4 flex-grow-1">
                {{ $comment->date->diffForHumans() }}
                @if (Auth::check() && Auth::id() == $comment->commenter_id)
                    <div class="col-auto">
                        <button
                            onclick="deleteComment({{ $comment->event_id }},{{ $comment->id }},{{ $comment->parent_id }});"
                            id="comment_{{ $comment->id }}_delete_btn" type="button" class="btn btn-custom m-0 p-2">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>

    @if ($comment->parent == null)
    <div id="comment_{{ $comment->id }}_reply_area" class="mt-4" style="margin-left: 5%; display: none;">
        <div id="comment_{{ $comment->id }}_replies" class="gap-2 d-flex flex-column">
            @include('partials.events.commentList', ['comments' => $comment->children()->getQuery()->orderBy('date','desc')->get()])
        </div>
            @if (Auth::check() && !Auth::user()->is_admin)
                <form class="mt-2 mb-2 d-flex gap-2 align-items-center justify-content-center">
                    <input class="input" type="text" id="comment_{{ $comment->id }}_reply_body" name="body"
                        placeholder="Write a reply...">
                    <button id="submit_comment_button" class="btn btn-custom"  type="button" onclick="submitReply({{ $comment->id }});">
                        Submit
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>
