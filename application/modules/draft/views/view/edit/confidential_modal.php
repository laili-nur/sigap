<?php $level = check_level() ?>
<div
    class="modal fade"
    id="modal-edit-confidential"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-edit-confidential"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg modal-dialog-overflow"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Catatan Confidential</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="alert alert-warning">
                Catatan dibawah ini tidak dapat dilihat oleh penulis.
            </div>
            <div class="modal-body">
                <fieldset>
                    <!-- CATATAN CONFIDENTIAL EDITOR UNTUK ADMIN -->
                    <div class="form-group">
                        <label
                            for="confidential-edit-notes"
                            class="font-weight-bold"
                        >Catatan Editor</label>
                        <?php
                        if (!is_admin() && $level != 'editor') {
                            echo "<div class='font-italic' id='confidential-edit-notes'>" . $input->edit_notes_confidential . "</div>";
                        } else {
                            echo form_textarea([
                                'name'  => "confidential-edit-notes",
                                'class' => 'form-control summernote-basic',
                                'id'    => "confidential-edit-notes",
                                'rows'  => '6',
                                'value' => $input->edit_notes_confidential

                            ]);
                        }
                        ?>
                    </div>
                </fieldset>
            </div>
            <?php if ($level == 'editor' || is_admin()) : ?>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light ml-auto"
                        data-dismiss="modal"
                    >Close</button>
                    <button
                        class="btn btn-primary"
                        type="button"
                        id="btn-submit-edit-confidential"
                    >Submit</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    const draftId = $('[name=draft_id]').val();

    // submit progress edit
    $('#edit-progress-wrapper').on('click', `#btn-submit-edit-confidential`, function() {
        const $this = $(this);

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draftId,
            datatype: "JSON",
            data: {
                [`edit_notes_confidential`]: $(`#confidential-edit-notes`).val(),
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
            }
        });
    });

})
</script>
