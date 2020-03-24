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
                <h5
                    class="modal-title"
                    id="modal-title-<?= $progress ?>"
                >Deadline <?= $progress ?></h5>
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
                            />
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    id="btn-submit-deadline"
                    class="btn btn-primary"
                    type="button"
                >Submit</button>
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // memanggil flatpickr
    init_flatpickr_modal()

    // contoh progress = 'review','edit','layout','proofread','print'
    var progress = "<?= $progress ?>"
    // identifier khusus untuk progress review
    // menandakan review1_deadline atau review2_deadline
    // selain pada progress review maka = edit_deadline, layout_deadline
    let identifier;

    // menandakan review1 dan review2
    $(`#${progress}-progress-wrapper`).on('click', `#btn-modal-deadline-${progress}`, function() {
        const getIdentifier = $(this).data('identifier');
        identifier = $(this).data('identifier') ? `${getIdentifier}_deadline` : `${progress}_deadline`

        // ubah title modal deadline
        if (getIdentifier == 'review1') {
            $(`#modal-title-${progress}`).html('Deadline reviewer 1')
        } else if (getIdentifier == 'review2') {
            $(`#modal-title-${progress}`).html('Deadline reviewer 2')
        } else {
            $(`#modal-title-${progress}`).html(`Deadline ${progress}`)
        }

        // cari tanggal untuk repopulate form
        let date;
        if (progress == 'review' && getIdentifier == 'review1') {
            date = '<?= $input->review1_deadline ?>'
        } else if (progress == 'review' && getIdentifier == 'review2') {
            date = '<?= $input->review2_deadline ?>'
        } else {
            date = null
        }

        // populate flatpickr dari data server
        document.querySelector(`#${progress}_deadline`)._flatpickr.setDate(date);
    })

    // submit deadline
    $(`#${progress}-progress-wrapper`).on('click', `#btn-submit-deadline`, function() {
        const $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        const draft_id = $('[name=draft_id]').val();
        window[identifier] = $(`[name=${progress}_deadline]`).val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draft_id,
            // datatype: "JSON",
            data: {
                [identifier]: window[identifier],
            },
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                location.reload()
            },
        });
    });
})
</script>