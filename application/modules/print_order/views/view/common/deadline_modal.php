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
                                value="<?= $print_order->{$progress . '_deadline'} ?>"
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
    const progress = '<?= $progress ?>'
    const print_order_id = '<?= $print_order->print_order_id ?>'

    initFlatpickrModal()

    // ketika modal tampil, pasang listener
    $(`#${progress}-progress-wrapper`).on('shown.bs.modal', `#modal-deadline-${progress}`, function() {
        // reload ketika modal diclose
        $(`#modal-deadline-${progress}`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $(`#${progress}-progress-wrapper`).load(` #${progress}-progress`, function() {
                // reinitiate flatpickr modal after load
                initFlatpickrModal()
            });
        })
    })

    // submit deadline
    $(`#${progress}-progress-wrapper`).on('click', `#btn-submit-deadline-${progress}`, function() {
        const $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");

        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/api_update/'); ?>" + print_order_id,
            data: {
                [`${progress}_deadline`]: $(`#${progress}_deadline`).val(),
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $this.removeAttr("disabled").html("Submit");
                // trik mengatasi close modal, ketika file di load ulang
                // $(`#modal-deadline-${progress}`).modal('hide');
                // $('body').removeClass('modal-open');
                // $('.modal-backdrop').remove();
            },
        });
    });
})
</script>
