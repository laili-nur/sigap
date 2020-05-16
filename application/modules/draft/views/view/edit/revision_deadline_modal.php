<div
    class="modal fade"
    id="edit-revisi-deadline"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deadline revisi</h5>
            </div>
            <div class="modal-body">
                <?= form_open('', ''); ?>
                <fieldset>
                    <input
                        type="hidden"
                        name="revision_id"
                        id="revision_id"
                        class="form-control"
                        value=""
                    >
                    <div class="form-group">
                        <div>
                            <?= form_input('revision_edit_start_date', '', 'class="form-control mydate_modal d-none" id="revision_edit_start_date" required=""'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <?= form_input('revision_edit_end_date', '', 'class="form-control mydate_modal d-none" id="revision_edit_end_date" required=""'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <?= form_input('revision_edit_deadline', '', 'class="form-control mydate_modal d-none" id="revision_edit_deadline" required=""'); ?>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-primary"
                    type="submit"
                    id="btn-edit-revisi-deadline"
                >Pilih</button>
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
