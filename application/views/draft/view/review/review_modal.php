<?php $level = check_level() ?>
<?php
$all_criteria = [
    [
        'number' => 1,
        'title' => 'Substansi naskah (mencerminkan adanya kontribusi dan inovasi pada pengembangan iptek, seni, dan budaya)'
    ],
    [
        'number' => 2,
        'title' => 'Orisinalitas Karya dan bobot ilmiah'
    ],
    [
        'number' => 3,
        'title' => 'Kemutahiran Pustaka'
    ],
    [
        'number' => 4,
        'title' => 'Kelengkapan unsur (sebagai suatu naskah buku dan keterkaitan antarbab, sistematika)'
    ],
]

?>
<div
    class="modal fade"
    id="modal-<?= $progress ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-review1"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg modal-dialog-overflow"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Progress <?= $progress ?> </h5>
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
                id="<?= $progress ?>-tab-wrapper"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="<?= $progress ?>-file-tab"
                        data-toggle="tab"
                        href="#<?= $progress ?>-file-tab-content"
                        role="tab"
                        aria-controls="<?= $progress ?>-file-tab-content"
                        aria-selected="true"
                    >File</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="<?= $progress ?>-comment-tab"
                        data-toggle="tab"
                        href="#<?= $progress ?>-comment-tab-content"
                        role="tab"
                        aria-controls="<?= $progress ?>-comment-tab-content"
                        aria-selected="false"
                    >Tanggapan</a>
                </li>
            </ul>
            <div class="modal-body py-3">
                <div
                    class="tab-content"
                    id="<?= $progress ?>-tab-content-wrapper"
                >
                    <div
                        class="tab-pane fade show active"
                        id="<?= $progress ?>-file-tab-content"
                        role="tabpanel"
                        aria-labelledby="<?= $progress ?>-file-tab"
                    >
                        <div id="<?= $progress ?>-file-info">
                            <div class="alert alert-info">
                                <p class="alert-heading font-weight-bold">File Tersimpan</p>
                                <?php if ($input->{"{$progress}_file"}) : ?>
                                    <a
                                        href="<?= base_url("draft/download_file/draftfile/{$input->{"{$progress}_file"}}") ?>"
                                        class="btn btn-success"
                                    ><i class="fa fa-download"></i> Download</a>
                                    <button
                                        type="button"
                                        class="btn btn-danger <?= $progress ?>-delete-file"
                                    ><i class="fa fa-trash"></i> Delete</button>
                                <?php endif ?>
                                <a
                                    href="<?= $input->{"{$progress}_file_link"} ?>"
                                    class="btn btn-primary"
                                    target="_blank"
                                ><i class="fa fa-external-link-alt"></i> External file</a>
                                <p>
                                    <div>Terakhir diubah: <span><?= $input->{"{$progress}_upload_date"} ?></span></div>
                                    <div>Oleh: <span><?= $input->{"{$progress}_upload_by"} ?></span></div>
                                </p>
                            </div>

                            <hr class="my-4">

                            <?php if ($level == 'reviewer' || ($level == 'author' && $author_order == 1) || is_admin()) : ?>
                                <form
                                    id="<?= $progress ?>-upload-form"
                                    method="post"
                                    enctype="multipart/form-data"
                                >
                                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                                    <div class="form-group">
                                        <label for="<?= $progress ?>-file">Upload File Naskah</label>
                                        <div class="custom-file">
                                            <?= form_upload("{$progress}_file", '', "class='custom-file-input document' id='{$progress}-file'"); ?>
                                            <label
                                                class="custom-file-label"
                                                for="<?= $progress ?>-file"
                                            >Pilih file</label>
                                        </div>
                                        <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="<?= $progress ?>-file-link">Link Naskah</label>
                                        <div>
                                            <?= form_input("{$progress}_file_link", $input->{"{$progress}_file_link"}, "class='form-control document' id='{$progress}-file-link'"); ?>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button
                                            id="btn-upload-<?= $progress ?>"
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
                        id="<?= $progress ?>-comment-tab-content"
                        role="tabpanel"
                        aria-labelledby="<?= $progress ?>-comment-tab"
                    >
                        <div id="<?= $progress ?>-criteria">
                            <?php if ($level != 'author') : ?>
                                <p class="font-weight-bold">KONTEN REVIEW</p>
                                <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                                <?php foreach ($all_criteria as $criteria_key => $criteria) : ?>
                                    <div class="alert alert-info">
                                        <label class="font-weight-bold"><?= $criteria['title'] ?></label>
                                        <textarea
                                            type="textarea"
                                            name="<?= "criteria{$criteria['number']}-{$progress}" ?>"
                                            id="<?= "criteria{$criteria['number']}-{$progress}" ?>"
                                            class="form-control summernote-basic"
                                            rows="6"
                                        ><?= $input->{"{$progress}_criteria{$criteria['number']}"} ?></textarea>

                                        <hr class="my-3">

                                        <p class="m-0 p-0">Nilai</p>
                                        <?php for ($j = 1; $j <= 5; $j++) :  ?>
                                            <div class="custom-control custom-control-inline custom-radio">
                                                <input
                                                    id="<?= "score{$j}-criteria{$criteria['number']}-{$progress}" ?>"
                                                    name="<?= "score-criteria{$criteria['number']}-{$progress}" ?>"
                                                    value="<?= $j ?>"
                                                    type="radio"
                                                    class="custom-control-input"
                                                    <?= $input->{"{$progress}_score"}[$criteria_key] == $j ? 'checked' : '' ?>
                                                />
                                                <label
                                                    class="custom-control-label"
                                                    for="<?= "score{$j}-criteria{$criteria['number']}-{$progress}" ?>"
                                                ><?= $j ?></label>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                <?php endforeach ?>

                                <div id="nilai-wrapper">
                                    <div class="alert <?= $input->{"{$progress}_total_score"} >= 400 ? 'alert-success' : 'alert-danger' ?>">
                                        <p class="badge <?= $input->{"{$progress}_total_score"} >= 400 ? 'badge-success' : 'badge-danger' ?>">Naskah Lolos Review</p>
                                        <p class="mb-0">
                                            <span>Nilai total :</span>
                                            <strong><?= $input->{"{$progress}_total_score"} ?></strong>
                                        </p>
                                        <p class="mb-0">Passing Grade = 400</p>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <fieldset>
                                <!-- CATATAN REVIEWER UNTUK STAFF/ADMIN -->
                                <?php if ($level != 'author') : ?>
                                    <hr class="my-3">
                                    <div class="form-group">
                                        <label
                                            for="reviewer-<?= $progress ?>-notes"
                                            class="font-weight-bold"
                                        >Catatan Reviewer untuk Admin</label>
                                        <?php
                                        if (!is_admin() && $level != 'reviewer') {
                                            echo "<div class='font-italic' id='reviewer-{$progress}-notes'>" . $input->{"{$progress}_notes"} . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "reviewer-{$progress}-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "reviewer-{$progress}-notes",
                                                'rows'  => '6',
                                                'value' => $input->{"{$progress}_notes"}
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>


                                <!-- CATATAN ADMIN UNTUK AUTHOR -->
                                <?php if (is_admin() || $level == 'author') : ?>
                                    <hr class="my-3">
                                    <div class="form-group">
                                        <label
                                            for="admin-<?= $progress ?>-notes"
                                            class="font-weight-bold"
                                        >Catatan Admin untuk Penulis</label>
                                        <?php
                                        if (!is_admin() && $level != 'reviewer') {
                                            echo "<div class='font-italic' id='admin-{$progress}-notes'>" . $input->{"{$progress}_notes_admin"} . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "admin-{$progress}-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "admin-{$progress}-notes",
                                                'rows'  => '6',
                                                'value' => $input->{"{$progress}_notes_admin"}
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>


                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="author-<?= $progress ?>-notes"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    if (!is_admin() && ($level != 'author' || $author_order != 1)) {
                                        echo "<div class='font-italic' id='author-{$progress}-notes'>" . $input->{"{$progress}_notes_author"} . "</div>";
                                    } else {
                                        echo form_textarea([
                                            'name'  => "author-{$progress}-notes",
                                            'class' => 'form-control summernote-basic',
                                            'id'    => "author-{$progress}-notes",
                                            'rows'  => '6',
                                            'value' => $input->{"{$progress}_notes_author"}

                                        ]);
                                    }
                                    ?>
                                </div>
                            </fieldset>

                            <?php if (is_admin() || $level == 'reviewer') : ?>
                                <div class="card-footer-content text-muted p-0 m-0">
                                    <div class="mb-1 font-weight-bold">Rekomendasi</div>
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input
                                            type="radio"
                                            name="<?= $progress ?>-flag"
                                            id="<?= $progress ?>-flag-accept"
                                            class="custom-control-input"
                                            value="y"
                                            <?= $input->{"{$progress}_flag"} == 'y' ? 'checked' : ''  ?>
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="<?= $progress ?>-flag-accept"
                                        >Setuju</label>
                                    </div>

                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input
                                            type="radio"
                                            name="<?= $progress ?>-flag"
                                            id="<?= $progress ?>-flag-decline"
                                            class="custom-control-input"
                                            value="n"
                                            <?= $input->{"{$progress}_flag"} == 'n' ? 'checked' : ''  ?>
                                        />
                                        <label
                                            class="custom-control-label"
                                            for="<?= $progress ?>-flag-decline"
                                        >Tolak</label>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-end">
                                <button
                                    id="btn-submit-<?= $progress ?>"
                                    class="btn btn-primary ml-auto"
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
    // contoh progress = 'review1','review2,'edit','layout','proofread','print'
    const progress = "<?= $progress == 'review1' || $progress == 'review2' ? 'review' : $progress ?>"
    // identifier khusus untuk progress review
    // selain progress review, identifier == progress
    const identifier = '<?= $progress ?>'

    const draftId = $('[name=draft_id]').val();

    // submit progress review
    $('#review-progress-wrapper').on('click', `#btn-submit-${identifier}`, function() {
        const $this = $(this);

        // nilai kriteria
        let nilai = [];
        for (let k = 1; k <= 4; k++) {
            nilai.push($(`[name=score-criteria${k}-${identifier}]:checked`).val() || 0)
        }
        nilai = nilai.join()

        const reviewData = {
            [`${identifier}_notes`]: $(`#reviewer-${identifier}-notes`).val(),
            [`${identifier}_notes_author`]: $(`#author-${identifier}-notes`).val(),
            [`${identifier}_notes_admin`]: $(`#admin-${identifier}-notes`).val(),
            [`${identifier}_flag`]: $(`[name=${identifier}-flag]:checked`).val(),
            [`${identifier}_criteria1`]: $(`#criteria1-${identifier}`).val(),
            [`${identifier}_criteria2`]: $(`#criteria2-${identifier}`).val(),
            [`${identifier}_criteria3`]: $(`#criteria3-${identifier}`).val(),
            [`${identifier}_criteria4`]: $(`#criteria4-${identifier}`).val(),
            [`${identifier}_score`]: nilai
        }

        $this.attr("disabled", "disabled").html(
            "<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draftId,
            datatype: "JSON",
            data: reviewData,
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#${identifier}-comment-tab-content`).load(` #${identifier}-criteria`)

            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
        });
    });

    // upload progress
    $('#review-progress-wrapper').on('submit', `#${identifier}-upload-form`, function(e) {
        e.preventDefault()

        // validasi form
        $(this).validate({
            debug: true,
            rules: {
                [`${identifier}_file`]: {
                    require_from_group: [1, ".document"],
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                [`${identifier}_file_link`]: {
                    curl: true,
                    require_from_group: [1, ".document"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
            submitHandler: function(form) {
                const $this = $(`#btn-upload-${identifier}`);
                $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

                // prepare form data
                const formData = new FormData(form);
                formData.append('progress', identifier)

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
                        $(`#${identifier}-file-tab-content`).load(` #${identifier}-file-info`)
                    },
                    error: function(err) {
                        console.log(err);
                        show_toast(false, err.responseJSON.message);
                        $resetform = $(`#${identifier}-file`);
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

    $('#review-progress-wrapper').on('click', `.${identifier}-delete-file`, function(e) {
        const $this = $(this)
        $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

        // send data
        $.ajax({
            url: "<?= base_url('draft/delete_progress/'); ?>" + draftId,
            type: "post",
            data: {
                type: identifier
            },
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#${identifier}-file-tab-content`).load(` #${identifier}-file-info`)
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
