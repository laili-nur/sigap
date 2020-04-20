<div
    class="modal fade"
    id="modal-deadline-<?= $progress ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-deadline-<?= $progress ?>"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-<?= $progress ?>">Deadline <?= $progress ?></h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset>
                    <div class="form-group">
                        <div>
                            <input
                                type="text"
                                name="<?= "{$progress}_deadline" ?>"
                                id="<?= "{$progress}_deadline" ?>"
                                class="form-control flatpickr_modal d-none"
                                value="<?= $input->{$progress . '_deadline'} ?>"
                            />
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
                <button
                    id="btn-submit-deadline-<?= $progress ?>"
                    class="btn btn-primary"
                    type="button"
                >Submit</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // contoh progress = 'review1','review2,'edit','layout','proofread','print'
    const progress = "<?= $progress == 'review1' || $progress == 'review2' ? 'review' : $progress ?>"
    // identifier khusus untuk progress review
    // selain progress review, identifier == progress
    const identifier = '<?= $progress ?>'

    // reload segmen ketika modal diclose
    $(`#${progress}-progress-wrapper`).on('shown.bs.modal', `#modal-deadline-${identifier}`, function() {
        // reload ketika modal diclose
        $(`#modal-deadline-${identifier}`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $(`#${progress}-progress-wrapper`).load(` #${progress}-progress`, function() {
                // reinitiate flatpickr modal after load
                initFlatpickrModal()
            });
        })
    })

    // submit deadline
    $(`#${progress}-progress-wrapper`).on('click', `#btn-submit-deadline-${identifier}`, function() {
        const $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        const draft_id = $('[name=draft_id]').val()

        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_update_draft/'); ?>" + draft_id,
            data: {
                [`${identifier}_deadline`]: $(`#${identifier}_deadline`).val(),
            },
            success: function(res) {
                console.log(res);
                showToast(true, res.data);
            },
            error: function(err) {
                console.log(err);
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $this.removeAttr("disabled").html("Submit");
                // trik mengatasi close modal, ketika file di load ulang
                // $(`#modal-deadline-${identifier}`).modal('hide');
                // $('body').removeClass('modal-open');
                // $('.modal-backdrop').remove();
            },
        });
    });
})
</script>
