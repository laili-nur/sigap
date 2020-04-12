<?php $level = check_level() ?>
<div
    class="modal fade"
    id="modal-cover"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-cover"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-overflow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Progress Cover</h5>
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
                id="cover-tab-wrapper"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="cover-file-tab"
                        data-toggle="tab"
                        href="#cover-file-tab-content"
                        role="tab"
                        aria-controls="cover-file-tab-content"
                        aria-selected="true"
                    >File</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="cover-comment-tab"
                        data-toggle="tab"
                        href="#cover-comment-tab-content"
                        role="tab"
                        aria-controls="cover-comment-tab-content"
                        aria-selected="false"
                    >Tanggapan</a>
                </li>
            </ul>

            <div class="modal-body py-3">
                <div
                    class="tab-content"
                    id="cover-tab-content-wrapper"
                >
                    <div
                        class="tab-pane fade show active"
                        id="cover-file-tab-content"
                        role="tabpanel"
                        aria-labelledby="cover-file-tab"
                    >
                        <div id="cover-file-info">
                            <div class="alert alert-info">
                                <p class="alert-heading font-weight-bold">File Tersimpan</p>
                                <?php if ($input->cover_file) : ?>
                                    <a
                                        href="<?= base_url("draft/download_file/draftfile/{$input->cover_file}") ?>"
                                        class="btn btn-success"
                                    ><i class="fa fa-download"></i> Download</a>
                                    <button
                                        type="button"
                                        class="btn btn-danger cover-delete-file"
                                    ><i class="fa fa-trash"></i> Delete</button>
                                <?php endif ?>
                                <?php if ($input->cover_file_link) : ?>
                                    <a
                                        href="<?= $input->cover_file_link ?>"
                                        class="btn btn-primary"
                                        target="_blank"
                                    ><i class="fa fa-external-link-alt"></i> External file</a>
                                <?php endif ?>
                                <p>
                                    <div>Terakhir diubah: <span><?= $input->cover_upload_date ?></span></div>
                                    <div>Oleh: <span><?= $input->cover_upload_by ?></span></div>
                                </p>
                            </div>

                            <hr class="my-4">

                            <?php if ($level == 'layouter' || ($level == 'author' && $author_order == 1) || is_admin()) : ?>
                                <form
                                    id="cover-upload-form"
                                    method="post"
                                    enctype="multipart/form-data"
                                >
                                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                                    <div class="form-group">
                                        <label for="cover-file">Upload File Naskah</label>
                                        <div class="custom-file">
                                            <?= form_upload("cover_file", '', "class='custom-file-input document' id='cover-file'"); ?>
                                            <label
                                                class="custom-file-label"
                                                for="cover-file"
                                            >Pilih file</label>
                                        </div>
                                        <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="cover-file-link">Link Naskah</label>
                                        <div>
                                            <?= form_input("cover_file_link", $input->{"cover_file_link"}, "class='form-control document' id='cover-file-link'"); ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button
                                            type="button"
                                            class="btn btn-light ml-auto"
                                            data-dismiss="modal"
                                        >Close</button>
                                        <button
                                            id="btn-upload-cover"
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
                        id="cover-comment-tab-content"
                        role="tabpanel"
                        aria-labelledby="cover-comment-tab"
                    >
                        <div id="cover-comment-info">
                            <fieldset>
                                <!-- CATATAN LAYOUTER UNTUK STAFF/ADMIN/AUTHOR -->
                                <?php if ($level != 'author') : ?>
                                    <div class="form-group">
                                        <label
                                            for="layouter-cover-notes"
                                            class="font-weight-bold"
                                        >Catatan Layouter untuk Admin</label>
                                        <?php
                                        if (!is_admin() && $level != 'layouter') {
                                            echo "<div class='font-italic' id='layouter-cover-notes'>" . $input->layout_notes . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "layouter-cover-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "layouter-cover-notes",
                                                'rows'  => '6',
                                                'value' => $input->cover_notes
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <hr class="my-3">

                                <!-- CATATAN AUTHOR UNTUK STAFF/ADMIN -->
                                <div class="form-group">
                                    <label
                                        for="author-cover-notes"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    if (!is_admin() && ($level != 'author' || $author_order != 1)) {
                                        echo "<div class='font-italic' id='author-cover-notes'>" . $input->cover_notes_author . "</div>";
                                    } else {
                                        echo form_textarea([
                                            'name'  => "author-cover-notes",
                                            'class' => 'form-control summernote-basic',
                                            'id'    => "author-cover-notes",
                                            'rows'  => '6',
                                            'value' => $input->cover_notes_author

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
                                    id="btn-submit-cover"
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
    $('#layout-progress-wrapper').on('shown.bs.modal', `#modal-cover`, function() {
        // reload ketika modal diclose
        $(`#modal-cover`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#cover-progress-wrapper').load(' #cover-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })
    })

    // submit progress cover
    $('#layout-progress-wrapper').on('click', `#btn-submit-cover`, function() {
        const $this = $(this);

        const layoutData = {
            [`cover_notes`]: $(`#layouter-cover-notes`).val(),
            [`cover_notes_author`]: $(`#author-cover-notes`).val(),
        }

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draftId,
            datatype: "JSON",
            data: layoutData,
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#cover-comment-tab-content`).load(` #cover-comment-info`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
        });
    });

    // upload file
    $('#layout-progress-wrapper').on('submit', `#cover-upload-form`, function(e) {
        e.preventDefault()

        // validasi form
        $(this).validate({
            debug: true,
            rules: {
                [`cover_file`]: {
                    require_from_group: [1, ".document"],
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                [`cover_file_link`]: {
                    curl: true,
                    require_from_group: [1, ".document"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
            submitHandler: function(form) {
                const $this = $(`#btn-upload-cover`);
                $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

                // prepare form data
                const formData = new FormData(form);
                formData.append('progress', 'cover')

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
                        $(`#cover-file-tab-content`).load(` #cover-file-info`)
                    },
                    error: function(err) {
                        console.log(err);
                        show_toast(false, err.responseJSON.message);
                        $resetform = $(`#cover-file`);
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
    $('#layout-progress-wrapper').on('click', `.cover-delete-file`, function(e) {
        const $this = $(this)
        $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

        // send data
        $.ajax({
            url: "<?= base_url('draft/delete_progress/'); ?>" + draftId,
            type: "post",
            data: {
                type: 'cover'
            },
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#cover-file-tab-content`).load(` #cover-file-info`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
                $this.removeAttr("disabled").html("Delete");
            },
        });
    })
})
</script>
