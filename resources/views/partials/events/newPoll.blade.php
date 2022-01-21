<form autocomplete="off" id="new_poll_form">
    <div class="mb-4">
        <h4>Title</h4>
        <input type="text" class="input" id="new_poll_title" placeholder="Enter a title">
    </div>
    <div class="mb-4">
        <h4>Description</h4>
        <textarea class="input" id="new_poll_description" placeholder="Enter a description" rows="3"></textarea>
    </div>
    <div class="mb-4 gap-2 d-flex flex-column" id="new_poll_options_area">
        <h4>Poll options</h4>
        <input type="text" class="input new_poll_option" id="new_poll_option_1" placeholder="Enter option 1"
            oninput="updatePollOptionFields(1);" onclick="updatePollOptionFields(1);">
    </div>
    <button type="button" class="btn btn-custom" onclick="submitPoll();">Submit</button>
</form>
