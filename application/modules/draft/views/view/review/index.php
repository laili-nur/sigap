<?php

use Carbon\Carbon;

$level                  = check_level();
$review1_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->review1_deadline, false);
$review2_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->review2_deadline, false);
$is_review_started      = format_datetime($input->review_start_date);
$is_review1_notes_populated = $input->review1_notes || $input->review1_notes_author || $input->review1_notes_admin ? true : false;
$is_review1_files_populated = $input->review1_file || $input->review1_file_link ? true : false;
$is_review2_notes_populated = $input->review2_notes || $input->review2_notes_author || $input->review2_notes_admin ? true : false;
$is_review2_files_populated = $input->review2_file || $input->review2_file_link ? true : false;
?>

<section
    id="review-progress-wrapper"
    class="card"
>
    <div id="review-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Review</span>
                <div class="card-header-control">
                    <?php if (is_admin()) : ?>
                        <button
                            id="btn-modal-select-reviewer"
                            type="button"
                            class="d-inline btn <?= empty($reviewers) ? 'btn-warning' : 'btn-secondary'; ?>"
                            title="Pilih Reviewer"
                        ><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih Reviewer</span></button>
                    <?php endif; ?>
                    <?php if (($level == 'reviewer' || is_admin()) && !$is_final) : ?>
                        <button
                            id="btn-start-review"
                            title="Mulai proses review"
                            type="button"
                            class="d-inline btn <?= !$is_review_started ? 'btn-warning' : 'btn-secondary'; ?> <?= empty($reviewers) || $is_review_started ? 'btn-disabled' : ''; ?>"
                            <?= empty($reviewers) || $is_review_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
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

        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-review"
        >

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
                    <?php if (is_admin() && !$is_final) : ?>
                        <a
                            href="#"
                            id="btn-modal-deadline-review1"
                            title="Ubah deadline"
                            data-toggle="modal"
                            data-target="#modal-deadline-review1"
                        >Deadline review #1 <i class="fas fa-edit fa-fw"></i></a>
                    <?php else : ?>
                        <span class="text-muted">Deadline reviewer #1</span>
                    <?php endif ?>
                    <strong>
                        <?= ($review1_remaining_time <= 0 && $input->review1_flag == '')
                            ? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">' . format_datetime($input->review1_deadline) . '</span>'
                            : format_datetime($input->review1_deadline); ?>
                    </strong>
                </div>
            <?php endif; ?>

            <!-- reviewer 2 hanya bisa melihat deadline reviewer 2 -->
            <!-- staff/admin bisa melihat semua -->
            <?php if (is_null($reviewer_order) || $reviewer_order == 1) : ?>
                <div class="list-group-item justify-content-between">
                    <?php if (is_admin() && !$is_final) : ?>
                        <a
                            href="#"
                            id="btn-modal-deadline-review2"
                            title="Ubah deadline"
                            data-toggle="modal"
                            data-target="#modal-deadline-review2"
                        >Deadline review #2 <i class="fas fa-edit fa-fw"></i></a>
                    <?php else : ?>
                        <span class="text-muted">Deadline reviewer #2</span>
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
                <span>
                    <?php if ($input->is_review == 'n' && $input->draft_status == 99) : ?>
                        <span class="text-danger">
                            <i class="fa fa-times"></i>
                            <span>Review Ditolak</span>
                        </span>
                    <?php elseif ($input->is_review == 'y') : ?>
                        <span class="text-success">
                            <i class="fa fa-check"></i>
                            <span>Review Selesai</span>
                        </span>
                    <?php endif ?>
                </span>
            </div>

            <div class="m-3">
                <div class="text-muted pb-1">Catatan Admin</div>
                <?= $input->review_status; ?>
            </div>

            <hr class="m-0">
        </div>


        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin() && !$is_final) : ?>
                    <button
                        title="Aksi admin"
                        class="btn btn-outline-dark <?= !$is_review_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-review"
                        <?= !$is_review_started ? 'disabled' : ''; ?>
                    >Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan review 1 -->
                <?php if (is_null($reviewer_order) || $reviewer_order == 0) : ?>
                    <button
                        type="button"
                        class="btn btn-outline-success <?= !$is_review_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-review1"
                        <?= !$is_review_started ? 'disabled' : ''; ?>
                        <?= ($level == 'reviewer' && $review1_remaining_time <= 0 && $input->review1_flag == '') ? 'disabled' : ''; ?>
                    >
                        <span>Progress Review #1
                            <?= $is_review1_notes_populated ? '<i class="far fa-comments"></i>' : '' ?>
                            <?= $is_review1_files_populated ? '<i class="far fa-file-alt"></i>' : '' ?>
                        </span>
                    </button>
                <?php endif; ?>

                <!-- button tanggapan review 2 -->
                <?php if (is_null($reviewer_order) || $reviewer_order == 1) : ?>
                    <button
                        type="button"
                        class="btn btn-outline-success <?= !$is_review_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-review2"
                        <?= !$is_review_started ? 'disabled' : ''; ?>
                        <?= ($level == 'reviewer' and $review2_remaining_time <= 0 and $input->review2_flag == '') ? 'disabled' : ''; ?>
                    >
                        <span>Progress Review #2
                            <?= $is_review2_notes_populated ? '<i class="far fa-comments"></i>' : '' ?>
                            <?= $is_review2_files_populated ? '<i class="far fa-file-alt"></i>' : '' ?>
                        </span>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <?php
        // modal deadline review1
        $this->load->view('draft/view/common/deadline_modal', [
            'progress' => 'review1',
        ]);
        // modal deadline review2
        $this->load->view('draft/view/common/deadline_modal', [
            'progress' => 'review2',
        ]);

        // modal aksi review
        $this->load->view('draft/view/common/action_modal', [
            'progress' => 'review'
        ]);

        // modal progress review
        $this->load->view('draft/view/review/review_modal', [
            'progress' => 'review1'
        ]);
        $this->load->view('draft/view/review/review_modal', [
            'progress' => 'review2'
        ]);

        // modal pilih reviewer
        $this->load->view('draft/view/review/select_reviewer_modal');
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const draft_id = $('input[name=draft_id]').val();

    // inisialisasi segment
    reload_review_segment()

    // ketika load segment, re-initialize call function-nya
    function reload_review_segment() {
        $('#review-progress-wrapper').load(' #review-progress', function() {
            // reinitiate modal after load
            initFlatpickrModal()
        });
    }

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
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen review
                reload_review_segment()
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
                // reload data draft
                $('#draft-data-wrapper').load(' #draft-data');
            },
        })
    })
})
</script>
