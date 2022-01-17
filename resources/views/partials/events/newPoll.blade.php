<form autocomplete="off" id="new_poll_form">
    <div class="form-group mb-4">
        <label for="new_poll_title">Title</label>
        <input type="text" class="form-control" id="new_poll_title" placeholder="Enter a title">
    </div>
    <div class="form-group mb-4">
        <label for="new_poll_description">Description</label>
        <textarea class="form-control" id="new_poll_description" placeholder="Enter a description" rows="3"></textarea>
    </div>
    <div class="form-group mb-4" id="new_poll_options_area">
        <label>Poll options</label>
        <input class="form-control new_poll_option" id="new_poll_option_1" placeholder="Enter option 1"
            oninput="updatePollOptionFields(1);" onclick="updatePollOptionFields(1);">
    </div>
    <button type="button" class="" onclick="submitPoll();">Submit</button>
</form>
