<?php
$level = check_level();
$is_proofread_started      = format_datetime($input->proofread_start_date);
?>
<section
    id="proofread-progress-wrapper"
    class="card"
>
    <div id="proofread-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Proofread</span>
                <div class="card-header-control">
                    <?php if (is_staff()) : ?>
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
                            class="d-inline btn btn-secondary"
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
                        <a
                            class="btn-modal-revision"
                            href="#revision-edit"
                            title="Revisi Edit"
                            data-revision-type="edit"
                        >Revisi Edit <i class="fas fa-edit fa-fw"></i></a>
                    <?php else : ?>
                        <span class="text-muted">Revisi Edit</span>
                    <?php endif ?>
                    <strong><span class="badge badge-warning"><?= $revision_total['editor']; ?></span></button></strong>
                </div>

                <div class="list-group-item justify-content-between">
                    <?php if (is_staff()) : ?>
                        <a
                            class="btn-modal-revision"
                            href="#revision-layout"
                            title="Revisi Layout"
                            data-revision-type="layout"
                        >Revisi Layout <i class="fas fa-edit fa-fw"></i></a>
                    <?php else : ?>
                        <span class="text-muted">Revisi Layout</span>
                    <?php endif ?>
                    <strong><span class="badge badge-warning"><?= $revision_total['layouter']; ?></span></button></strong>
                </div>
            <?php endif ?>

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
                    data-content="<?= $input->proofread_status; ?>"
                    data-original-title="Catatan Admin"
                >
                    <?php if ($input->is_proofread == 'n' and $input->draft_status == 99) : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Proofread Ditolak</span>
                    <?php elseif ($input->is_proofread == 'y') : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Proofread Selesai</span>
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
                        class="btn btn-secondary <?= !$is_proofread_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-proofread"
                    ><i class="fa fa-thumbs-up"></i> Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan proofread -->
                <button
                    type="button"
                    class="btn <?= ($input->proofread_notes) ? 'btn-success' : 'btn-outline-success'; ?>"
                    data-toggle="modal"
                    data-target="#modal-proofread"
                >Progress Proofread</button>
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
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#proofread-progress-wrapper').load(' #proofread-progress', function() {
                    // reinitiate modal after load
                    init_flatpickr_modal()
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
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#proofread-progress-wrapper').load(' #proofread-progress', function() {
                    // reinitiate modal after load
                    init_flatpickr_modal()
                });
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
            },
        })
    })
})
</script>
