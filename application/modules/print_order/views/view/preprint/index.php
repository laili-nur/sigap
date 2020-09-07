<?php
$is_preprint_started      = format_datetime($print_order->preprint_start_date);
?>
<section
    id="preprint-progress-wrapper"
    class="card"
>
    <div id="preprint-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Pra Cetak</span>
                <?php if (!$is_final) : ?>
                    <div class="card-header-control">
                        <button
                            id="btn-start-preprint"
                            title="Mulai proses pra cetak"
                            type="button"
                            class="d-inline btn <?= !$is_preprint_started ? 'btn-warning' : 'btn-secondary'; ?> <?= $is_preprint_started ? 'btn-disabled' : ''; ?>"
                            <?= $is_preprint_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                        <button
                            id="btn-finish-preprint"
                            title="Selesai proses pra cetak"
                            type="button"
                            class="d-inline btn btn-secondary  <?= !$is_preprint_started ? 'btn-disabled' : '' ?>"
                            <?= !$is_preprint_started ? 'disabled' : '' ?>
                        ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                    </div>
                <?php endif ?>
            </div>
        </header>

        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-preprint"
        >
            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <span class="font-weight-bold">
                    <?php if ($print_order->is_preprint) : ?>
                        <span class="text-success">
                            <i class="fa fa-check"></i>
                            <span>Selesai</span>
                        </span>
                    <?php elseif (!$print_order->is_preprint && $print_order->print_order_status == 'reject') : ?>
                        <span class="text-danger">
                            <i class="fa fa-times"></i>
                            <span>Ditolak</span>
                        </span>
                    <?php elseif (!$print_order->is_preprint && $print_order->preprint_start_date) : ?>
                        <span class="text-primary">
                            <span>Sedang Diproses</span>
                        </span>
                    <?php endif ?>
                </span>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong>
                    <?= format_datetime($print_order->preprint_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong>
                    <?= format_datetime($print_order->preprint_end_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <?php if (is_admin() && !$is_final) : ?>
                    <a
                        href="#"
                        id="btn-modal-deadline-preprint"
                        title="Ubah deadline"
                        data-toggle="modal"
                        data-target="#modal-deadline-preprint"
                    >Deadline <i class="fas fa-edit fa-fw"></i></a>
                <?php else : ?>
                    <span class="text-muted">Deadline</span>
                <?php endif ?>
                <strong><?= format_datetime($print_order->preprint_deadline); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">User</span>
                <strong>
                    <?= $print_order->preprint_user ?></strong>
            </div>

            <div class="m-3">
                <div class="text-muted pb-1">Catatan Admin</div>
                <?= $print_order->preprint_notes_admin ?>
            </div>

            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin() && !$is_final) : ?>
                    <button
                        title="Aksi admin"
                        class="btn btn-outline-dark <?= !$is_preprint_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-preprint"
                        <?= !$is_preprint_started ? 'disabled' : ''; ?>
                    >Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan preprint -->
                <button
                    type="button"
                    class="btn btn-outline-success"
                    data-toggle="modal"
                    data-target="#modal-preprint-notes"
                >Catatan</button>

                <?php if($print_order->mode == "outsideprint") : ?>
                    <?php if(empty($print_order->preprint_file) == TRUE) : ?>
                        <!-- button modal preprint upload -->
                        <button
                            type="button"
                            class="btn btn-outline-dark"
                            data-toggle="modal"
                            data-target="#modal-preprint-upload"
                        >Upload File Approval</button>
                        <!-- modal preprint upload -->
                        <div
                            class="modal modal-warning fade"
                            id="modal-preprint-upload"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="modal-preprint-upload"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fa fa-bullhorn text-yellow mr-1"></i>Upload File Approval</h5>
                                    </div>
                                    <div class="modal-body">
                                        <?= form_open_multipart($form_action, 'novalidate="" id="form-print-order-preprint-file"'); ?>
                                            <fielsdet>
                                                <div class="form-group">
                                                    <label for="preprint-file"><?= $this->lang->line('form_print_order_preprint_file'); ?></label>
                                                    <div class="custom-file">
                                                        <?= form_upload('preprint_file', '', 'class="custom-file-input" id="preprint-file"'); ?>
                                                        <label
                                                            class="custom-file-label"
                                                            for="preprint-file"
                                                        >Pilih file</label>
                                                    </div>
                                                    <small class="form-text text-muted">Menerima tipe file :
                                                        <?= get_allowed_file_types('preprint_file')['to_text']; ?></small>
                                                    <small class="text-danger"><?= $this->session->flashdata('preprint_file_no_data'); ?></small>
                                                    <?= file_form_error('preprint_file', '<p class="small text-danger">', '</p>'); ?>
                                                </div>
                                            </fieldset>
                                    </div>
                                    <div class="modal-footer">
                                            <div class="form-actions">
                                                <button
                                                    class="btn btn-primary ml-auto"
                                                    type="submit"
                                                    value="Submit"
                                                    id="btn-submit"
                                                >Submit</button>
                                            </div>
                                        <?= form_close(); ?>
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                            data-dismiss="modal"
                                        >Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- button modal preprint file -->
                        <button
                            type="button"
                            class="btn btn-outline-success"
                            data-toggle="modal"
                            data-target="#modal-preprint-file"
                        >Lihat File Approval</button>
                        <!-- modal view uploaded -->
                        <div
                            class="modal modal-warning fade"
                            id="modal-preprint-file"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="modal-preprint-file"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fa fa-bullhorn text-yellow mr-1"></i>Upload File Approval</h5>
                                    </div>
                                    <div class="modal-body">
                                        <?php if(empty($print_order->preprint_file) == FALSE) : ?>
                                            <?php if(strpos($print_order->preprint_file, '.pdf') == TRUE) : ?>
                                                <a href="<?= base_url('print_order/download_preprint_file/'.$print_order->preprint_file);?>"><span class="badge badge-success"><?= base_url('preprintfile/'.$print_order->preprint_file);?></span></a>
                                                <iframe src="<?= base_url('preprintfile/'.$print_order->preprint_file);?>" style="width: 100%;height: 500px;border: none;"></iframe>
                                            <?php else : ?>
                                                <a href="<?= base_url('print_order/download_preprint_file/'.$print_order->preprint_file);?>"><span class="badge badge-success"><?= base_url('preprintfile/'.$print_order->preprint_file);?></span></a>
                                                <p>File not supported, download to view this file.</p>
                                            <?php endif ; ?>
                                        <?php endif; ?>
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
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php
        // modal deadline
        $this->load->view('print_order/view/common/deadline_modal', [
            'progress' => 'preprint',
        ]);

        // modal action
        $this->load->view('print_order/view/common/action_modal', [
            'progress' => 'preprint',
        ]);

        // modal note
        $this->load->view('print_order/view/common/notes_modal', [
            'progress' => 'preprint',
        ]);
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const printorderId = '<?= $print_order->print_order_id ?>'

    // inisialisasi segment
    reload_preprint_segment()

    // ketika load segment, re-initialize call function-nya
    function reload_preprint_segment() {
        $('#preprint-progress-wrapper').load(' #preprint-progress', function() {
            // reinitiate modal after load
            initFlatpickrModal()
        });
    }

    // mulai pracetak
    $('#preprint-progress-wrapper').on('click', '#btn-start-preprint', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/api_start_progress/'); ?>" + printorderId,
            datatype: "JSON",
            data: {
                progress: 'preprint'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen preprint
                reload_preprint_segment()
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
                // reload data draft
                $('#print-data-wrapper').load(' #print-data');
            },
        })
    })

    // selesai pracetak
    $('#preprint-progress-wrapper').on('click', '#btn-finish-preprint', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/api_finish_progress/'); ?>" + printorderId,
            datatype: "JSON",
            data: {
                progress: 'preprint'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen preprint
                reload_preprint_segment()
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
                // reload data draft
                $('#print-data-wrapper').load(' #print-data');
            },
        })
    })
})
</script>