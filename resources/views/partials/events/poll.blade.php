<div class="accordion-item" id="poll_{{ $poll->id }}_entry">
    <h2 class="accordion-header" id="poll_{{ $poll->id }}_item_header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#poll_{{ $poll->id }}_item_header_item_body" aria-expanded="false"
            aria-controls="poll_{{ $poll->id }}_item_header_item_body">
            <h3>
                {{ $poll->title }}
            </h3>
        </button>
    </h2>
    <div id="poll_{{ $poll->id }}_item_header_item_body" class="accordion-collapse collapse"
        aria-labelledby="poll_{{ $poll->id }}_item">
        <div class="accordion-body">
            <div class="p-2">
                @if (Auth::check() && Auth::id() == $poll->event->organizer_id)
                    <div style="float:right;">
                        <button onclick="deletePoll({{ $poll->id }});" id="poll_{{ $poll->id }}_delete_btn"
                            type="button" class="m-0 p-2"><i class="bi bi-trash"></i></button>
                    </div>
                @endif
                <h4>{{ $poll->description }}</h4>
                <form class="mt-4 mb-0 p-0" autocomplete="off">
                    @foreach ($poll->options as $option)
                        <input type="checkbox" name="poll_{{ $poll->id }}_option"
                            id="poll_{{ $poll->id }}_option_{{ $option->id }}"
                            {{ !$can_vote ? 'disabled' : '' }}
                            {{ Auth::check() && $option->hasBeenSelectedBy(Auth::id()) ? 'checked' : '' }}
                            onchange="changePollVote({{ $poll->id }}, {{ $option->id }});">
                        <label class="ms-2" for="poll_{{ $poll->id }}_option_{{ $option->id }}"
                            style="font-weight: normal;">
                            {{ $option->name }}
                        </label>
                        <span class="ms-4 text-muted">
                            <span id="option_{{ $option->id }}_voter_count"> {{ $option->voters->count() }}</span>
                            voters
                        </span>
                        <br>
                    @endforeach
                    @if (!$can_vote)
                        @if(Auth::id() != $poll->event->organizer->id)
                            <small class="text-muted mt-2">You must attend this event to vote in a poll</small>

                        @endif
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
