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

                    <label for="report-form-select">Motive:</label>
                    <select id="report-form-select" class="form-select form-control" aria-label="Select report motive"
                        name="motive" required>
                        <option value="placeholder" disabled selected>Choose one from below</option>
                        <option value="Sexual harassment">Sexual harassment</option>
                        <option value="Violence or bodily harm">Violence or bodily harm</option>
                        <option value="Nudity or explicit content">Nudity or explicit content</option>
                        <option value="Hate speech">Hate speech</option>
                        <option value="Other">Other</option>
                    </select>

                    <label for="report-form-description">Description:</label>
                    <textarea class="form-control" id="report-form-description" name="description" rows="10" cols="50"
                        placeholder="Tell us in detail what is wrong." required></textarea>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="report-submit" type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
