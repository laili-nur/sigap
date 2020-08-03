<?php
$level = check_level();
$is_proofread_started      = format_datetime($input->proofread_start_date);
$is_notes_populated = $input->proofread_notes || $input->proofread_notes_author ? true : false;
$is_files_populated = $input->proofread_file || $input->proofread_file_link ? true : false;
?>
<section
    id="proofread-progress-wrapper"
    class="card"
>
    <div id="proofread-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Proofread</span>
                <div class="card-header-control">
                    <?php if (is_staff() && !$is_final) : ?>
                        <button
                            id="btn-start-proofread"
                            title="Mulai proses proofreading"
                            type="button"
                            class="d-inline btn <?= !$is_proofread_started ? 'btn-warning' : 'btn-secondary'; ?> <?= $is_proofread_started ? 'btn-disabled' : ''; ?>"
                            <?= $is_proofread_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                        <button
                            id="btn-finish-proofread"
                            title="Selesai proses proofreading"
                            type="button"
                            class="d-inline btn btn-secondary  <?= !$is_proofread_started ? 'btn-disabled' : '' ?>"
                            <?= !$is_proofread_started ? 'disabled' : '' ?>
                        ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-proofread"
        >

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <span class="font-weight-bold">
                    <?php if ($input->is_proofread == 'n' && $input->draft_status == 99) : ?>
                        <span class="text-danger">
                            <i class="fa fa-times"></i>
                            <span>Proofread Ditolak</span>
                        </span>
                    <?php elseif ($input->is_proofread == 'y') : ?>
                        <span class="text-success">
                            <i class="fa fa-check"></i>
                            <span>Proofread Selesai</span>
                        </span>
                    <?php else : ?>
                        <span class="text-primary">
                            <span>Sedang Diproses</span>
                        </span>
                    <?php endif ?>
                </span>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong><?= format_datetime($input->proofread_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong><?= format_datetime($input->proofread_end_date); ?></strong>
            </div>

            <?php if ($level != 'author') : ?>
                <div class="list-group-item justify-content-between">
                    <?php if (is_staff()) : ?>
                        <button
                            class="btn-modal-revision btn btn-sm
                            <?= $is_revision_in_progress['editor'] ? 'btn-warning' : 'btn-secondary' ?>
                            <?= !$is_proofread_started ? 'btn-disabled' : ''; ?>"
                            title="Revisi Edit"
                            data-revision-type="edit"
                            <?= !$is_proofread_started ? 'disabled' : ''; ?>
                        >Revisi Edit <i class="fas fa-edit fa-fw"></i></button>
                    <?php else : ?>
                        <span class="text-muted">Revisi Edit</span>
                    <?php endif ?>
                    <strong><span class="badge badge-primary"><?= $revision_total['editor']; ?></span></button></strong>
                </div>

                <div class="list-group-item justify-content-between">
                    <?php if (is_staff()) : ?>
                        <button
                            class="btn-modal-revision btn btn-sm
                            <?= $is_revision_in_progress['layouter'] ? 'btn-warning' : 'btn-secondary' ?>
                            <?= !$is_proofread_started ? 'btn-disabled' : ''; ?>"
                            title="Revisi Layout"
                            data-revision-type="layout"
                            <?= !$is_proofread_started ? 'disabled' : ''; ?>
                        >Revisi Layout <i class="fas fa-edit fa-fw"></i></button>
                    <?php else : ?>
                        <span class="text-muted">Revisi Layout</span>
                    <?php endif ?>
                    <strong><span class="badge badge-primary"><?= $revision_total['layouter']; ?></span></button></strong>
                </div>
            <?php endif ?>

            <div class="m-3">
                <div class="text-muted pb-1">Catatan Admin</div>
                <?= $input->proofread_status; ?>
            </div>
            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin() && !$is_final) : ?>
                    <!-- cek kondisi untuk disable aksi admin -->
                    <?php $disable_action_button = !$is_proofread_started ||  $is_revision_in_progress['layouter'] ||  $is_revision_in_progress['editor'] ?>
                    <button
                        title="<?= $disable_action_button ? 'Revisi belum diselesaikan atau proofread belum dimulai' : 'Aksi admin'  ?>"
                        class="btn btn-outline-dark <?= $disable_action_button  ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-proofread"
                        <?= $disable_action_button ? 'disabled' : ''; ?>
                    ><i class="fa fa-thumbs-up"></i> Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan proofread -->
                <button
                    type="button"
                    class="btn btn-outline-success <?= !$is_proofread_started ? 'btn-disabled' : ''; ?>"
                    data-toggle="modal"
                    data-target="#modal-proofread"
                    <?= !$is_proofread_started ? 'disabled' : ''; ?>
                >Progress Proofread
                    <?= $is_notes_populated ? '<i class="far fa-comments"></i>' : '' ?>
                    <?= $is_files_populated ? '<i class="far fa-file-alt"></i>' : '' ?>
                </button>
            </div>
        </div>

        <?php
        // modal aksi proofread
        $this->load->view('draft/view/common/action_modal', [
            'progress' => 'proofread'
        ]);

        // modal progress proofread
        $this->load->view('draft/view/proofread/proofread_modal');

        // modal revision
        $this->load->view('draft/view/common/revision_modal');
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const draft_id = $('input[name=draft_id]').val();

    // mulai proofread
    $('#proofread-progress-wrapper').on('click', '#btn-start-proofread', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_start_progress/'); ?>" + draft_id,
            data: {
                progress: 'proofread'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#proofread-progress-wrapper').load(' #proofread-progress', function() {
                    // reinitiate modal after load
                    initFlatpickrModal()
                });
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
            },
        })
    })

    // selesai proofread
    $('#proofread-progress-wrapper').on('click', '#btn-finish-proofread', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_finish_progress/'); ?>" + draft_id,
            data: {
                progress: 'proofread'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#proofread-progress-wrapper').load(' #proofread-progress', function() {
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
