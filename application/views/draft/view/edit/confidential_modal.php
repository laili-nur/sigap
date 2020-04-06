<div
    class="modal fade"
    id="edit-confidential"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg modal-dialog-overflow"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Catatan Confidential</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    Catatan dibawah ini tidak dapat dilihat oleh penulis.
                </div>
                <?= form_open(); ?>
                <fieldset>
                    <div class="form-group">
                        <label
                            for="cecon"
                            class="font-weight-bold"
                        >Catatan Editor</label>
                        <?php
                        $optionscecon = array(
                            'name'  => 'edit_notes_confidential',
                            'class' => 'form-control summernote-basic',
                            'id'    => 'cecon',
                            'rows'  => '6',
                            'value' => $input->edit_notes_confidential,
                        );
                        if ($level != 'editor') {
                            echo '<div class="font-italic">' . nl2br($input->edit_notes_confidential) . '</div>';
                        } else {
                            echo form_textarea($optionscecon);
                        }
                        ?>
                    </div>
                </fieldset>
            </div>
            <?php if ($level == 'editor') : ?>
                <div class="modal-footer">
                    <button
                        class="btn btn-primary ml-auto"
                        type="submit"
                        value="Submit"
                        id="btn-submit-edit-confidential"
                    >Submit</button>
                    <button
                        type="button"
                        class="btn btn-light"
                        data-dismiss="modal"
                    >Close</button>
                </div>
            <?php endif; ?>
            <?= form_close(); ?>
        </div>
    </div>
</div>
