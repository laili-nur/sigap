<?php

use Carbon\Carbon;

$level                  = check_level();
$review1_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->review1_deadline, false);
$review2_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->review2_deadline, false);
$is_review_started      = format_datetime($input->review_start_date);

$data['keren'] = 'mantap jiwa jos gandos';
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
                        class="d-inline btn <?= (empty($reviewers)) ? 'btn-warning' : 'btn-secondary'; ?>"
                        title="Pilih Reviewer"
                    ><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih
                            Reviewer</span></button>
                    <?php endif; ?>
                    <?php if ($level == 'reviewer' || is_admin()) : ?>
                    <button
                        id="btn-start-review"
                        title="Mulai proses review"
                        type="button"
                        class="d-inline btn <?= !$is_review_started ? 'btn-warning' : 'btn-secondary'; ?> <?= empty($reviewers) || $is_review_started ? 'btn-disabled' : ''; ?>"
                        <?= empty($reviewers) || $is_review_started ? 'disabled' : ''; ?>
                    ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span> </button>
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
                <?php if (is_admin()) : ?>
                <a
                    href="#"
                    id="btn-modal-deadline-review"
                    title="Ubah deadline"
                    data-toggle="modal"
                    data-target="#modal-deadline-review"
                    data-identifier="review1"
                >Deadline reviewer #1 <i class="fas fa-edit fa-fw"></i></a>
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
                <a
                    href="#"
                    id="btn-modal-deadline-review"
                    title="Ubah deadline"
                    data-toggle="modal"
                    data-target="#modal-deadline-review"
                    data-identifier="review2"
                >Deadline reviewer #2 <i class="fas fa-edit fa-fw"></i></a>
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
                <a
                    href="#"
                    onclick="event.preventDefault()"
                    class="font-weight-bold"
                    data-toggle="popover"
                    data-placement="left"
                    data-container="body"
                    auto=""
                    right=""
                    data-html="true"
                    title=""
                    data-trigger="hover"
                    data-content="<?= $input->review_status; ?>"
                    data-original-title="Catatan Admin"
                >
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
            <button
                title="Aksi admin"
                class="btn btn-secondary <?= !$is_review_started ? 'btn-disabled' : ''; ?>"
                data-toggle="modal"
                data-target="#modal-action-review"
                <?= !$is_review_started ? 'disabled' : ''; ?>
            ><i class="fa fa-thumbs-up"></i> Aksi</button>
            <?php endif; ?>

            <!-- button tanggapan review 1 -->
            <?php if (is_null($reviewer_order) || $reviewer_order == 0) : ?>
            <button
                type="button"
                class="btn <?= ($input->review1_notes != '' || $input->review1_notes_author != '') ? 'btn-success' : 'btn-outline-success'; ?> <?= !$is_review_started ? 'btn-disabled' : ''; ?>"
                data-toggle="modal"
                data-target="#modal-review1"
                <?= !$is_review_started ? 'disabled' : ''; ?>
                <?= ($level == 'reviewer' and $review1_remaining_time <= 0 and $input->review1_flag == '') ? 'disabled' : ''; ?>
            >Review #1
                <?= ($input->review1_notes != '' || $input->review1_notes_author != '') ? '<i class="fa fa-check"></i>' : ''; ?></button>
            <?= ($level == 'reviewer' and $review1_remaining_time <= 0 and $input->review1_flag == '') ? '<span class="font-weight-bold text-danger" data-toggle="tooltip" data-placement="bottom" title="Hubungi admin untuk membuka draft ini"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>' : ''; ?>
            <?php endif; ?>

            <!-- button tanggapan review 2 -->
            <?php if (is_null($reviewer_order) || $reviewer_order == 1) : ?>
            <button
                type="button"
                class="btn <?= ($input->review2_notes != '' || $input->review2_notes_author != '') ? 'btn-success' : 'btn-outline-success'; ?> <?= !$is_review_started ? 'btn-disabled' : ''; ?>"
                data-toggle="modal"
                data-target="#review2"
                <?= !$is_review_started ? 'disabled' : ''; ?>
                <?= ($level == 'reviewer' and $review2_remaining_time <= 0 and $input->review2_flag == '') ? 'disabled' : ''; ?>
            >Review #2
                <?= ($input->review2_notes != '' || $input->review2_notes_author != '') ? '<i class="fa fa-check"></i>' : ''; ?></button>
            <?= ($level == 'reviewer' and $review2_remaining_time <= 0 and $input->review2_flag == '') ? '<span class="font-weight-bold text-danger" data-toggle="tooltip" data-placement="bottom" title="Hubungi admin untuk membuka draft ini"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>' : ''; ?>
            <?php endif; ?>
            <!-- <div
                class="modal fade"
                id="review1"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
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
                            <p class="font-weight-bold">NASKAH</p>
                            <?php if ($level == 'reviewer' or ($level == 'author' and $author_order == 1) or $level == 'superadmin' or $level == 'admin_penerbitan') : ?>
                            <div class="alert alert-info">Upload file naskah atau sertakan link naskah. Kosongi jika
                                file
                                naskah hard copy.</div>
                            <?= form_open_multipart('draft/upload_progress/' . $input->draft_id . '/review1_file', ' novalidate id="rev1form"'); ?>
                            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                            <div class="form-group">
                                <label for="review1_file">File Naskah</label>
                                <div class="custom-file">
                                    <?= form_upload('review1_file', '', 'class="custom-file-input naskah" id="review1_file"'); ?>
                                    <label
                                        class="custom-file-label"
                                        for="review1_file"
                                    >Pilih file</label>
                                </div>
                                <small class="form-text text-muted">Tipe file upload bertype : docx, doc, dan
                                    pdf.</small>
                            </div>
                            <div class="form-group">
                                <label for="reviewer1_file_link">Link Naskah</label>
                                <div>
                                    <?= form_input('reviewer1_file_link', $input->reviewer1_file_link, 'class="form-control naskah" id="reviewer1_file_link"'); ?>
                                </div>
                                <?= form_error('reviewer1_file_link'); ?>
                            </div>
                            <div class="form-group">
                                <button
                                    class="btn btn-primary "
                                    type="submit"
                                    value="Submit"
                                    id="btn-upload-review1"
                                ><i class="fa fa-upload"></i> Upload</button>
                            </div>
                            <?= form_close(); ?>
                            <?php endif; ?>
                            <div id="modal-review1">
                                <p>Last Upload :
                                    <?= format_datetime($input->review1_upload_date); ?>,
                                    <br> by :
                                    <?= konversi_username_level($input->review1_last_upload); ?>
                                    <?php if ($level != 'author' and $level != 'reviewer') : ?>
                                    <em>(<?= $input->review1_last_upload; ?>)</em>
                                    <?php endif; ?>
                                </p>
                                <?= (!empty($input->review1_file)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->review1_file . '" href="' . base_url('draftfile/' . $input->review1_file) . '" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                                <?= (!empty($input->reviewer1_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->reviewer1_file_link . '" href="' . $input->reviewer1_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                            </div>
                            <?= form_open('draft/api_update_draft/' . $input->draft_id, 'id="formreview1_krit" novalidate=""'); ?>
                            <?php if ($level != 'author') : ?>
                            <hr class="my-3">
                            <p class="font-weight-bold">REVIEW</p>
                            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria1_reviewer1"
                                    class="font-weight-bold"
                                >Substansi naskah (mencerminkan adanya kontribusi dan inovasi pada pengembangan iptek,
                                    seni,
                                    dan budaya) :</label>
                                <div>
                                    <?php
                                    $kriteria1_reviewer1 = array(
                                        'name'  => 'kriteria1_reviewer1',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria1_reviewer1',
                                        'rows'  => '6',
                                        'value' => $input->kriteria1_reviewer1,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria1_reviewer1);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria1_reviewer1) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_0', 1, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 1) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer1_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_0', 2, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 2) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer1_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_0', 3, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 3) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer1_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_0', 4, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 4) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer1_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_0', 5, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 5) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer1_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer1[0]) ? $input->nilai_reviewer1[0] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria2_reviewer1"
                                    class="font-weight-bold"
                                >Orisinalitas Karya dan bobot ilmiah :</label>
                                <div>
                                    <?php
                                    $kriteria2_reviewer1 = array(
                                        'name'  => 'kriteria2_reviewer1',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria2_reviewer1',
                                        'rows'  => '6',
                                        'value' => $input->kriteria2_reviewer1,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria2_reviewer1);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria2_reviewer1) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_1', 1, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer1_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_1', 2, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer1_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_1', 3, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer1_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_1', 4, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer1_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_1', 5, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer1_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer1[1]) ? $input->nilai_reviewer1[1] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria3_reviewer1"
                                    class="font-weight-bold"
                                >Kemutahiran Pustaka :</label>
                                <div>
                                    <?php
                                    $kriteria3_reviewer1 = array(
                                        'name'  => 'kriteria3_reviewer1',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria3_reviewer1',
                                        'rows'  => '6',
                                        'value' => $input->kriteria3_reviewer1,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria3_reviewer1);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria3_reviewer1) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_2', 1, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer1_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_2', 2, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer1_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_2', 3, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer1_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_2', 4, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer1_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_2', 5, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer1_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer1[2]) ? $input->nilai_reviewer1[2] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria4_reviewer1"
                                    class="font-weight-bold"
                                >Kelengkapan unsur (sebagai suatu naskah buku dan keterkaitan antarbab, sistematika)
                                    :</label>
                                <div>
                                    <?php
                                    $kriteria4_reviewer1 = array(
                                        'name'  => 'kriteria4_reviewer1',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria4_reviewer1',
                                        'rows'  => '6',
                                        'value' => $input->kriteria4_reviewer1,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria4_reviewer1);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria4_reviewer1) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_3', 1, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer1_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_3', 2, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer1_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_3', 3, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer1_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_3', 4, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer1_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer1_3', 5, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer1_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer1[3]) ? $input->nilai_reviewer1[3] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <?php if ($level != 'author') : ?>
                            <div id="total_reviewer1">
                                <?php if (!empty($draft->nilai_total_reviewer1)) {
                                        if ($draft->nilai_total_reviewer1 >= 400) {
                                            $hasil = '<div class="alert alert-success"><span class="badge badge-success">Naskah Lolos Review</span><br>';
                                            $hasil .= '<strong>Nilai total = ' . $draft->nilai_total_reviewer1 . '</strong><br>';
                                            $hasil .= 'Passing Grade = 400 <br>';
                                            $hasil .= '</div>';
                                        } else {
                                            $hasil = '<div class="alert alert-danger"><span class="badge badge-danger">Naskah Tidak Lolos Review</span><br>';
                                            $hasil .= '<strong>Nilai total = ' . $draft->nilai_total_reviewer1 . '</strong><br>';
                                            $hasil .= 'Passing Grade = 400 <br>';
                                            $hasil .= '</div>';
                                        }
                                        echo $hasil;
                                    }
                                ?>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <fieldset>
                                <?php if ($level != 'author') : ?>
                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="cr1"
                                        class="font-weight-bold"
                                    >Catatan Reviewer 1</label>
                                    <?php
                                    $optionscr1 = array(
                                        'name'  => 'review1_notes',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'cr1',
                                        'rows'  => '6',
                                        'value' => $input->review1_notes,
                                    );
                                    if ($level != 'reviewer') {
                                        echo '<div class="font-italic">' . nl2br($input->review1_notes) . '</div>';
                                    } else {
                                        echo form_textarea($optionscr1);
                                    }
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php if ($level == 'superadmin' or $level == 'admin_penerbitan' or $level == 'author') : ?>
                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="cr1a"
                                        class="font-weight-bold"
                                    >Catatan Admin untuk Penulis</label>
                                    <?php
                                    $optionscr1a = array(
                                        'name'  => 'catatan_review1_admin',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'cr1a',
                                        'rows'  => '6',
                                        'value' => $input->catatan_review1_admin,
                                    );
                                    if ($level == 'superadmin' or $level == 'admin_penerbitan') {
                                        echo form_textarea($optionscr1a);
                                    } elseif ($level == 'author') {
                                        echo '<div class="font-italic">' . nl2br($input->catatan_review1_admin) . '</div>';
                                    } else {
                                    }
                                    ?>
                                </div>
                                <?php endif; ?>
                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="crp1"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    $optionscrp1 = array(
                                        'name'  => 'review1_notes_author',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'crp1',
                                        'rows'  => '6',
                                        'value' => $input->review1_notes_author,
                                    );
                                    if ($level != 'author' or $author_order != 1) {
                                        echo '<div class="font-italic">' . nl2br($input->review1_notes_author) . '</div>';
                                    } else {
                                        echo form_textarea($optionscrp1);
                                    }
                                    ?>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <?php if ($level == 'reviewer') : ?>
                            <div class="card-footer-content text-muted p-0 m-0">
                                <div class="mb-1 font-weight-bold">Rekomendasi</div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('review1_flag', 'y', isset($input->review1_flag) && ($input->review1_flag == 'y') ? true : false, 'required class="custom-control-input" id="review1_flagy"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="review1_flagy"
                                    >Setuju</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('review1_flag', 'n', isset($input->review1_flag) && ($input->review1_flag == 'n') ? true : false, 'required class="custom-control-input" id="review1_flagn"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="review1_flagn"
                                    >Tidak</label>
                                </div>
                            </div>
                            <button
                                class="btn btn-primary ml-auto"
                                type="submit"
                                value="Submit"
                                id="btn-submit-review1-rev"
                            >Submit</button>
                            <?php else : ?>
                            <button
                                class="btn btn-primary ml-auto"
                                type="submit"
                                value="Submit"
                                id="btn-submit-review1-other"
                            >Submit</button>
                            <?php endif; ?>
                            <button
                                type="button"
                                class="btn btn-light"
                                data-dismiss="modal"
                            >Close</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div> -->
            <!-- <div
                class="modal fade"
                id="review2"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog modal-lg modal-dialog-overflow"
                    role="document"
                >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Progress Review 2</h5>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bold">NASKAH</p>
                            <?php if ($level == 'reviewer' or ($level == 'author' and $author_order == 1) or $level == 'superadmin' or $level == 'admin_penerbitan') : ?>
                            <?= form_open('draft/upload_progress/' . $input->draft_id . '/review2_file', 'novalidate id="rev2form"'); ?>
                            <div class="alert alert-info">Upload file naskah atau sertakan link naskah. Kosongi jika
                                file
                                naskah hard copy.</div>
                            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : 'No data'; ?>
                            <div class="form-group">
                                <label for="review2_file">File Naskah</label>
                                <div class="custom-file">
                                    <?= form_upload('review2_file', '', 'class="custom-file-input naskah" id="review2_file"'); ?>
                                    <label
                                        class="custom-file-label"
                                        for="review2_file"
                                    >Pilih file</label>
                                </div>
                                <small class="form-text text-muted">Tipe file upload bertype : docx, doc, dan
                                    pdf.</small>
                            </div>
                            <div class="form-group">
                                <label for="reviewer2_file_link">Link Naskah</label>
                                <div>
                                    <?= form_input('reviewer2_file_link', $input->reviewer2_file_link, 'class="form-control naskah" id="reviewer2_file_link"'); ?>
                                </div>
                                <?= form_error('reviewer2_file_link'); ?>
                            </div>
                            <div class="form-group">
                                <button
                                    class="btn btn-primary "
                                    type="submit"
                                    value="Submit"
                                    id="btn-upload-review2"
                                ><i class="fa fa-upload"></i> Upload</button>
                            </div>
                            <?= form_close(); ?>
                            <?php endif; ?>
                            <div id="modal-review2">
                                <p>Last Upload :
                                    <?= format_datetime($input->review2_upload_date); ?>,
                                    <br> by :
                                    <?= konversi_username_level($input->review2_last_upload); ?>
                                    <?php if ($level != 'author' and $level != 'reviewer') : ?>
                                    <em>(<?= $input->review2_last_upload; ?>)</em>
                                    <?php endif; ?>
                                </p>
                                <?= (!empty($input->review2_file)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->review2_file . '" href="' . base_url('draftfile/' . $input->review2_file) . '" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                                <?= (!empty($input->reviewer2_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->reviewer2_file_link . '" href="' . $input->reviewer2_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                            </div>
                            <?= form_open('draft/api_update_draft/' . $input->draft_id, 'id="formreview2_krit" novalidate=""'); ?>
                            <?php if ($level != 'author') : ?>
                            <hr class="my-3">
                            <p class="font-weight-bold">REVIEW</p>
                            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria1_reviewer2"
                                    class="font-weight-bold"
                                >Substansi naskah (mencerminkan adanya kontribusi dan inovasi pada pengembangan iptek,
                                    seni,
                                    dan budaya) :</label>
                                <div>
                                    <?php
                                    $kriteria1_reviewer2 = array(
                                        'name'  => 'kriteria1_reviewer2',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria1_reviewer2',
                                        'rows'  => '6',
                                        'value' => $input->kriteria1_reviewer2,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria1_reviewer2);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria1_reviewer2) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_0', 1, isset($input->nilai_reviewer2[0]) && ($input->nilai_reviewer2[0] == 1) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer2_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer2_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_0', 2, isset($input->nilai_reviewer2[0]) && ($input->nilai_reviewer2[0] == 2) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer2_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer2_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_0', 3, isset($input->nilai_reviewer2[0]) && ($input->nilai_reviewer2[0] == 3) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer2_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer2_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_0', 4, isset($input->nilai_reviewer2[0]) && ($input->nilai_reviewer2[0] == 4) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer2_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer2_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_0', 5, isset($input->nilai_reviewer2[0]) && ($input->nilai_reviewer2[0] == 5) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer2_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria1_reviewer2_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer2[0]) ? $input->nilai_reviewer2[0] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria2_reviewer2"
                                    class="font-weight-bold"
                                >Orisinalitas Karya dan bobot ilmiah :</label>
                                <div>
                                    <?php
                                    $kriteria2_reviewer2 = array(
                                        'name'  => 'kriteria2_reviewer2',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria2_reviewer2',
                                        'rows'  => '6',
                                        'value' => $input->kriteria2_reviewer2,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria2_reviewer2);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria2_reviewer2) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_1', 1, isset($input->nilai_reviewer2[1]) && ($input->nilai_reviewer2[1] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer2_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer2_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_1', 2, isset($input->nilai_reviewer2[1]) && ($input->nilai_reviewer2[1] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer2_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer2_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_1', 3, isset($input->nilai_reviewer2[1]) && ($input->nilai_reviewer2[1] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer2_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer2_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_1', 4, isset($input->nilai_reviewer2[1]) && ($input->nilai_reviewer2[1] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer2_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer2_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_1', 5, isset($input->nilai_reviewer2[1]) && ($input->nilai_reviewer2[1] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer2_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria2_reviewer2_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer2[1]) ? $input->nilai_reviewer2[1] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria3_reviewer2"
                                    class="font-weight-bold"
                                >Kemutahiran Pustaka :</label>
                                <div>
                                    <?php
                                    $kriteria3_reviewer2 = array(
                                        'name'  => 'kriteria3_reviewer2',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria3_reviewer2',
                                        'rows'  => '6',
                                        'value' => $input->kriteria3_reviewer2,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria3_reviewer2);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria3_reviewer2) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_2', 1, isset($input->nilai_reviewer2[2]) && ($input->nilai_reviewer2[2] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer2_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer2_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_2', 2, isset($input->nilai_reviewer2[2]) && ($input->nilai_reviewer2[2] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer2_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer2_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_2', 3, isset($input->nilai_reviewer2[2]) && ($input->nilai_reviewer2[2] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer2_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer2_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_2', 4, isset($input->nilai_reviewer2[2]) && ($input->nilai_reviewer2[2] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer2_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer2_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_2', 5, isset($input->nilai_reviewer2[2]) && ($input->nilai_reviewer2[2] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer2_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria3_reviewer2_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer2[2]) ? $input->nilai_reviewer2[2] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="alert alert-info">
                                <label
                                    for="kriteria4_reviewer2"
                                    class="font-weight-bold"
                                >Kelengkapan unsur (sebagai suatu naskah buku dan keterkaitan antarbab, sistematika)
                                    :</label>
                                <div>
                                    <?php
                                    $kriteria4_reviewer2 = array(
                                        'name'  => 'kriteria4_reviewer2',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'kriteria4_reviewer2',
                                        'rows'  => '6',
                                        'value' => $input->kriteria4_reviewer2,
                                    );
                                    if ($level == 'reviewer') {
                                        echo form_textarea($kriteria4_reviewer2);
                                    } else {
                                        echo '<div class="font-italic">' . nl2br($input->kriteria4_reviewer2) . '</div>';
                                    }
                                    ?>
                                </div>
                                <?php if ($level == 'reviewer') : ?>
                                <p class="m-0 p-0">Nilai</p>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_3', 1, isset($input->nilai_reviewer2[3]) && ($input->nilai_reviewer2[3] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer2_1"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer2_1"
                                    >1</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_3', 2, isset($input->nilai_reviewer2[3]) && ($input->nilai_reviewer2[3] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer2_2"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer2_2"
                                    >2</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_3', 3, isset($input->nilai_reviewer2[3]) && ($input->nilai_reviewer2[3] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer2_3"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer2_3"
                                    >3</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_3', 4, isset($input->nilai_reviewer2[3]) && ($input->nilai_reviewer2[3] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer2_4"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer2_4"
                                    >4</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('nilai_reviewer2_3', 5, isset($input->nilai_reviewer2[3]) && ($input->nilai_reviewer2[3] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer2_5"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="nilai_kriteria4_reviewer2_5"
                                    >5</label>
                                </div>
                                <?php else : ?>
                                <p class="m-0 p-0">Nilai =
                                    <?= isset($input->nilai_reviewer2[3]) ? $input->nilai_reviewer2[3] : ''; ?>
                                </p>
                                <?php endif; ?>
                            </div>
                            <?php if ($level != 'author') : ?>
                            <div id="total_reviewer2">
                                <?php if (!empty($draft->nilai_total_reviewer2)) {
                                        if ($draft->nilai_total_reviewer2 >= 400) {
                                            $hasil = '<div class="alert alert-success"><span class="badge badge-success">Naskah Lolos Review</span><br>';
                                            $hasil .= '<strong>Nilai total = ' . $draft->nilai_total_reviewer2 . '</strong><br>';
                                            $hasil .= 'Passing Grade = 400 <br>';
                                            $hasil .= '</div>';
                                        } else {
                                            $hasil = '<div class="alert alert-danger"><span class="badge badge-danger">Naskah Tidak Lolos Review</span><br>';
                                            $hasil .= '<strong>Nilai total = ' . $draft->nilai_total_reviewer2 . '</strong><br>';
                                            $hasil .= 'Passing Grade = 400 <br>';
                                            $hasil .= '</div>';
                                        }
                                        echo $hasil;
                                    }
                                ?>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                            <fieldset>
                                <?php if ($level != 'author') : ?>
                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="cr2"
                                        class="font-weight-bold"
                                    >Catatan Reviewer 2</label>
                                    <?php
                                    $optionscr2 = array(
                                        'name'  => 'review2_notes',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'cr2',
                                        'rows'  => '6',
                                        'value' => $input->review2_notes,
                                    );
                                    if ($level != 'reviewer') {
                                        echo '<div class="font-italic">' . nl2br($input->review2_notes) . '</div>';
                                    } else {
                                        echo form_textarea($optionscr2);
                                    }
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php if ($level == 'superadmin' or $level == 'admin_penerbitan' or $level == 'author') : ?>
                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="cr2a"
                                        class="font-weight-bold"
                                    >Catatan Admin untuk Penulis</label>
                                    <?php
                                    $optionscr2a = array(
                                        'name'  => 'catatan_review2_admin',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'cr2a',
                                        'rows'  => '6',
                                        'value' => $input->catatan_review2_admin,
                                    );
                                    if ($level == 'superadmin' or $level == 'admin_penerbitan') {
                                        echo form_textarea($optionscr2a);
                                    } elseif ($level == 'author') {
                                        echo '<div class="font-italic">' . nl2br($input->catatan_review2_admin) . '</div>';
                                    } else {
                                    }
                                    ?>
                                </div>
                                <?php endif; ?>
                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="crp2"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    $optionscrp2 = array(
                                        'name'  => 'review2_notes_author ',
                                        'class' => 'form-control summernote-basic',
                                        'id'    => 'crp2',
                                        'rows'  => '6',
                                        'value' => $input->review2_notes_author,
                                    );
                                    if ($level != 'author' or $author_order != 1) {
                                        echo '<div class="font-italic">' . nl2br($input->review2_notes_author) . '</div>';
                                    } else {
                                        echo form_textarea($optionscrp2);
                                    }
                                    ?>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <?php if ($level == 'reviewer') : ?>
                            <div class="card-footer-content text-muted p-0 m-0">
                                <div class="mb-1 font-weight-bold">Rekomendasi</div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('review2_flag', 'y', isset($input->review2_flag) && ($input->review2_flag == 'y') ? true : false, 'required class="custom-control-input" id="review2_flagy"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="review2_flagy"
                                    >Setuju</label>
                                </div>
                                <div class="custom-control custom-control-inline custom-radio">
                                    <?= form_radio('review2_flag', 'n', isset($input->review2_flag) && ($input->review2_flag == 'n') ? true : false, 'required class="custom-control-input" id="review2_flagn"'); ?>
                                    <label
                                        class="custom-control-label"
                                        for="review2_flagn"
                                    >Tidak</label>
                                </div>
                            </div>
                            <button
                                class="btn btn-primary ml-auto"
                                type="submit"
                                value="Submit"
                                id="btn-submit-review2-rev"
                            >Submit</button>
                            <?php else : ?>
                            <button
                                class="btn btn-primary ml-auto"
                                type="submit"
                                value="Submit"
                                id="btn-submit-review2-other"
                            >Submit</button>
                            <?php endif; ?>
                            <button
                                type="button"
                                class="btn btn-light"
                                data-dismiss="modal"
                            >Close</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div> -->

            <?php
            // modal deadline review
            $this->load->view('draft/view/review/modal_deadline', [
                'progress' => 'review',
            ]);

            // modal aksi review
            $this->load->view('draft/view/review/modal_action', [
                'progress' => 'review'
            ]);
            ?>
        </div>
    </div>
    </div>
</section>

<div
    class="modal fade"
    id="modal-select-reviewer"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-select-reviewer"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> REVIEWER </h5>
            </div>
            <div class="modal-body">
                <form>
                    <fieldset>
                        <div
                            class="form-group"
                            id="form-reviewer"
                        >
                            <label for="user_id">Nama Reviewer</label>
                            <select
                                id="reviewer-id"
                                name="reviewer"
                                class="form-control custom-select d-block"
                            ></select>
                        </div>
                    </fieldset>
                    <div class="d-flex justify-content-end">
                        <button
                            class="btn btn-primary"
                            type="submit"
                            id="btn-select-reviewer"
                        >Pilih</button>
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
                                            <button
                                                title="Hapus"
                                                class="btn btn-sm btn-danger btn-delete-reviewer"
                                                data="<?= $reviewer->draft_reviewer_id; ?>"
                                            >
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
                <button
                    type="button"
                    class="btn btn-light"
                    data-dismiss="modal"
                >Close</button>
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
    $("#rev1form").validate({
            rules: {
                review1_file: {
                    require_from_group: [1, ".naskah"],
                    dokumen: "docx|doc|pdf",
                    filesize50: 52428200
                },
                reviewer1_file_link: {
                    curl: true,
                    require_from_group: [1, ".naskah"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.next('span.select2')); // input group
                } else if (element.hasClass("select2-hidden-accessible")) {
                    error.insertAfter(element.next('span.select2')); // select2
                } else if (element.parent().parent().hasClass('input-group')) {
                    error.insertAfter(element.closest('.input-group')); // fileinput append
                } else if (element.hasClass("custom-file-input")) {
                    error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
                } else if (element.hasClass("custom-control-input")) {
                    error.insertAfter($(".custom-radio").last()); // radio
                } else {
                    error.insertAfter(element); // default
                }
            },
            submitHandler: function(form) {
                var $this = $('#btn-upload-review1');
                $this.attr("disabled", "disabled").html(
                    "<i class='fa fa-spinner fa-spin '></i> Uploading ");
                let id = $('[name=draft_id]').val();
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url('draft/upload_progress/'); ?>" + id +
                        "/review1_file",
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        let datax = JSON.parse(data);
                        console.log(datax);
                        $this.removeAttr("disabled").html("Upload");
                        if (datax.status == true) {
                            show_toast('111');
                        } else {
                            show_toast('000');
                        }
                        $('#modal-review1').load(' #modal-review1');
                    }
                });
                $resetform = $('#review1_file');
                $resetform.val('');
                $resetform.next('label.custom-file-label').html('');
                return false;
            }
        },
        validateSelect2()
    );

    //validasi review2
    $("#rev2form").validate({
            rules: {
                review2_file: {
                    require_from_group: [1, ".naskah"],
                    dokumen: "docx|doc|pdf",
                    filesize50: 52428200
                },
                reviewer2_file_link: {
                    curl: true,
                    require_from_group: [1, ".naskah"]
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.next('span.select2')); // input group
                } else if (element.hasClass("select2-hidden-accessible")) {
                    error.insertAfter(element.next('span.select2')); // select2
                } else if (element.parent().parent().hasClass('input-group')) {
                    error.insertAfter(element.closest('.input-group')); // fileinput append
                } else if (element.hasClass("custom-file-input")) {
                    error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
                } else if (element.hasClass("custom-control-input")) {
                    error.insertAfter($(".custom-radio").last()); // radio
                } else {
                    error.insertAfter(element); // default
                }
            },
            submitHandler: function(form) {
                var $this = $('#btn-upload-review2');
                $this.attr("disabled", "disabled").html(
                    "<i class='fa fa-spinner fa-spin '></i> Uploading ");
                let id = $('[name=draft_id]').val();
                var formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url('draft/upload_progress/'); ?>" + id +
                        "/review2_file",
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(data) {
                        let datax = JSON.parse(data);
                        console.log(datax);
                        $this.removeAttr("disabled").html("Upload");
                        if (datax.status == true) {
                            show_toast('111');
                        } else {
                            show_toast('000');
                        }
                        $('#modal-review2').load(' #modal-review2');
                    }
                });
                $resetform = $('#review2_file');
                $resetform.val('');
                $resetform.next('label.custom-file-label').html('');
                return false;
            }
        },
        validateSelect2()
    );

    $('#btn-submit-review1-rev').on('click', function() {
        var $this = $(this);
        let id = $('[name=draft_id]').val();
        let cr1 = $('#cr1').val();
        let crp1 = $('#crp1').val();
        let rev1_flag = $('[name=review1_flag]:checked').val();
        let kriteria1_reviewer1 = $('#kriteria1_reviewer1').val();
        let kriteria2_reviewer1 = $('#kriteria2_reviewer1').val();
        let kriteria3_reviewer1 = $('#kriteria3_reviewer1').val();
        let kriteria4_reviewer1 = $('#kriteria4_reviewer1').val();
        let nilai_reviewer1_0 = $('[name=nilai_reviewer1_0]:checked').val();
        let nilai_reviewer1_1 = $('[name=nilai_reviewer1_1]:checked').val();
        let nilai_reviewer1_2 = $('[name=nilai_reviewer1_2]:checked').val();
        let nilai_reviewer1_3 = $('[name=nilai_reviewer1_3]:checked').val();
        let nilai_reviewer1 = [nilai_reviewer1_0, nilai_reviewer1_1, nilai_reviewer1_2,
            nilai_reviewer1_3
        ];
        if (nilai_reviewer1_0 == null || nilai_reviewer1_1 == null || nilai_reviewer1_2 == null ||
            nilai_reviewer1_3 == null) {
            show_toast('penilaian');
            return false;
        }
        if (rev1_flag == null) {
            show_toast('flag');
            return false;
        }
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + id + "/1",
            datatype: "JSON",
            data: {
                review1_notes: cr1,
                review1_notes_author: crp1,
                review1_flag: rev1_flag,
                kriteria1_reviewer1: kriteria1_reviewer1,
                kriteria2_reviewer1: kriteria2_reviewer1,
                kriteria3_reviewer1: kriteria3_reviewer1,
                kriteria4_reviewer1: kriteria4_reviewer1,
                nilai_reviewer1: nilai_reviewer1
            },
            success: function(data) {
                let datax = JSON.parse(data);
                console.log(datax)
                $this.removeAttr("disabled").html("Submit");
                if (datax.status == true) {
                    show_toast('111');
                } else {
                    show_toast('000');
                }
                $('#total_reviewer1').load(' #total_reviewer1');
                $('#review1').modal('toggle');
            }
        });
        return false;
    });

    $('#btn-submit-review1-other').on('click', function() {
        var $this = $(this);
        let id = $('[name=draft_id]').val();
        let cr1 = $('#cr1').val();
        let cr1a = $('#cr1a').val();
        let crp1 = $('#crp1').val();
        let rev1_flag = $('[name=review1_flag]:checked').val();
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + id,
            datatype: "JSON",
            data: {
                catatan_review1_admin: cr1a,
                review1_notes: cr1,
                review1_notes_author: crp1,
                review1_flag: rev1_flag,
            },
            success: function(data) {
                let datax = JSON.parse(data);
                console.log(datax)
                $this.removeAttr("disabled").html("Submit");
                if (datax.status == true) {
                    show_toast('111');
                } else {
                    show_toast('000');
                }
                $('#list-group-review').load(' #list-group-review');
                $('#review1').modal('toggle');
            }
        });
        return false;
    });

    $('#btn-submit-review2-rev').on('click', function() {
        var $this = $(this);
        let id = $('[name=draft_id]').val();
        let cr2 = $('#cr2').val();
        let crp2 = $('#crp2').val();
        let rev2_flag = $('[name=review2_flag]:checked').val();
        let kriteria1_reviewer2 = $('#kriteria1_reviewer2').val();
        let kriteria2_reviewer2 = $('#kriteria2_reviewer2').val();
        let kriteria3_reviewer2 = $('#kriteria3_reviewer2').val();
        let kriteria4_reviewer2 = $('#kriteria4_reviewer2').val();
        let nilai_reviewer2_0 = $('[name=nilai_reviewer2_0]:checked').val();
        let nilai_reviewer2_1 = $('[name=nilai_reviewer2_1]:checked').val();
        let nilai_reviewer2_2 = $('[name=nilai_reviewer2_2]:checked').val();
        let nilai_reviewer2_3 = $('[name=nilai_reviewer2_3]:checked').val();
        let nilai_reviewer2 = [nilai_reviewer2_0, nilai_reviewer2_1, nilai_reviewer2_2,
            nilai_reviewer2_3
        ];
        if (nilai_reviewer2_0 == null || nilai_reviewer2_1 == null || nilai_reviewer2_2 == null ||
            nilai_reviewer2_3 == null) {
            show_toast('penilaian');
            return false;
        }
        if (rev2_flag == null) {
            show_toast('flag');
            return false;
        }
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + id + "/2",
            datatype: "JSON",
            data: {
                review2_notes: cr2,
                review2_notes_author: crp2,
                review2_flag: rev2_flag,
                kriteria1_reviewer2: kriteria1_reviewer2,
                kriteria2_reviewer2: kriteria2_reviewer2,
                kriteria3_reviewer2: kriteria3_reviewer2,
                kriteria4_reviewer2: kriteria4_reviewer2,
                nilai_reviewer2: nilai_reviewer2

            },
            success: function(data) {
                let datax = JSON.parse(data);
                console.log(datax)
                $this.removeAttr("disabled").html("Submit");
                if (datax.status == true) {
                    show_toast('111');
                } else {
                    show_toast('000');
                }
                $('#total_reviewer2').load(' #total_reviewer2');
                $('#review2').modal('toggle');
            }
        });
        return false;
    });

    $('#btn-submit-review2-other').on('click', function() {
        var $this = $(this);
        let id = $('[name=draft_id]').val();
        let cr2 = $('#cr2').val();
        let cr2a = $('#cr2a').val();
        let crp2 = $('#crp2').val();
        let rev2_flag = $('[name=review2_flag]:checked').val();
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + id,
            datatype: "JSON",
            data: {
                catatan_review2_admin: cr2a,
                review2_notes: cr2,
                review2_notes_author: crp2,
                review2_flag: rev2_flag,
            },
            success: function(data) {
                let datax = JSON.parse(data);
                console.log(datax)
                $this.removeAttr("disabled").html("Submit");
                if (datax.status == true) {
                    show_toast('111');
                } else {
                    show_toast('000');
                }
                $('#list-group-review').load(' #list-group-review');
                $('#review2').modal('toggle');
            }
        });
        return false;
    });

})
</script>