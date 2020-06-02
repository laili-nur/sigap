<?php

use Carbon\Carbon;

$level               = check_level();
$edit_remaining_time = Carbon::parse(Carbon::today())->diffInDays($input->edit_deadline, false);
$is_edit_started     = format_datetime($input->edit_start_date);
$is_notes_populated = $input->edit_notes || $input->edit_notes_author ? true : false;
$is_confidential_populated = $input->edit_notes_confidential ? true : false;
$is_files_populated = $input->edit_file || $input->edit_file_link ? true : false;
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
                    <?php if (($level == 'editor' || is_admin()) && !$is_final) : ?>
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
            <div class="alert alert-warning mb-1"><strong>PERHATIAN!</strong> Pilih editor terlebih dahulu sebelum mulai proses
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
                <?php if (is_admin() && !$is_final) : ?>
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
                <span>
                    <?php if ($input->is_edit == 'n' && $input->draft_status == 99) : ?>
                        <span class="text-danger">
                            <i class="fa fa-times"></i>
                            <span>Edit Ditolak</span>
                        </span>
                    <?php elseif ($input->is_edit == 'y') : ?>
                        <span class="text-success">
                            <i class="fa fa-check"></i>
                            <span>Edit Selesai</span>
                        </span>
                    <?php else : ?>
                        <span class="text-primary">
                            <i class="fa fa-loading"></i>
                            <span>Sedang Diproses</span>
                        </span>
                    <?php endif ?>
                </span>
            </div>

            <div class="m-3">
                <div class="text-muted pb-1">Catatan Admin</div>
                <?= $input->edit_status; ?>
            </div>
            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin() && !$is_final) : ?>
                    <button
                        title="Aksi admin"
                        class="btn btn-outline-dark <?= !$is_edit_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-edit"
                        <?= !$is_edit_started ? 'disabled' : ''; ?>
                    >Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan edit -->
                <button
                    type="button"
                    class="btn btn-outline-success <?= !$is_edit_started ? 'btn-disabled' : ''; ?>"
                    data-toggle="modal"
                    data-target="#modal-edit"
                    <?= !$is_edit_started ? 'disabled' : ''; ?>
                    <?= ($level == 'editor' and $edit_remaining_time <= 0 and $input->edit_notes == '') ? 'disabled' : ''; ?>
                >Progress Edit
                    <?= $is_notes_populated ? '<i class="far fa-comments"></i>' : '' ?>
                    <?= $is_files_populated ? '<i class="far fa-file-alt"></i>' : '' ?>
                </button>
                <?php if ($level != 'author' and $level != 'layouter') : ?>
                    <button
                        data-toggle="modal"
                        data-target="#modal-edit-confidential"
                        class="btn btn-outline-primary <?= !$is_edit_started ? 'btn-disabled' : ''; ?>"
                        <?= !$is_edit_started ? 'disabled' : ''; ?>
                    >Catatan
                        <?= $is_confidential_populated ? '<i class="far fa-comment"></i>' : '' ?></button>
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
