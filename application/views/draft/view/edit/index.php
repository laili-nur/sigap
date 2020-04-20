<?php

use Carbon\Carbon;

$level               = check_level();
$edit_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->edit_deadline, false);
$is_edit_started     = format_datetime($input->edit_start_date);
?>
<section
    id="edit-progress-wrapper"
    class="card"
>
    <div id="edit-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Editorial</span>
                <div class="card-header-control">
                    <?php if (is_admin()) : ?>
                        <button
                            id="btn-modal-select-editor"
                            type="button"
                            class="d-inline btn <?= empty($editors) ? 'btn-warning' : 'btn-secondary'; ?>"
                            title="Pilih editor"
                        ><i class="fas fa-user-plus fa-fw"></i><span class="d-none d-lg-inline"> Pilih
                            Editor</span></button>
                    <?php endif; ?>
                    <?php if ($level == 'editor' || is_admin()) : ?>
                        <button
                            id="btn-start-edit"
                            title="Mulai proses editorial"
                            type="button"
                            class="d-inline btn <?= !$is_edit_started ? 'btn-warning' : 'btn-secondary'; ?> <?= empty($editors) || $is_edit_started ? 'btn-disabled' : ''; ?>"
                            <?= empty($editors) || $is_edit_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                        <button
                            id="btn-finish-edit"
                            title="Selesai proses editorial"
                            type="button"
                            class="d-inline btn btn-secondary"
                            <?= !$is_edit_started ? 'disabled' : '' ?>
                        ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <?php if ($editors == null && is_admin()) : ?>
            <div class="alert alert-warning"><strong>PERHATIAN!</strong> Pilih editor terlebih dahulu sebelum mulai proses
                editorial</div>
        <?php endif; ?>
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-edit"
        >

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong>
                    <?= format_datetime($input->edit_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong>
                    <?= format_datetime($input->edit_end_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <?php if (is_admin()) : ?>
                    <a
                        href="#"
                        id="btn-modal-deadline-edit"
                        title="Ubah deadline"
                        data-toggle="modal"
                        data-target="#modal-deadline-edit"
                    >Deadline editor <i class="fas fa-edit fa-fw"></i></a>
                <?php else : ?>
                    <span class="text-muted">Deadline editor</span>
                <?php endif ?>
                <strong>
                    <?= ($edit_remaining_time <= 0 && $input->edit_notes == '') ? '<span data-toggle="tooltip" data-placement="right" title="Melebihi Deadline" class="text-danger">' . format_datetime($input->edit_deadline) . '</span>' : format_datetime($input->edit_deadline); ?>
                </strong>
            </div>

            <?php if ($level != 'author' and $level != 'reviewer') : ?>
                <div
                    class="list-group-item justify-content-between"
                    id="reloadeditor"
                >
                    <span class="text-muted">Editor</span>
                    <div>
                        <?php if ($editors) {
                            foreach ($editors as $editor) {
                                echo '<span class="badge badge-info p-1">' . $editor->username . '</span> ';
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
                    data-content="<?= $input->edit_status; ?>"
                    data-original-title="Catatan Admin"
                >
                    <?php if ($input->is_edit == 'n' and $input->draft_status == 99) : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Edit Ditolak</span>
                    <?php elseif ($input->is_edit == 'y') : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Edit Selesai</span>
                    <?php endif ?>
                </a>
            </div>
            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin()) : ?>
                    <button
                        title="Aksi admin"
                        class="btn btn-secondary <?= !$is_edit_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-edit"
                    ><i class="fa fa-thumbs-up"></i> Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan edit -->
                <button
                    type="button"
                    class="btn <?= ($input->edit_notes) ? 'btn-success' : 'btn-outline-success'; ?>"
                    data-toggle="modal"
                    data-target="#modal-edit"
                    <?= ($level == 'editor' and $edit_remaining_time <= 0 and $input->edit_notes == '') ? 'disabled' : ''; ?>
                >Progress Edit</button>
                <?php if ($level != 'author' and $level != 'layouter') : ?>
                    <button
                        data-toggle="modal"
                        data-target="#modal-edit-confidential"
                        class="btn btn-outline-dark"
                    ><i class="far fa-sticky-note"></i> Catatan</button>
                <?php endif; ?>
            </div>
        </div>

        <?php
        // modal deadline edit
        $this->load->view('draft/view/common/deadline_modal', [
            'progress' => 'edit',
        ]);

        // modal aksi edit
        $this->load->view('draft/view/common/action_modal', [
            'progress' => 'edit',
        ]);

        // modal progress edit
        $this->load->view('draft/view/edit/edit_modal');

        // modal pilih edit
        $this->load->view('draft/view/edit/select_editor_modal');

        // modal catatan confidential
        $this->load->view('draft/view/edit/confidential_modal');
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const draft_id = $('input[name=draft_id]').val();

    // mulai edit
    $('#edit-progress-wrapper').on('click', '#btn-start-edit', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_start_progress/'); ?>" + draft_id,
            data: {
                progress: 'edit'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#edit-progress-wrapper').load(' #edit-progress', function() {
                    // reinitiate modal after load
                    initFlatpickrModal()
                });
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
            },
        })
    })

    // selesai edit
    $('#edit-progress-wrapper').on('click', '#btn-finish-edit', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_finish_progress/'); ?>" + draft_id,
            data: {
                progress: 'edit'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#edit-progress-wrapper').load(' #edit-progress', function() {
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
