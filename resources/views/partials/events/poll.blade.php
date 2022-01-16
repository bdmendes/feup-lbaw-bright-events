<div class="border-start p-2 my-4">
    <h3>{{ $poll->title }}</h3>
    <h4>{{ $poll->description }}</h4>

    <form class="mt-4 mb-0 p-0" autocomplete="off">
        @foreach ($poll->options as $option)
            <input type="checkbox" name="poll_{{ $poll->id }}_option"
                id="poll_{{ $poll->id }}_option_{{ $option->id }}" {{ !Auth::check() ? 'disabled' : '' }}
                {{ Auth::check() && $option->hasBeenSelectedBy(Auth::id()) ? 'checked' : '' }}>
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
    </form>
</div>
