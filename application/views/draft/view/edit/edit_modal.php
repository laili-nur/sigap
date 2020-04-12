<?php $level = check_level() ?>
<div
    class="modal fade"
    id="modal-edit"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-edit"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-overflow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Progress Edit</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <ul
                class="nav nav-tabs"
                id="edit-tab-wrapper"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="edit-file-tab"
                        data-toggle="tab"
                        href="#edit-file-tab-content"
                        role="tab"
                        aria-controls="edit-file-tab-content"
                        aria-selected="true"
                    >File</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="edit-comment-tab"
                        data-toggle="tab"
                        href="#edit-comment-tab-content"
                        role="tab"
                        aria-controls="edit-comment-tab-content"
                        aria-selected="false"
                    >Tanggapan</a>
                </li>
            </ul>

            <div class="modal-body py-3">
                <div
                    class="tab-content"
                    id="edit-tab-content-wrapper"
                >
                    <div
                        class="tab-pane fade show active"
                        id="edit-file-tab-content"
                        role="tabpanel"
                        aria-labelledby="edit-file-tab"
                    >
                        <div id="edit-file-info">
                            <div class="alert alert-info">
                                <p class="alert-heading font-weight-bold">File Tersimpan</p>
                                <?php if ($input->edit_file) : ?>
                                    <a
                                        href="<?= base_url("draft/download_file/draftfile/{$input->edit_file}") ?>"
                                        class="btn btn-success"
                                    ><i class="fa fa-download"></i> Download</a>
                                    <button
                                        type="button"
                                        class="btn btn-danger edit-delete-file"
                                    ><i class="fa fa-trash"></i> Delete</button>
                                <?php endif ?>
                                <?php if ($input->edit_file_link) : ?>
                                    <a
                                        href="<?= $input->edit_file_link ?>"
                                        class="btn btn-primary"
                                        target="_blank"
                                    ><i class="fa fa-external-link-alt"></i> External file</a>
                                <?php endif ?>
                                <p>
                                    <div>Terakhir diubah: <span><?= $input->edit_upload_date ?></span></div>
                                    <div>Oleh: <span><?= $input->edit_upload_by ?></span></div>
                                </p>
                            </div>

                            <hr class="my-4">

                            <?php if ($level == 'editor' || ($level == 'author' && $author_order == 1) || is_admin()) : ?>
                                <form
                                    id="edit-upload-form"
                                    method="post"
                                    enctype="multipart/form-data"
                                >
                                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                                    <div class="form-group">
                                        <label for="edit-file">Upload File Naskah</label>
                                        <div class="custom-file">
                                            <?= form_upload("edit_file", '', "class='custom-file-input document' id='edit-file'"); ?>
                                            <label
                                                class="custom-file-label"
                                                for="edit-file"
                                            >Pilih file</label>
                                        </div>
                                        <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-file-link">Link Naskah</label>
                                        <div>
                                            <?= form_input("edit_file_link", $input->{"edit_file_link"}, "class='form-control document' id='edit-file-link'"); ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button
                                            type="button"
                                            class="btn btn-light ml-auto"
                                            data-dismiss="modal"
                                        >Close</button>
                                        <button
                                            id="btn-upload-edit"
                                            class="btn btn-primary"
                                            type="submit"
                                        > Update</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="edit-comment-tab-content"
                        role="tabpanel"
                        aria-labelledby="edit-comment-tab"
                    >
                        <div id="edit-comment-info">
                            <fieldset>
                                <!-- CATATAN EDITOR UNTUK STAFF/ADMIN/AUTHOR -->
                                <?php if ($level != 'author') : ?>
                                    <div class="form-group">
                                        <label
                                            for="editor-edit-notes"
                                            class="font-weight-bold"
                                        >Catatan Editor untuk Admin</label>
                                        <?php
                                        if (!is_admin() && $level != 'editor') {
                                            echo "<div class='font-italic' id='editor-edit-notes'>" . $input->edit_notes . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "editor-edit-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "editor-edit-notes",
                                                'rows'  => '6',
                                                'value' => $input->edit_notes
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <hr class="my-3">

                                <!-- CATATAN AUTHOR UNTUK STAFF/ADMIN -->
                                <div class="form-group">
                                    <label
                                        for="author-edit-notes"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    if (!is_admin() && ($level != 'author' || $author_order != 1)) {
                                        echo "<div class='font-italic' id='author-edit-notes'>" . $input->edit_notes_author . "</div>";
                                    } else {
                                        echo form_textarea([
                                            'name'  => "author-edit-notes",
                                            'class' => 'form-control summernote-basic',
                                            'id'    => "author-edit-notes",
                                            'rows'  => '6',
                                            'value' => $input->edit_notes_author

                                        ]);
                                    }
                                    ?>
                                </div>
                            </fieldset>

                            <div class="d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-light ml-auto"
                                    data-dismiss="modal"
                                >Close</button>
                                <button
                                    id="btn-submit-edit"
                                    class="btn btn-primary"
                                    type="button"
                                >Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const draftId = $('[name=draft_id]').val();

    // reload segmen ketika modal diclose
    $('#edit-progress-wrapper').on('shown.bs.modal', `#modal-edit`, function() {
        // reload ketika modal diclose
        $(`#modal-edit`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#edit-progress-wrapper').load(' #edit-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })
    })

    // submit progress edit
    $('#edit-progress-wrapper').on('click', `#btn-submit-edit`, function() {
        const $this = $(this);

        const editData = {
            [`edit_notes`]: $(`#editor-edit-notes`).val(),
            [`edit_notes_author`]: $(`#author-edit-notes`).val(),
        }

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draftId,
            datatype: "JSON",
            data: editData,
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#edit-comment-tab-content`).load(` #edit-comment-info`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
        });
    });

    // upload progress
    $('#edit-progress-wrapper').on('submit', `#edit-upload-form`, function(e) {
        e.preventDefault()

        // validasi form
        $(this).validate({
            debug: true,
            rules: {
                [`edit_file`]: {
                    require_from_group: [1, ".document"],
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                [`edit_file_link`]: {
                    curl: true,
                    require_from_group: [1, ".document"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
            submitHandler: function(form) {
                const $this = $(`#btn-upload-edit`);
                $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

                // prepare form data
                const formData = new FormData(form);
                formData.append('progress', 'edit')

                // send data
                $.ajax({
                    url: "<?= base_url('draft/upload_progress/'); ?>" + draftId,
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(res) {
                        console.log(res);
                        show_toast(true, res.data);
                        $(`#edit-file-tab-content`).load(` #edit-file-info`)
                    },
                    error: function(err) {
                        console.log(err);
                        show_toast(false, err.responseJSON.message);
                        $resetform = $(`#edit-file`);
                        $resetform.val('');
                        $resetform.next('label.custom-file-label').html('');
                        $this.removeAttr("disabled").html("Update");
                    },
                });
            }
        });

        // trigger submit handler
        $(this).submit()
    })

    // delete file
    $('#edit-progress-wrapper').on('click', `.edit-delete-file`, function(e) {
        const $this = $(this)
        $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

        // send data
        $.ajax({
            url: "<?= base_url('draft/delete_progress/'); ?>" + draftId,
            type: "post",
            data: {
                type: 'edit'
            },
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#edit-file-tab-content`).load(` #edit-file-info`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
                $this.removeAttr("disabled").html("Update");
            },
        });
    })
})
</script>
