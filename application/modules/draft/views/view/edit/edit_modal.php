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
                    ><i class="far fa-file-alt"></i> File</a>
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
                    ><i class="far fa-comments"></i> Tanggapan</a>
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
                        <?php $this->load->view('draft/view/common/file_section', ['progress' => 'edit']) ?>

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
                                        >Catatan Editor</label>
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
                                    <hr class="my-3">
                                <?php endif; ?>


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
                initFlatpickrModal()
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
                showToast(true, res.data);
                $(`#edit-comment-tab-content`).load(` #edit-comment-info`)
            },
            error: function(err) {
                console.log(err);
                showToast(false, err.responseJSON.message);
            },
        });
    });
})
</script>
