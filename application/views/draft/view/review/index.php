<?php

use Carbon\Carbon;

$level                  = check_level();
$review1_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->review1_deadline, false);
$review2_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->review2_deadline, false);
$is_review_started      = format_datetime($input->review_start_date);

$data['keren'] = 'mantap jiwa jos gandos';
?>

<section id="review-progress-wrapper" class="card">
    <div id="review-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Review</span>
                <div class="card-header-control">
                    <?php if (is_admin()) : ?>
                        <button id="btn-modal-select-reviewer" type="button" class="d-inline btn <?= (empty($reviewers)) ? 'btn-warning' : 'btn-secondary'; ?>" title="Pilih Reviewer"><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih
                                Reviewer</span></button>
                    <?php endif; ?>
                    <?php if ($level == 'reviewer' || is_admin()) : ?>
                        <button id="btn-start-review" title="Mulai proses review" type="button" class="d-inline btn <?= !$is_review_started ? 'btn-warning' : 'btn-secondary'; ?> <?= empty($reviewers) || $is_review_started ? 'btn-disabled' : ''; ?>" <?= empty($reviewers) || $is_review_started ? 'disabled' : ''; ?>><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span> </button>
                    <?php endif; ?>
                </div>
        </header>

        <?php if (empty($reviewers)) : ?>
            <?php if (is_admin()) : ?>
                <div class="alert alert-warning mb-1">
                    <strong>PERHATIAN!</strong> Pilih reviewer terlebih dahulu sebelum memulai progress review.
                </div>
            <?php else : ?>
                <div class="alert alert-info">
                    <h5 class="alert-heading">Pencarian Reviewer</h5>
                    Administrator sedang melakukan pencarian reviewer yang sesuai dengan draft anda.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="list-group list-group-flush list-group-bordered" id="list-group-review">

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong><?= format_datetime($input->review_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong><?= format_datetime($input->review_end_date); ?></strong>
            </div>

            <!-- reviewer 1 hanya bisa melihat deadline reviewer 1 -->
            <!-- staff/admin bisa melihat semua -->
            <?php if (is_null($reviewer_order) || $reviewer_order == 0) : ?>
                <div class="list-group-item justify-content-between">
                    <?php if (is_admin()) : ?>
                        <a href="#" id="btn-modal-deadline-review" title="Ubah deadline" data-toggle="modal" data-target="#modal-deadline-review" data-identifier="review1">Deadline reviewer #1 <i class="fas fa-edit fa-fw"></i></a>
                    <?php else : ?>
                        <span>Deadline reviewer #1</span>
                    <?php endif ?>
                    <strong>
                        <?= ($review1_remaining_time <= 0 and $input->review1_flag == '')
                            ? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">' . format_datetime($input->review1_deadline) . '</span>'
                            : format_datetime($input->review1_deadline); ?>
                    </strong>
                </div>
            <?php endif; ?>

            <!-- reviewer 2 hanya bisa melihat deadline reviewer 2 -->
            <!-- staff/admin bisa melihat semua -->
            <?php if (is_null($reviewer_order) || $reviewer_order == 1) : ?>
                <div class="list-group-item justify-content-between">
                    <?php if (is_admin()) : ?>
                        <a href="#" id="btn-modal-deadline-review" title="Ubah deadline" data-toggle="modal" data-target="#modal-deadline-review" data-identifier="review2">Deadline reviewer #2 <i class="fas fa-edit fa-fw"></i></a>
                    <?php else : ?>
                        <span>Deadline reviewer #2</span>
                    <?php endif ?>
                    <strong>
                        <?= ($review2_remaining_time <= 0 and $input->review2_flag == '')
                            ? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">' . format_datetime($input->review2_deadline) . '</span>'
                            : format_datetime($input->review2_deadline); ?>
                    </strong>
                </div>
            <?php endif; ?>

            <!-- staff di draft ini bisa melihat reviewer dan rekomendasinya -->
            <?php if (is_staff()) : ?>
                <div class="list-group-item justify-content-between">
                    <span class="text-muted">Reviewer</span>
                    <div>
                        <?php if ($reviewers) {
                            $i = 1;
                            foreach ($reviewers as $reviewer) {
                                echo '<span class="badge badge-info p-1">' . $i . '. ' . $reviewer->reviewer_name . '</span> ';
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="list-group-item justify-content-between">
                    <span class="text-muted">Rekomendasi Reviewer</span>
                    <div>
                        <?php
                        for ($i = 1; $i <= 2; $i++) {
                            if ($input->{"review{$i}_flag"} && $input->{"review{$i}_flag"} == 'y') {
                                echo "<span class='badge badge-success p-1'>{$i}. Setuju</span> ";
                            } elseif ($input->{"review{$i}_flag"} && $input->{"review{$i}_flag"} == 'n') {
                                echo "<span class='badge badge-danger p-1'>{$i}. Menolak</span> ";
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <a href="#" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" data-trigger="hover" data-content="<?= $input->review_status; ?>" data-original-title="Catatan Admin">
                    <?php if ($input->is_review == 'n' && $input->draft_status == 99) : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Review Ditolak</span>
                    <?php elseif ($input->is_review == 'y') : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Review Selesai</span>
                    <?php endif ?>
                </a>
            </div>
            <hr class="m-0">
        </div>


        <div class="card-body">
            <!-- button aksi -->
            <?php if (is_admin()) : ?>
                <button title="Aksi admin" class="btn btn-secondary <?= !$is_review_started ? 'btn-disabled' : ''; ?>" data-toggle="modal" data-target="#modal-action-review" <?= !$is_review_started ? 'disabled' : ''; ?>><i class="fa fa-thumbs-up"></i> Aksi</button>
            <?php endif; ?>

            <!-- button tanggapan review 1 -->
            <?php if (is_null($reviewer_order) || $reviewer_order == 0) : ?>
                <button type="button" class="btn-modal-review btn <?= ($input->review1_notes != '' || $input->review1_notes_author != '') ? 'btn-success' : 'btn-outline-success'; ?> <?= !$is_review_started ? 'btn-disabled' : ''; ?>" data-toggle="modal" data-target="#modal-review" data-identifier="review1" <?= !$is_review_started ? 'disabled' : ''; ?> <?= ($level == 'reviewer' and $review1_remaining_time <= 0 and $input->review1_flag == '') ? 'disabled' : ''; ?>>Review #1
                    <?= ($input->review1_notes != '' || $input->review1_notes_author != '') ? '<i class="fa fa-check"></i>' : ''; ?></button>
                <?= ($level == 'reviewer' and $review1_remaining_time <= 0 and $input->review1_flag == '') ? '<span class="font-weight-bold text-danger" data-toggle="tooltip" data-placement="bottom" title="Hubungi admin untuk membuka draft ini"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>' : ''; ?>
            <?php endif; ?>

            <!-- button tanggapan review 2 -->
            <?php if (is_null($reviewer_order) || $reviewer_order == 1) : ?>
                <button type="button" class="btn-modal-review btn <?= ($input->review2_notes != '' || $input->review2_notes_author != '') ? 'btn-success' : 'btn-outline-success'; ?> <?= !$is_review_started ? 'btn-disabled' : ''; ?>" data-toggle="modal" data-target="#modal-review" data-identifier="review2" <?= !$is_review_started ? 'disabled' : ''; ?> <?= ($level == 'reviewer' and $review2_remaining_time <= 0 and $input->review2_flag == '') ? 'disabled' : ''; ?>>Review #2
                    <?= ($input->review2_notes != '' || $input->review2_notes_author != '') ? '<i class="fa fa-check"></i>' : ''; ?></button>
                <?= ($level == 'reviewer' and $review2_remaining_time <= 0 and $input->review2_flag == '') ? '<span class="font-weight-bold text-danger" data-toggle="tooltip" data-placement="bottom" title="Hubungi admin untuk membuka draft ini"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>' : ''; ?>
            <?php endif; ?>

            <?php
            // modal deadline review
            $this->load->view('draft/view/review/modal_deadline', [
                'progress' => 'review',
            ]);

            // modal aksi review
            $this->load->view('draft/view/review/modal_action', [
                'progress' => 'review'
            ]);

            // modal aksi review
            $this->load->view('draft/view/review/modal_review', [
                'progress' => 'review'
            ]);
            ?>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-select-reviewer" tabindex="-1" role="dialog" aria-labelledby="modal-select-reviewer" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> REVIEWER </h5>
            </div>
            <div class="modal-body">
                <form>
                    <fieldset>
                        <div class="form-group" id="form-reviewer">
                            <label for="user_id">Nama Reviewer</label>
                            <select id="reviewer-id" name="reviewer" class="form-control custom-select d-block"></select>
                        </div>
                    </fieldset>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit" id="btn-select-reviewer">Pilih</button>
                    </div>
                </form>
                <hr>

                <div id="reviewer-list-wrapper">
                    <div id="reviewer-list">
                        <p>Daftar Reviewer</p>
                        <?php if ($reviewers) : ?>
                            <?php $ii = 1; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0 nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">NIP</th>
                                            <th scope="col">Fakultas</th>
                                            <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
                                                <th style="width:100px; min-width:100px;"> &nbsp; </th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reviewers as $reviewer) : ?>
                                            <tr>
                                                <td class="align-middle">
                                                    <?= $ii++; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= $reviewer->reviewer_name; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= $reviewer->reviewer_nip; ?>
                                                </td>
                                                <td class="align-middle">
                                                    <?= $reviewer->faculty_name; ?>
                                                </td>
                                                <?php if ($level == 'superadmin' || $level == 'admin_penerbitan') : ?>
                                                    <td class="align-middle text-right">
                                                        <button title="Hapus" class="btn btn-sm btn-danger btn-delete-reviewer" data="<?= $reviewer->draft_reviewer_id; ?>">
                                                            <i class="fa fa-trash-alt"></i>
                                                            <span class="sr-only">Delete</span>
                                                        </button>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <p class="text-center text-muted my-3">Reviewer belum dipilih</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        const draft_id = $('input[name=draft_id]').val();

        // inisialisasi segment
        reload_review_segment()

        // ketika load segment, re-initialize call function-nya
        function reload_review_segment() {
            $('#review-progress-wrapper').load(' #review-progress', function() {
                // reinitiate modal after load
                init_flatpickr_modal()
            });
        }

        // get data ketika buka modal pilih penulis
        $('#review-progress-wrapper').on('click', '#btn-modal-select-reviewer', function() {
            //  open modal
            $('#modal-select-reviewer').modal('toggle')

            // get data semua reviewer
            $.get("<?= base_url('reviewer/api_get_reviewers'); ?>",
                function(res) {
                    //  inisialisasi select2
                    $('#reviewer-id').select2({
                        placeholder: '-- Pilih --',
                        dropdownParent: $('#modal-select-reviewer'),
                        allowClear: true,
                        data: res.data.map(r => {
                            return {
                                id: r.reviewer_id,
                                text: `${r.reviewer_name} - ${r.faculty_name}`,
                                faculty: r.faculty_name
                            }
                        })
                    });

                    //  reset selected data
                    $('[name=reviewer]').val(null).trigger('change');

                    //  event ketika data di select
                    $('#reviewer-id').on('select2:select', function(e) {
                        var data = e.params.data;
                        console.log(data);
                    });
                }
            )
        })

        // pilih reviewer
        $('#btn-select-reviewer').on('click', function() {
            const $this = $(this);
            $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
            const reviewer_id = $('#reviewer-id').val();

            $.ajax({
                type: "POST",
                url: "<?= base_url('draftreviewer/add'); ?>",
                datatype: "JSON",
                data: {
                    draft_id,
                    reviewer_id
                },
                success: function(res) {
                    show_toast(true, res.data);
                },
                error: function(err) {
                    show_toast(false, err.responseJSON.message);
                },
                complete: function() {
                    $('[name=reviewer]').val(null).trigger('change');
                    // reload segemen daftar reviewer
                    $('#reviewer-list-wrapper').load(' #reviewer-list');
                    // reload segmen review
                    reload_review_segment()
                    $this.removeAttr("disabled").html("Submit");
                },
            });
        });

        // hapus reviewer
        $('#modal-select-reviewer').on('click', '.btn-delete-reviewer', function() {
            $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
            let id = $(this).attr('data');

            $.ajax({
                url: "<?= base_url('draftreviewer/delete/'); ?>" + id,
                success: function(res) {
                    show_toast(true, res.data);
                },
                error: function(err) {
                    show_toast(false, err.responseJSON.message);
                },
                complete: function() {
                    // reload segemen daftar reviewer
                    $('#reviewer-list-wrapper').load(' #reviewer-list');
                    // reload segmen review
                    reload_review_segment()
                },
            })
        });

        // mulai review
        $('#review-progress-wrapper').on('click', '#btn-start-review', function() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('draft/api_start_progress/'); ?>" + draft_id,
                datatype: "JSON",
                data: {
                    progress: 'review'
                },
                success: function(res) {
                    show_toast(true, res.data);
                },
                error: function(err) {
                    show_toast(false, err.responseJSON.message);
                },
                complete: function() {
                    // reload segmen daftar reviewer
                    $('#reviewer-list-wrapper').load(' #reviewer-list');
                    // reload segmen review
                    reload_review_segment()
                    // reload progress
                    $('#progress-list-wrapper').load(' #progress-list');
                    // reload data draft
                    $('#draft-data-wrapper').load(' #draft-data');
                },
            })
        })














        // ---------------------------------------------------------------------------------------
        //panggil setingan validasi di ugmpress js
        loadValidateSetting();

        //validasi review1
        // $("#rev1form").validate({
        //         rules: {
        //             review1_file: {
        //                 require_from_group: [1, ".naskah"],
        //                 extension: "docx|doc|pdf",
        //                 filesize50: 52428200
        //             },
        //             reviewer1_file_link: {
        //                 curl: true,
        //                 require_from_group: [1, ".naskah"]
        //             }
        //         },
        //         errorElement: "span",
        //         errorClass: "none",
        //         validClass: "none",
        //         errorPlacement: function(error, element) {
        //             error.addClass("invalid-feedback");
        //             if (element.parent('.input-group').length) {
        //                 error.insertAfter(element.next('span.select2')); // input group
        //             } else if (element.hasClass("select2-hidden-accessible")) {
        //                 error.insertAfter(element.next('span.select2')); // select2
        //             } else if (element.parent().parent().hasClass('input-group')) {
        //                 error.insertAfter(element.closest('.input-group')); // fileinput append
        //             } else if (element.hasClass("custom-file-input")) {
        //                 error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
        //             } else if (element.hasClass("custom-control-input")) {
        //                 error.insertAfter($(".custom-radio").last()); // radio
        //             } else {
        //                 error.insertAfter(element); // default
        //             }
        //         },
        //         submitHandler: function(form) {
        //             var $this = $('#btn-upload-review1');
        //             $this.attr("disabled", "disabled").html(
        //                 "<i class='fa fa-spinner fa-spin '></i> Uploading ");
        //             let id = $('[name=draft_id]').val();
        //             var formData = new FormData(form);
        //             $.ajax({
        //                 url: "<?php echo base_url('draft/upload_progress/'); ?>" + id +
        //                     "/review1_file",
        //                 type: "post",
        //                 data: formData,
        //                 processData: false,
        //                 contentType: false,
        //                 cache: false,
        //                 success: function(data) {
        //                     let datax = JSON.parse(data);
        //                     console.log(datax);
        //                     $this.removeAttr("disabled").html("Upload");
        //                     if (datax.status == true) {
        //                         show_toast('111');
        //                     } else {
        //                         show_toast('000');
        //                     }
        //                     $('#modal-review1').load(' #modal-review1');
        //                 }
        //             });
        //             $resetform = $('#review1_file');
        //             $resetform.val('');
        //             $resetform.next('label.custom-file-label').html('');
        //             return false;
        //         }
        //     },
        //     validateSelect2()
        // );

        //validasi review2
        // $("#rev2form").validate({
        //         rules: {
        //             review2_file: {
        //                 require_from_group: [1, ".naskah"],
        //                 extension: "docx|doc|pdf",
        //                 filesize50: 52428200
        //             },
        //             reviewer2_file_link: {
        //                 curl: true,
        //                 require_from_group: [1, ".naskah"]
        //             }
        //         },
        //         errorElement: "span",
        //         errorClass: "none",
        //         validClass: "none",
        //         errorPlacement: function(error, element) {
        //             error.addClass("invalid-feedback");
        //             if (element.parent('.input-group').length) {
        //                 error.insertAfter(element.next('span.select2')); // input group
        //             } else if (element.hasClass("select2-hidden-accessible")) {
        //                 error.insertAfter(element.next('span.select2')); // select2
        //             } else if (element.parent().parent().hasClass('input-group')) {
        //                 error.insertAfter(element.closest('.input-group')); // fileinput append
        //             } else if (element.hasClass("custom-file-input")) {
        //                 error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
        //             } else if (element.hasClass("custom-control-input")) {
        //                 error.insertAfter($(".custom-radio").last()); // radio
        //             } else {
        //                 error.insertAfter(element); // default
        //             }
        //         },
        //         submitHandler: function(form) {
        //             var $this = $('#btn-upload-review2');
        //             $this.attr("disabled", "disabled").html(
        //                 "<i class='fa fa-spinner fa-spin '></i> Uploading ");
        //             let id = $('[name=draft_id]').val();
        //             var formData = new FormData(form);
        //             $.ajax({
        //                 url: "<?php echo base_url('draft/upload_progress/'); ?>" + id +
        //                     "/review2_file",
        //                 type: "post",
        //                 data: formData,
        //                 processData: false,
        //                 contentType: false,
        //                 cache: false,
        //                 success: function(data) {
        //                     let datax = JSON.parse(data);
        //                     console.log(datax);
        //                     $this.removeAttr("disabled").html("Upload");
        //                     if (datax.status == true) {
        //                         show_toast('111');
        //                     } else {
        //                         show_toast('000');
        //                     }
        //                     $('#modal-review2').load(' #modal-review2');
        //                 }
        //             });
        //             $resetform = $('#review2_file');
        //             $resetform.val('');
        //             $resetform.next('label.custom-file-label').html('');
        //             return false;
        //         }
        //     },
        //     validateSelect2()
        // );
    })
</script>