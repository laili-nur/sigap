<?php

use Carbon\Carbon;

$level = check_level();
$layout_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->layout_deadline, false);
$is_layout_started      = format_datetime($input->layout_start_date);
$is_layout_notes_populated = $input->layout_notes || $input->layout_notes_author ? true : false;
$is_layout_files_populated = $input->layout_file || $input->layout_file_link ? true : false;
$is_cover_notes_populated = $input->cover_notes || $input->cover_notes_author ? true : false;
$is_cover_files_populated = $input->cover_file || $input->cover_file_link ? true : false;
?>
<section
    id="layout-progress-wrapper"
    class="card"
>
    <div id="layout-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Layouting</span>
                <div class="card-header-control">
                    <?php if (is_admin()) : ?>
                        <button
                            id="btn-modal-select-layouter"
                            type="button"
                            class="d-inline btn <?= empty($layouters) ? 'btn-warning' : 'btn-secondary'; ?>"
                            title="Pilih layouter"
                        ><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih Layouter</span></button>
                    <?php endif; ?>
                    <?php if (($level == 'layouter' || is_admin()) && !$is_final) : ?>
                        <button
                            id="btn-start-layout"
                            title="Mulai proses layouting"
                            type="button"
                            class="d-inline btn <?= !$is_layout_started ? 'btn-warning' : 'btn-secondary'; ?> <?= empty($layouters) || $is_layout_started ? 'btn-disabled' : ''; ?>"
                            <?= empty($layouters) || $is_layout_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                        <button
                            id="btn-finish-layout"
                            title="Selesai proses layouting"
                            type="button"
                            class="d-inline btn btn-secondary"
                            <?= !$is_layout_started ? 'disabled' : '' ?>
                        ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <?php if ($layouters == null && is_admin()) : ?>
            <div class="alert alert-warning mb-1"><strong>PERHATIAN!</strong> Pilih layouter terlebih dahulu sebelum mulai proses layouting</div>
        <?php endif; ?>
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-layout"
        >

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong>
                    <?= format_datetime($input->layout_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong>
                    <?= format_datetime($input->layout_end_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <?php if (is_admin()) : ?>
                    <a
                        href="#"
                        id="btn-modal-deadline-layout"
                        title="Ubah deadline"
                        data-toggle="modal"
                        data-target="#modal-deadline-layout"
                    >Deadline layouter <i class="fas fa-edit fa-fw"></i></a>
                <?php else : ?>
                    <span class="text-muted">Deadline layouter</span>
                <?php endif ?>
                <strong>
                    <?= ($layout_remaining_time <= 0 && $input->layout_notes == '') ? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">' . format_datetime($input->layout_deadline) . '</span>' : format_datetime($input->layout_deadline); ?>
                </strong>
            </div>

            <?php if ($level != 'author' and $level != 'reviewer') : ?>
                <div
                    class="list-group-item justify-content-between"
                    id="reloadlayouter"
                >
                    <span class="text-muted">Layouter</span>
                    <div>
                        <?php if ($layouters) {
                            foreach ($layouters as $layouter) {
                                echo '<span class="badge badge-info p-1">' . $layouter->username . '</span> ';
                            }
                        } ?>
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
                    data-trigger="hover"
                    data-content="<?= $input->layout_status; ?>"
                    data-original-title="Catatan Admin"
                >
                    <?php if ($input->is_layout == 'n' and $input->draft_status == 99) : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Layout Ditolak</span>
                    <?php elseif ($input->is_layout == 'y') : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Layout Selesai</span>
                    <?php endif ?>
                </a>
            </div>
            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin() && !$is_final) : ?>
                    <button
                        title="Aksi admin"
                        class="btn btn-secondary <?= !$is_layout_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-layout"
                        <?= !$is_layout_started ? 'disabled' : ''; ?>
                    ><i class="fa fa-thumbs-up"></i> Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan layout -->
                <button
                    type="button"
                    class="btn btn-outline-success <?= !$is_layout_started ? 'btn-disabled' : ''; ?>"
                    data-toggle="modal"
                    data-target="#modal-layout"
                    <?= !$is_layout_started ? 'disabled' : ''; ?>
                    <?= ($level == 'layouter' and $layout_remaining_time <= 0 and $input->layout_notes == '') ? 'disabled' : ''; ?>
                >Progress Layout
                    <?= $is_layout_notes_populated ? '<i class="far fa-comments"></i>' : '' ?>
                    <?= $is_layout_files_populated ? '<i class="far fa-file-alt"></i>' : '' ?>
                </button>
                <button
                    type="button"
                    class="btn btn-outline-success <?= !$is_layout_started ? 'btn-disabled' : ''; ?>"
                    data-toggle="modal"
                    data-target="#modal-cover"
                    <?= !$is_layout_started ? 'disabled' : ''; ?>
                    <?= ($level == 'layouter' and $layout_remaining_time <= 0 and $input->cover_notes == '') ? 'disabled' : ''; ?>
                >Progress Cover
                    <?= $is_cover_notes_populated ? '<i class="far fa-comments"></i>' : '' ?>
                    <?= $is_cover_files_populated ? '<i class="far fa-file-alt"></i>' : '' ?>
                </button>
            </div>
        </div>

        <?php
        // modal deadline layout
        $this->load->view('draft/view/common/deadline_modal', [
            'progress' => 'layout',
        ]);

        // modal aksi layout
        $this->load->view('draft/view/common/action_modal', [
            'progress' => 'layout'
        ]);

        // modal progress layout
        $this->load->view('draft/view/layout/layout_modal');

        // modal progress cover
        $this->load->view('draft/view/layout/cover_modal');

        // modal pilih layouter
        $this->load->view('draft/view/layout/select_layouter_modal');
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const draft_id = $('input[name=draft_id]').val();

    // mulai layout
    $('#layout-progress-wrapper').on('click', '#btn-start-layout', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_start_progress/'); ?>" + draft_id,
            data: {
                progress: 'layout'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#layout-progress-wrapper').load(' #layout-progress', function() {
                    // reinitiate modal after load
                    initFlatpickrModal()
                });
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
            },
        })
    })

    // selesai layout
    $('#layout-progress-wrapper').on('click', '#btn-finish-layout', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_finish_progress/'); ?>" + draft_id,
            data: {
                progress: 'layout'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#layout-progress-wrapper').load(' #layout-progress', function() {
                    // reinitiate modal after load
                    initFlatpickrModal()
                });
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
            },
        })
    })
})
</script>
