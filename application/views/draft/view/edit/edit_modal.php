<div
    class="modal fade"
    id="edit"
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
                <h5 class="modal-title"> Progress Edit</h5>
            </div>
            <div class="modal-body">
                <p class="font-weight-bold">NASKAH</p>
                <?php if ($level == 'editor' or ($level == 'author' and $author_order == 1) or $level == 'superadmin' or $level == 'admin_penerbitan') : ?>
                    <div class="alert alert-info">Upload file naskah atau sertakan link naskah.</div>
                    <?= form_open_multipart('draft/upload_progress/' . $input->draft_id . '/edit_file', 'id="editform"'); ?>
                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                    <div class="form-group">
                        <label for="edit_file">File Naskah</label>
                        <div class="custom-file">
                            <?= form_upload('edit_file', '', 'class="custom-file-input naskah" id="edit_file"'); ?>
                            <label
                                class="custom-file-label"
                                for="edit_file"
                            >Pilih file</label>
                        </div>
                        <small class="form-text text-muted">Tipe file upload bertype : docx, doc, pdf, zip, dan rar.</small>
                    </div>
                    <div class="form-group">
                        <label for="editor_file_link">Link Naskah</label>
                        <div>
                            <?= form_input('editor_file_link', $input->editor_file_link, 'class="form-control naskah" id="editor_file_link"'); ?>
                        </div>
                        <?= form_error('editor_file_link'); ?>
                    </div>
                    <div class="form-group">
                        <button
                            class="btn btn-primary "
                            type="submit"
                            value="Submit"
                            id="btn-upload-edit"
                        ><i class="fa fa-upload"></i> Upload</button>
                    </div>
                    <?= form_close(); ?>
                <?php endif; ?>
                <div id="modal-edit">
                    <p>Last Upload :
                        <?= format_datetime($input->edit_upload_date); ?>,
                        <br> by :
                        <?= konversi_username_level($input->edit_last_upload); ?>
                        <?php if ($level != 'author' and $level != 'reviewer') : ?>
                            <em>(
                    <?= $input->edit_last_upload; ?>)</em>
                        <?php endif; ?>
                    </p>
                    <?= (!empty($input->edit_file)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->edit_file . '" href="' . base_url('draftfile/' . $input->edit_file) . '" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                    <?= (!empty($input->editor_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->editor_file_link . '" href="' . $input->editor_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                    <?= (!empty($input->editor_file_link) or !empty($input->edit_file)) ? '<button data-toggle="tooltip" data-placement="right" title="" data-original-title="hapus file" class="btn btn-danger" id="btn-delete-edit"><i class="fa fa-trash"></i></button>' : ''; ?>
                </div>
                <hr class="my-3">
                <?= form_open('', 'id="formedit"'); ?>
                <fieldset>
                    <div class="form-group">
                        <label
                            for="ce"
                            class="font-weight-bold"
                        >Catatan Editor</label>
                        <small class="text-muted" id="edit_last_notes">
                  <?= format_datetime($input->edit_notes_date); ?></small>
                        <?php
                        $optionsce = array(
                            'name'  => 'edit_notes',
                            'class' => 'form-control summernote-basic',
                            'id'    => 'ce',
                            'rows'  => '6',
                            'value' => $input->edit_notes,
                        );
                        if ($level != 'editor') {
                            echo '<div class="font-italic">' . nl2br($input->edit_notes) . '</div>';
                        } else {
                            echo form_textarea($optionsce);
                        }
                        ?>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label
                            for="cep"
                            class="font-weight-bold"
                        >Catatan Penulis</label>
                        <?php
                        $optionscep = array(
                            'name'  => 'edit_notes_author',
                            'class' => 'form-control summernote-basic',
                            'id'    => 'cep',
                            'rows'  => '6',
                            'value' => $input->edit_notes_author,
                        );
                        if ($level != 'author' or $author_order != 1) {
                            echo '<div class="font-italic">' . nl2br($input->edit_notes_author) . '</div>';
                        } else {
                            echo form_textarea($optionscep);
                        }
                        ?>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <?php if ($author_order == 1 and $level == 'author' or $level == 'editor') : ?>
                    <button
                        class="btn btn-primary ml-auto"
                        type="submit"
                        value="Submit"
                        id="btn-submit-edit"
                    >Submit</button>
                <?php endif; ?>
                <?= form_close(); ?>
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
            </div>
        </div>
    </div>
</div>
