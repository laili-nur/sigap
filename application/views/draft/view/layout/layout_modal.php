<?php $level = check_level() ?>
<div
    class="modal fade"
    id="modal-layout"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-layout"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-overflow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Progress Layout</h5>
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
                id="layout-tab-wrapper"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="layout-file-tab"
                        data-toggle="tab"
                        href="#layout-file-tab-content"
                        role="tab"
                        aria-controls="layout-file-tab-content"
                        aria-selected="true"
                    >File</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="layout-comment-tab"
                        data-toggle="tab"
                        href="#layout-comment-tab-content"
                        role="tab"
                        aria-controls="layout-comment-tab-content"
                        aria-selected="false"
                    >Tanggapan</a>
                </li>
            </ul>

            <div class="modal-body py-3">
                <div
                    class="tab-content"
                    id="layout-tab-content-wrapper"
                >
                    <div
                        class="tab-pane fade show active"
                        id="layout-file-tab-content"
                        role="tabpanel"
                        aria-labelledby="layout-file-tab"
                    >
                        <div id="layout-file-info">
                            <div class="alert alert-info">
                                <p class="alert-heading font-weight-bold">File Tersimpan</p>
                                <?php if ($input->layout_file) : ?>
                                    <a
                                        href="<?= base_url("draft/download_file/draftfile/{$input->layout_file}") ?>"
                                        class="btn btn-success"
                                    ><i class="fa fa-download"></i> Download</a>
                                    <button
                                        type="button"
                                        class="btn btn-danger layout-delete-file"
                                    ><i class="fa fa-trash"></i> Delete</button>
                                <?php endif ?>
                                <?php if ($input->layout_file_link) : ?>
                                    <a
                                        href="<?= $input->layout_file_link ?>"
                                        class="btn btn-primary"
                                        target="_blank"
                                    ><i class="fa fa-external-link-alt"></i> External file</a>
                                <?php endif ?>
                                <p>
                                    <div>Terakhir diubah: <span><?= $input->layout_upload_date ?></span></div>
                                    <div>Oleh: <span><?= $input->layout_upload_by ?></span></div>
                                </p>
                            </div>

                            <hr class="my-4">

                            <?php if ($level == 'layouter' || ($level == 'author' && $author_order == 1) || is_admin()) : ?>
                                <form
                                    id="layout-upload-form"
                                    method="post"
                                    enctype="multipart/form-data"
                                >
                                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                                    <div class="form-group">
                                        <label for="layout-file">Upload File Naskah</label>
                                        <div class="custom-file">
                                            <?= form_upload("layout_file", '', "class='custom-file-input document' id='layout-file'"); ?>
                                            <label
                                                class="custom-file-label"
                                                for="layout-file"
                                            >Pilih file</label>
                                        </div>
                                        <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="layout-file-link">Link Naskah</label>
                                        <div>
                                            <?= form_input("layout_file_link", $input->{"layout_file_link"}, "class='form-control document' id='layout-file-link'"); ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button
                                            type="button"
                                            class="btn btn-light ml-auto"
                                            data-dismiss="modal"
                                        >Close</button>
                                        <button
                                            id="btn-upload-layout"
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
                        id="layout-comment-tab-content"
                        role="tabpanel"
                        aria-labelledby="layout-comment-tab"
                    >
                        <div id="layout-comment-info">
                            <fieldset>
                                <!-- CATATAN LAYOUTER UNTUK STAFF/ADMIN/AUTHOR -->
                                <?php if ($level != 'author') : ?>
                                    <div class="form-group">
                                        <label
                                            for="layouter-layout-notes"
                                            class="font-weight-bold"
                                        >Catatan Layouter untuk Admin</label>
                                        <?php
                                        if (!is_admin() && $level != 'layouter') {
                                            echo "<div class='font-italic' id='layouter-layout-notes'>" . $input->layout_notes . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "layouter-layout-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "layouter-layout-notes",
                                                'rows'  => '6',
                                                'value' => $input->layout_notes
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <hr class="my-3">

                                <!-- CATATAN AUTHOR UNTUK STAFF/ADMIN -->
                                <div class="form-group">
                                    <label
                                        for="author-layout-notes"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    if (!is_admin() && ($level != 'author' || $author_order != 1)) {
                                        echo "<div class='font-italic' id='author-layout-notes'>" . $input->layout_notes_author . "</div>";
                                    } else {
                                        echo form_textarea([
                                            'name'  => "author-layout-notes",
                                            'class' => 'form-control summernote-basic',
                                            'id'    => "author-layout-notes",
                                            'rows'  => '6',
                                            'value' => $input->layout_notes_author

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
                                    id="btn-submit-layout"
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
    $('#layout-progress-wrapper').on('shown.bs.modal', `#modal-layout`, function() {
        // reload ketika modal diclose
        $(`#modal-layout`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#layout-progress-wrapper').load(' #layout-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })
    })

    // submit progress layout
    $('#layout-progress-wrapper').on('click', `#btn-submit-layout`, function() {
        const $this = $(this);

        const layoutData = {
            [`layout_notes`]: $(`#layouter-layout-notes`).val(),
            [`layout_notes_author`]: $(`#author-layout-notes`).val(),
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
                $(`#layout-comment-tab-content`).load(` #layout-comment-info`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
        });
    });

    // upload file
    $('#layout-progress-wrapper').on('submit', `#layout-upload-form`, function(e) {
        e.preventDefault()

        // validasi form
        $(this).validate({
            debug: true,
            rules: {
                [`layout_file`]: {
                    require_from_group: [1, ".document"],
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                [`layout_file_link`]: {
                    curl: true,
                    require_from_group: [1, ".document"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
            submitHandler: function(form) {
                const $this = $(`#btn-upload-layout`);
                $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

                // prepare form data
                const formData = new FormData(form);
                formData.append('progress', 'layout')

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
                        $(`#layout-file-tab-content`).load(` #layout-file-info`)
                    },
                    error: function(err) {
                        console.log(err);
                        show_toast(false, err.responseJSON.message);
                        $resetform = $(`#layout-file`);
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
    $('#layout-progress-wrapper').on('click', `.layout-delete-file`, function(e) {
        const $this = $(this)
        $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

        // send data
        $.ajax({
            url: "<?= base_url('draft/delete_progress/'); ?>" + draftId,
            type: "post",
            data: {
                type: 'layout'
            },
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#layout-file-tab-content`).load(` #layout-file-info`)
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
