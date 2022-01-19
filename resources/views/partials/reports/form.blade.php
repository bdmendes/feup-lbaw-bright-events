<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">New report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="report-form" method="POST">
                    @csrf
                    <input id="report-type" type="hidden" name="type">
                    <input id="report-id" type="hidden" name="id">


                    <label for="form-select">Motive:</label>
                    <select class="form-select" aria-label="Select report motive">
                        <option selected>Choose one from below</option>
                        <option value="Sexual harassment">Sexual harassment</option>
                        <option value="Violence or bodily harm">Violence or bodily harm</option>
                        <option value="Nudity or explicit content">Nudity or explicit content</option>
                        <option value="Hate speech">Hate speech</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="form-description">Description:</label>
                    <textarea id="form-description" name="description" rows="5"
                        cols="33">Tell us in detail what is wrong.</textarea>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="report-submit" type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
