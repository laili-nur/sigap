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
                <h5 class="modal-title"> Progress Review 1</h5>
            </div>
            <div class="modal-body">

                <div id="review-upload-segment">
                    <?= form_open_multipart('', 'id="review-form"'); ?>
                    <p class="font-weight-bold">NASKAH</p>
                    <?php if ($level == 'reviewer' || ($level == 'author' && $author_order == 1) || is_admin()) : ?>
                    <div class="alert alert-info">Upload file naskah atau sertakan link naskah. Kosongkan jika file
                        naskah
                        hard copy.</div>
                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                    <div class="form-group">
                        <label for="review-file">File Naskah</label>
                        <div class="custom-file">
                            <?= form_upload('review-file', '', 'class="custom-file-input naskah" id="review-file"'); ?>
                            <label
                                class="custom-file-label"
                                for="review-file"
                            >Pilih file</label>
                        </div>
                        <small class="form-text text-muted">Tipe file upload bertype : docx, doc, dan
                            pdf.</small>
                    </div>
                    <div class="form-group">
                        <label for="reviewer-file-link">Link Naskah</label>
                        <div>
                            <?= form_input('reviewer-file-link', $input->reviewer1_file_link, 'class="form-control naskah" id="reviewer-file-link"'); ?>
                        </div>
                        <?= form_error('reviewer-file-link'); ?>
                    </div>
                    <div class="form-group">
                        <button
                            id="btn-upload-review"
                            class="btn btn-primary"
                            type="submit"
                        ><i class="fa fa-upload"></i> Upload</button>
                    </div>
                    <?= form_close(); ?>
                    <?php endif; ?>


                    <div id="review-file-info">
                        <p>
                            <p class="review-upload-date"></p>
                            <p class="review-last-upload"></p>
                        </p>
                        <a
                            data-toggle="tooltip"
                            data-placement="right"
                            title=""
                            data-original-title=""
                            href=""
                            class="btn btn-success review-download-file"
                        ><i class="fa fa-download"></i> Download</a>
                        <a
                            data-toggle="tooltip"
                            data-placement="right"
                            title=""
                            data-original-title=""
                            href=""
                            class="btn btn-primary review-download-file-link"
                        ><i class="fa fa-external-link-alt"></i> External file</a>
                    </div>
                </div>




                <?= form_open('', 'id="formreview1_krit" novalidate=""'); ?>
                <?php if ($level != 'author') : ?>
                <hr class="my-3">
                <p class="font-weight-bold">REVIEW</p>
                <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                <div>
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
                </div>
            </div>

            <div class="modal-footer">
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
                <button
                    id="btn-submit-review"
                    class="btn btn-primary ml-auto"
                    type="button"
                >Submit</button>
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let identifier;

    // populate data review
    $('#review-progress-wrapper').on('click', '.btn-modal-review', function() {
        identifier = $(this).data('identifier');

        let nilaiReviewer;

        // jika buka modal review 1
        if (identifier == 'review1') {
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
            $('#review-file-info .review-last-upload').text('<?= $input->review1_last_upload ?>')
            $('#review-file-info .review-download-file').attr('href', '<?= base_url("draft/download_file/draftfile/{$input->review1_file}") ?>')
            $('#review-file-info .review-download-file-link').attr('href', '<?= $input->reviewer1_file_link ?>')
            $('#reviewer-file-link').val('<?= $input->reviewer1_file_link ?>')
        }

        // jika buka modal review 2
        if (identifier == 'review2') {
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

            // load file info review 2
            $('#review-file-info .review-upload-date').text('<?= $input->review2_upload_date ?>')
            $('#review-file-info .review-last-upload').text('<?= $input->review2_last_upload ?>')
            $('#review-file-info .review-download-file').attr('href', '<?= base_url("draft/download_file/draftfile/{$input->review2_file}") ?>')
            $('#review-file-info .review-download-file-link').attr('href', '<?= $input->reviewer2_file_link ?>')
            $('#reviewer-file-link').val('<?= $input->reviewer2_file_link ?>')
        }
    })



    // submit progress review
    $('#review-progress-wrapper').on('click', '#btn-submit-review', function() {
        const $this = $(this);
        const draftId = $('[name=draft_id]').val();

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
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                location.reload()
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
                    require_from_group: [1, ".naskah"],
                    dokumen: "docx|doc|pdf",
                    filesize50: 52428200
                },
                'reviewer-file-link': {
                    curl: true,
                    require_from_group: [1, ".naskah"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
            submitHandler: function(form) {

                const $this = $('#btn-upload-review');
                $this.attr("disabled", "disabled").html('<i class="fa fa-spinner fa-spin "></i> Uploading ');
                const draftId = $('[name=draft_id]').val();

                // prepare form data
                const formData = new FormData(form);
                formData.append('progress', 'review')
                if (identifier == 'review1') {
                    formData.append('identifier', 1)
                    formData.append('review1_file', formData.get('review-file'))
                    formData.append('reviewer1_file_link', formData.get('reviewer-file-link'))
                } else {
                    formData.append('identifier', 2)
                    formData.append('review2_file', formData.get('review-file'))
                    formData.append('reviewer2_file_link', formData.get('reviewer-file-link'))
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
                        $resetform = $('#review-file');
                        $resetform.val('');
                        $resetform.next('label.custom-file-label').html('');
                        $this.removeAttr("disabled").html("Upload");

                        location.reload()
                    },
                    error: function(err) {
                        console.log(err);
                        show_toast(false, err.responseJSON.message);
                    },
                });
            }
        });

        // trigger submit handler
        $(this).submit()
    })
})
</script>