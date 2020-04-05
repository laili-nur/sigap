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
    id="modal-review"
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
                <h5 class="modal-title"> //populated from jquery// </h5>
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
                id="review-tab-wrapper"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="review-file-tab"
                        data-toggle="tab"
                        href="#review-file-tab-content"
                        role="tab"
                        aria-controls="review-file-tab-content"
                        aria-selected="true"
                    >File</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="review-comment-tab"
                        data-toggle="tab"
                        href="#review-comment-tab-content"
                        role="tab"
                        aria-controls="review-comment-tab-content"
                        aria-selected="false"
                    >Tanggapan</a>
                </li>
            </ul>
            <div class="modal-body py-3">
                <div
                    class="tab-content"
                    id="review-tab-content-wrapper"
                >
                    <div
                        class="tab-pane fade show active"
                        id="review-file-tab-content"
                        role="tabpanel"
                        aria-labelledby="review-file-tab"
                    >
                        <div
                            id="review-file-info"
                            class="alert alert-info"
                        >
                            <p class="alert-heading font-weight-bold">File Tersimpan</p>
                            <a class="btn btn-success review-download-file"><i class="fa fa-download"></i> Download</a>
                            <button
                                type="button"
                                class="btn btn-danger review-delete-file"
                            ><i class="fa fa-trash"></i> Delete</button>
                            <a class="btn btn-primary review-download-file-link"><i class="fa fa-external-link-alt"></i> External file</a>
                            <p>
                                <div>Terakhir diubah: <span class="review-upload-date"></span></div>
                                <div>Oleh: <span class="review-last-upload"></span></div>
                            </p>
                        </div>

                        <hr class="my-4">

                        <?php if ($level == 'reviewer' || ($level == 'author' && $author_order == 1) || is_admin()) : ?>
                        <form
                            id="review-form"
                            method="post"
                            enctype="multipart/form-data"
                        >
                            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                            <div class="form-group">
                                <label for="review-file">Upload File Naskah</label>
                                <div class="custom-file">
                                    <?= form_upload('review-file', '', 'class="custom-file-input document" id="review-file"'); ?>
                                    <label
                                        class="custom-file-label"
                                        for="review-file"
                                    >Pilih file</label>
                                </div>
                                <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="reviewer-file-link">Link Naskah</label>
                                <div>
                                    <?= form_input('reviewer-file-link', '', 'class="form-control document" id="reviewer-file-link"'); ?>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button
                                    id="btn-upload-review"
                                    class="btn btn-primary"
                                    type="submit"
                                > Update</button>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="review-comment-tab-content"
                        role="tabpanel"
                        aria-labelledby="review-comment-tab"
                    >
                        <div id="kriteria-reviewer">
                            <?php if ($level != 'author') : ?>
                            <p class="font-weight-bold">KONTEN REVIEW</p>
                            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                            <?php foreach ($all_criteria as $criteria) : ?>
                            <div class="alert alert-info">
                                <label class="font-weight-bold"><?= $criteria['title'] ?></label>
                                <textarea
                                    type="textarea"
                                    name="<?= "kriteria{$criteria['number']}" ?>"
                                    id="<?= "kriteria{$criteria['number']}" ?>"
                                    class="form-control summernote-basic"
                                    rows="6"
                                    <?php ($level == 'reviewer' || is_admin()) ? '' : 'disabled'  ?>
                                ></textarea>

                                <hr class="my-3">

                                <p class="m-0 p-0">Nilai</p>
                                <?php for ($j = 1; $j <= 5; $j++) :  ?>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <input
                                        id="<?= "nilai{$j}-kriteria{$criteria['number']}" ?>"
                                        name="<?= "nilai-kriteria{$criteria['number']}" ?>"
                                        value="<?= $j ?>"
                                        type="radio"
                                        <?php ($level == 'reviewer' || is_admin()) ? '' : 'disabled'  ?>
                                        class="custom-control-input"
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="<?= "nilai{$j}-kriteria{$criteria['number']}" ?>"
                                    ><?= $j ?></label>
                                </div>
                                <?php endfor ?>
                            </div>
                            <?php endforeach ?>

                            <div id="nilai-wrapper">
                                <div class="alert alert-success">
                                    <p class="badge badge-success">Naskah Lolos Review</p>
                                    <p class="mb-0">
                                        <span>Nilai total :</span>
                                        <strong class="total-nilai">0</strong>
                                    </p>
                                    <p class="mb-0">Passing Grade = 400</p>
                                </div>
                                <div class="alert alert-danger">
                                    <p class="badge badge-danger">Naskah Tidak Lolos Review</p>
                                    <p class="mb-0">
                                        <span>Nilai total :</span>
                                        <strong class="total-nilai">0</strong>
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
                                        for="reviewer-review-notes"
                                        class="font-weight-bold"
                                    >Catatan Reviewer untuk Admin</label>
                                    <?php
                                        if (!is_admin() && $level != 'reviewer') {
                                            echo '<div class="font-italic" id="reviewer-review-notes"></div>';
                                        } else {
                                            echo form_textarea([
                                                'name'  => 'reviewer-review-notes',
                                                'class' => 'form-control summernote-basic',
                                                'id'    => 'reviewer-review-notes',
                                                'rows'  => '6',
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
                                        for="admin-review-notes"
                                        class="font-weight-bold"
                                    >Catatan Admin untuk Penulis</label>
                                    <?php
                                        if (!is_admin() && $level != 'reviewer') {
                                            echo '<div class="font-italic" id="admin-review-notes"></div>';
                                        } else {
                                            echo form_textarea([
                                                'name'  => 'admin-review-notes',
                                                'class' => 'form-control summernote-basic',
                                                'id'    => 'admin-review-notes',
                                                'rows'  => '6',
                                            ]);
                                        }
                                        ?>
                                </div>
                                <?php endif; ?>


                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="author-review-notes"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    if (!is_admin() && ($level != 'author' || $author_order != 1)) {
                                        echo '<div class="font-italic" id="author-review-notes"></div>';
                                    } else {
                                        echo form_textarea([
                                            'name'  => 'author-review-notes',
                                            'class' => 'form-control summernote-basic',
                                            'id'    => 'author-review-notes',
                                            'rows'  => '6',
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
                                        name="review-flag"
                                        id="review-flag-accept"
                                        class="custom-control-input"
                                        value="y"
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="review-flag-accept"
                                    >Setuju</label>
                                </div>

                                <div class="custom-control custom-control-inline custom-radio">
                                    <input
                                        type="radio"
                                        name="review-flag"
                                        id="review-flag-decline"
                                        class="custom-control-input"
                                        value="n"
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="review-flag-decline"
                                    >Tolak</label>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-end">
                                <button
                                    id="btn-submit-review"
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
    let identifier;
    const draftId = $('[name=draft_id]').val();

    // populate data review
    $('#review-progress-wrapper').on('click', '.btn-modal-review', function() {
        identifier = $(this).data('identifier');

        let nilaiReviewer;

        // jika buka modal review 1
        if (identifier == 'review1') {
            $('#modal-review .modal-title').html('Progress Review 1')
            // populate catatan kriteria
            $('#kriteria1').val('<?= $input->kriteria1_reviewer1 ?>')
            $('#kriteria2').val('<?= $input->kriteria2_reviewer1 ?>')
            $('#kriteria3').val('<?= $input->kriteria3_reviewer1 ?>')
            $('#kriteria4').val('<?= $input->kriteria4_reviewer1 ?>')

            // populate catatan umum
            $('#reviewer-review-notes').val('<?= $input->review1_notes ?>')
            $('#admin-review-notes').val('<?= $input->review1_notes_admin ?>')
            $('#author-review-notes').val('<?= $input->review1_notes_author ?>')

            // populate flag rekomendasi reviewer
            $('#review-flag-accept').prop('checked', '<?= $input->review1_flag ?>' == 'y')
            $('#review-flag-decline').prop('checked', '<?= $input->review1_flag ?>' == 'n')

            // nilai
            $('.total-nilai').html('<?= $input->nilai_total_reviewer1 ?>')

            // menampilkan sukses atau danger berdasarkan nilai
            if (Number('<?= $input->nilai_total_reviewer1 ?>') >= 400) {
                $('#nilai-wrapper .alert-danger').hide()
            } else {
                $('#nilai-wrapper .alert-success').hide()
            }

            // mengisi radio review 1
            for (let kriteria = 1; kriteria <= 4; kriteria++) {
                for (let nilai = 1; nilai <= 5; nilai++) {
                    if (kriteria == 1) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer1 ? $input->nilai_reviewer1[0] : null ?>'
                    } else if (kriteria == 2) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer1 ? $input->nilai_reviewer1[1] : null ?>'
                    } else if (kriteria == 3) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer1 ? $input->nilai_reviewer1[2] : null ?>'
                    } else if (kriteria == 4) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer1 ? $input->nilai_reviewer1[3] : null ?>'
                    }
                    $(`#nilai${nilai}-kriteria${kriteria}`).prop('checked', nilaiReviewer == nilai)
                }
            }

            // load file info review 1
            $('#review-file-info .review-upload-date').text('<?= $input->review1_upload_date ?>')
            $('#review-file-info .review-last-upload').text('<?= $input->review1_upload_by ?>')
            $('#reviewer-file-link').val('<?= $input->review1_file_link ?>')

            if ('<?= $input->review1_file ?>') {
                $('#review-file-info .review-download-file').attr('href', '<?= base_url("draft/download_file/draftfile/{$input->review1_file}") ?>')
                $('#review-file-info .review-download-file').show()
            } else {
                $('#review-file-info .review-download-file').hide()
            }

            if ('<?= $input->review1_file ?>') {
                $('#review-file-info .review-delete-file').show()
            } else {
                $('#review-file-info .review-delete-file').hide()
            }

            if ('<?= $input->review1_file_link ?>') {
                $('#review-file-info .review-download-file-link').attr('href', '<?= $input->review1_file_link ?>')
                $('#review-file-info .review-download-file-link').show()
            } else {
                $('#review-file-info .review-download-file-link').hide()
            }
        }

        // jika buka modal review 2
        if (identifier == 'review2') {
            $('#modal-review .modal-title').html('Progress Review 2')
            // populate catatan kriteria
            $('#kriteria1').val('<?= $input->kriteria1_reviewer2 ?>')
            $('#kriteria2').val('<?= $input->kriteria2_reviewer2 ?>')
            $('#kriteria3').val('<?= $input->kriteria3_reviewer2 ?>')
            $('#kriteria4').val('<?= $input->kriteria4_reviewer2 ?>')

            // populate catatan umum
            $('#reviewer-review-notes').val('<?= $input->review2_notes ?>')
            $('#admin-review-notes').val('<?= $input->review2_notes_admin ?>')
            $('#author-review-notes').val('<?= $input->review2_notes_author ?>')

            // populate flag rekomendasi reviewer
            $('#review-flag-accept').prop('checked', '<?= $input->review2_flag ?>' == 'y')
            $('#review-flag-decline').prop('checked', '<?= $input->review2_flag ?>' == 'n')

            // nilai
            $('.total-nilai').html('<?= $input->nilai_total_reviewer2 ?>')

            // menampilkan sukses atau danger berdasarkan nilai
            if (Number('<?= $input->nilai_total_reviewer2 ?>') >= 400) {
                $('#nilai-wrapper .alert-danger').hide()
            } else {
                $('#nilai-wrapper .alert-success').hide()
            }

            // mengisi radio review 2
            for (let kriteria = 1; kriteria <= 4; kriteria++) {
                for (let nilai = 1; nilai <= 5; nilai++) {
                    if (kriteria == 1) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer2 ? $input->nilai_reviewer2[0] : null ?>'
                    } else if (kriteria == 2) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer2 ? $input->nilai_reviewer2[1] : null ?>'
                    } else if (kriteria == 3) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer2 ? $input->nilai_reviewer2[2] : null ?>'
                    } else if (kriteria == 4) {
                        nilaiReviewer =
                            '<?= $input->nilai_reviewer2 ? $input->nilai_reviewer2[3] : null ?>'
                    }
                    $(`#nilai${nilai}-kriteria${kriteria}`).prop('checked', nilaiReviewer == nilai)
                }
            }

            // load file info review 1
            $('#review-file-info .review-upload-date').text('<?= $input->review2_upload_date ?>')
            $('#review-file-info .review-last-upload').text('<?= $input->review2_upload_by ?>')
            $('#reviewer-file-link').val('<?= $input->review2_file_link ?>')

            if ('<?= $input->review2_file ?>') {
                $('#review-file-info .review-download-file').attr('href', '<?= base_url("draft/download_file/draftfile/{$input->review2_file}") ?>')
                $('#review-file-info .review-download-file').show()
            } else {
                $('#review-file-info .review-download-file').hide()
            }

            if ('<?= $input->review2_file ?>') {
                $('#review-file-info .review-delete-file').show()
            } else {
                $('#review-file-info .review-delete-file').hide()
            }

            if ('<?= $input->review2_file_link ?>') {
                $('#review-file-info .review-download-file-link').attr('href', '<?= $input->review2_file_link ?>')
                $('#review-file-info .review-download-file-link').show()
            } else {
                $('#review-file-info .review-download-file-link').hide()
            }
        }
    })



    // submit progress review
    $('#review-progress-wrapper').on('click', '#btn-submit-review', function() {
        const $this = $(this);

        // catatan
        const reviewNotes = $('#reviewer-review-notes').val();
        const reviewNotesAuthor = $('#author-review-notes').val();
        const reviewNotesAdmin = $('#admin-review-notes').val();

        // flag rekomendasi
        const reviewFlag = $('[name=review-flag]:checked').val();

        // komentar kriteria
        const kriteria1 = $('#kriteria1').val();
        const kriteria2 = $('#kriteria2').val();
        const kriteria3 = $('#kriteria3').val();
        const kriteria4 = $('#kriteria4').val();

        // nilai kriteria
        let nilai = [];
        for (let k = 1; k <= 4; k++) {
            nilai.push($(`[name=nilai-kriteria${k}]:checked`).val() || 0)
        }
        nilai = nilai.join()

        let reviewData;
        if (identifier == 'review1') {
            reviewData = {
                review1_notes: reviewNotes,
                review1_notes_author: reviewNotesAuthor,
                review1_notes_admin: reviewNotesAdmin,
                review1_flag: reviewFlag,
                kriteria1_reviewer1: kriteria1,
                kriteria2_reviewer1: kriteria2,
                kriteria3_reviewer1: kriteria3,
                kriteria4_reviewer1: kriteria4,
                nilai_reviewer1: nilai
            }
        } else {
            reviewData = {
                review2_notes: reviewNotes,
                review2_notes_author: reviewNotesAuthor,
                review2_notes_admin: reviewNotesAdmin,
                review2_flag: reviewFlag,
                kriteria1_reviewer2: kriteria1,
                kriteria2_reviewer2: kriteria2,
                kriteria3_reviewer2: kriteria3,
                kriteria4_reviewer2: kriteria4,
                nilai_reviewer2: nilai
            }
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
                location.reload()
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
        });
    });

    $('#review-progress-wrapper').on('submit', '#review-form', function(e) {
        e.preventDefault()

        // validasi form
        $(this).validate({
            debug: true,
            rules: {
                'review-file': {
                    require_from_group: [1, ".document"],
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                'reviewer-file-link': {
                    curl: true,
                    require_from_group: [1, ".document"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
            submitHandler: function(form) {
                const $this = $('#btn-upload-review');
                $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i>');

                // prepare form data
                const formData = new FormData(form);
                formData.append('progress', 'review')
                if (identifier == 'review1') {
                    formData.append('identifier', 1)
                    formData.append('review1_file', formData.get('review-file'))
                    formData.append('review1_file_link', formData.get('reviewer-file-link'))
                } else {
                    formData.append('identifier', 2)
                    formData.append('review2_file', formData.get('review-file'))
                    formData.append('review2_file_link', formData.get('reviewer-file-link'))
                }
                formData.delete('review-file')
                formData.delete('reviewer-file-link')

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
                        location.reload()
                    },
                    error: function(err) {
                        console.log(err);
                        show_toast(false, err.responseJSON.message);
                        $resetform = $('#review-file');
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

    $('#review-progress-wrapper').on('click', '.review-delete-file', function(e) {
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
                location.reload()
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