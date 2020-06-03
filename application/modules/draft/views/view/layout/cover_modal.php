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
                    ><i class="far fa-file-alt"></i> File</a>
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
                    ><i class="far fa-comments"></i> Tanggapan</a>
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
                        <?php $this->load->view('draft/view/common/file_section', ['progress' => 'cover']) ?>
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
                                            class="badge badge-primary"
                                        >Catatan Layouter</label>
                                        <?php
                                        if (!is_admin() && $level != 'layouter' || $is_final) {
                                            echo "<div>" . $input->layout_notes . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "layouter-cover-notes",
                                                'class' => 'form-control',
                                                'id'    => "layouter-cover-notes",
                                                'rows'  => '6',
                                                'value' => $input->cover_notes
                                            ]);
                                        }
                                        ?>
                                    </div>
                                    <hr class="my-3">
                                <?php endif; ?>

                                <!-- CATATAN AUTHOR UNTUK STAFF/ADMIN -->
                                <div class="form-group">
                                    <label
                                        for="author-cover-notes"
                                        class="badge badge-primary"
                                    >Catatan Penulis</label>
                                    <?php
                                    if (!is_admin() && ($level != 'author' || $author_order != 1) || $is_final) {
                                        echo "<div>" . $input->cover_notes_author . "</div>";
                                    } else {
                                        echo form_textarea([
                                            'name'  => "author-cover-notes",
                                            'class' => 'form-control',
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
                                <?php if (!$is_final) : ?>
                                    <button
                                        id="btn-submit-cover"
                                        class="btn btn-primary"
                                        type="button"
                                    >Submit</button>
                                <?php endif ?>
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
        initSummernote()

        // reload ketika modal diclose
        $(`#modal-cover`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#layout-progress-wrapper').load(' #layout-progress', function() {
                // reinitiate flatpickr modal after load
                initFlatpickrModal()
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
                $(`#cover-comment-tab-content`).load(` #cover-comment-info`, function() {
                    showToast(true, res.data);
                    initSummernote()
                })
            },
            error: function(err) {
                console.log(err);
                showToast(false, err.responseJSON.message);
            },
        });
    });

    function initSummernote() {
        // inisiasi summernote
        $(`#layouter-cover-notes`).summernote(summernoteConfig)
        $(`#author-cover-notes`).summernote(summernoteConfig)
    }
})
</script>
