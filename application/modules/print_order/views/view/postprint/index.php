<?php
$is_postprint_started      = format_datetime($print_order->postprint_start_date);
$is_postprint_finished      = format_datetime($print_order->postprint_end_date);
$admin_percetakan = $this->print_order->get_admin_percetakan_by_progress('postprint', $print_order->print_order_id);
if ($print_order->category != 'outsideprint') :
?>
    <section
        id="postprint-progress-wrapper"
        class="card"
    >
        <div id="postprint-progress">
            <header class="card-header">
                <div class="d-flex align-items-center"><span class="mr-auto">Jilid</span>
                    <?php if (!$is_final) :
                        //modal select
                        $this->load->view('print_order/view/common/select_modal', [
                            'progress' => 'postprint',
                            'admin_percetakan' => $admin_percetakan
                        ]);
                    ?>
                        <div class="card-header-control">
                            <button
                                id="btn-start-postprint"
                                title="Mulai proses pra cetak"
                                type="button"
                                class="d-inline btn <?= !$is_postprint_started ? 'btn-warning' : 'btn-secondary'; ?> <?= $is_postprint_started ? 'btn-disabled' : ''; ?>"
                                <?= $is_postprint_started ? 'disabled' : ''; ?>
                            ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                            <button
                                id="btn-finish-postprint"
                                title="Selesai proses pra cetak"
                                type="button"
                                class="d-inline btn btn-secondary <?= !$is_postprint_started ? 'btn-disabled' : '' ?>"
                                <?= !$is_postprint_started ? 'disabled' : '' ?>
                            ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                        </div>
                    <?php endif ?>
                </div>
            </header>

            <!-- ALERT -->
            <?php if ($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_percetakan') : ?>
                <!-- all -->
                <?php if ($print_order->is_postprint == 1) : ?>
                    <div class="alert alert-success mb-1">Progress telah selesai.</div>
                <?php endif; ?>
                <?php if ($_SESSION['level'] == 'superadmin' && $print_order->is_postprint == 0) : ?>
                    <!-- superadmin -->
                    <?php if (!$admin_percetakan) : ?>
                        <div class="alert alert-warning mb-1"><strong>PERHATIAN!</strong> Belum ada admin percetakan yang dipilih.</div>
                    <?php endif; ?>
                    <?php if (!$print_order->postprint_deadline) : ?>
                        <div class="alert alert-warning mb-1"><strong>PERHATIAN!</strong> Belum menetapkan deadline progress.</div>
                    <?php endif; ?>
                    <?php if ($print_order->postprint_end_date) : ?>
                        <div class="alert alert-warning mb-1"><strong>PERHATIAN!</strong> Progress telah selesai. Mohon untuk melakukan aksi.</div>
                    <?php endif; ?>
                <?php elseif ($_SESSION['level'] == 'admin_percetakan' && $print_order->is_postprint == 0) : ?>
                    <!-- admin -->
                    <?php if ($is_postprint_started) : ?>
                        <div class="alert alert-warning mb-1"><strong>PERHATIAN!</strong> Pastikan mengisi catatan dan data lainnya sebelum menyelesaikan progress.</div>
                    <?php endif; ?>
                    <?php if ($is_postprint_finished) : ?>
                        <div class="alert alert-warning mb-1"><strong>PERHATIAN!</strong> Progress telah selesai. Mohon tunggu superadmin memproses aksi</div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>


            <div
                class="list-group list-group-flush list-group-bordered"
                id="list-group-postprint"
            >
                <div class="list-group-item justify-content-between">
                    <span class="text-muted">Status</span>
                    <span class="font-weight-bold">
                        <?php if ($print_order->is_postprint) : ?>
                            <span class="text-success">
                                <i class="fa fa-check"></i>
                                <span>Selesai</span>
                            </span>
                        <?php elseif (!$print_order->is_postprint && $print_order->print_order_status == 'reject') : ?>
                            <span class="text-danger">
                                <i class="fa fa-times"></i>
                                <span>Ditolak</span>
                            </span>
                        <?php elseif (!$print_order->is_postprint && $print_order->postprint_start_date) : ?>
                            <span class="text-primary">
                                <span>Sedang Diproses</span>
                            </span>
                        <?php endif ?>
                    </span>
                </div>

                <div class="list-group-item justify-content-between">
                    <span class="text-muted">Tanggal mulai</span>
                    <strong>
                        <?= format_datetime($print_order->postprint_start_date); ?></strong>
                </div>

                <div class="list-group-item justify-content-between">
                    <span class="text-muted">Tanggal selesai</span>
                    <strong>
                        <?= format_datetime($print_order->postprint_end_date); ?></strong>
                </div>

                <div class="list-group-item justify-content-between">
                    <?php if (is_superadmin() && !$is_final) : ?>
                        <a
                            href="#"
                            id="btn-modal-deadline-postprint"
                            title="Ubah deadline"
                            data-toggle="modal"
                            data-target="#modal-deadline-postprint"
                        >Deadline <i class="fas fa-edit fa-fw"></i></a>
                    <?php else : ?>
                        <span class="text-muted">Deadline</span>
                    <?php endif ?>
                    <strong><?= format_datetime($print_order->postprint_deadline); ?></strong>
                </div>

                <div class="m-3">
                    <div class="text-muted pb-1">Catatan Admin</div>
                    <?= $print_order->postprint_notes_admin ?>
                </div>

                <?php if ($admin_percetakan) : ?>
                    <div class="list-group-item justify-content-between">
                        <span class="text-muted">Staff Bertugas</span>
                        <strong>
                            <?php foreach ($admin_percetakan as $admin) : ?>
                                <span class="badge badge-info p-1"><?= $admin->username; ?></span>
                            <?php endforeach; ?>
                        </strong>
                    </div>
                <?php endif; ?>

                <hr class="m-0">
            </div>

            <div class="card-body">
                <div class="card-button">
                    <!-- button aksi -->
                    <?php if (is_superadmin() && !$is_final) : ?>
                        <button
                            title="Aksi admin"
                            class="btn btn-outline-dark <?= !$is_postprint_started ? 'btn-disabled' : ''; ?>"
                            data-toggle="modal"
                            data-target="#modal-action-postprint"
                            <?= !$is_postprint_started ? 'disabled' : ''; ?>
                        >Aksi</button>
                    <?php endif; ?>

                    <!-- button tanggapan postprint -->
                    <button
                        type="button"
                        class="btn btn-outline-success"
                        data-toggle="modal"
                        data-target="#modal-postprint-notes"
                    >Catatan</button>
                    <!-- Modal Set Stok untuk Outside -->
                    <?php
                    if ($print_order->category != "outsideprint" && $print_order->category != "nonbook") {
                        $this->load->view('print_order/view/common/stock_modal', [
                            'progress' => 'postprint',
                        ]);
                    }
                    ?>
                </div>
            </div>

            <?php
            // modal deadline
            $this->load->view('print_order/view/common/deadline_modal', [
                'progress' => 'postprint',
            ]);

            // modal action
            $this->load->view('print_order/view/common/action_modal', [
                'progress' => 'postprint',
            ]);

            // modal note
            $this->load->view('print_order/view/common/notes_modal', [
                'progress' => 'postprint',
            ]);
            ?>
        </div>
    </section>

    <script>
    $(document).ready(function() {
        const print_order_id = '<?= $print_order->print_order_id ?>'

        // inisialisasi segment
        reload_postprint_segment()

        // ketika load segment, re-initialize call function-nya
        function reload_postprint_segment() {
            $('#postprint-progress-wrapper').load(' #postprint-progress', function() {
                // reinitiate modal after load
                initFlatpickrModal()
            });
        }

        // mulai pracetak
        $('#postprint-progress-wrapper').on('click', '#btn-start-postprint', function() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('print_order/api_start_progress/'); ?>" + print_order_id,
                datatype: "JSON",
                data: {
                    progress: 'postprint'
                },
                success: function(res) {
                    showToast(true, res.data);
                },
                error: function(err) {
                    showToast(false, err.responseJSON.message);
                },
                complete: function() {
                    // reload segmen postprint
                    reload_postprint_segment()
                    // reload progress
                    $('#progress-list-wrapper').load(' #progress-list');
                    // reload data draft
                    $('#print-data-wrapper').load(' #print-data');
                },
            })
        })

        // selesai pracetak
        $('#postprint-progress-wrapper').on('click', '#btn-finish-postprint', function() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('print_order/api_finish_progress/'); ?>" + print_order_id,
                datatype: "JSON",
                data: {
                    progress: 'postprint'
                },
                success: function(res) {
                    showToast(true, res.data);
                },
                error: function(err) {
                    showToast(false, err.responseJSON.message);
                },
                complete: function() {
                    // reload segmen postprint
                    reload_postprint_segment()
                    // reload progress
                    $('#progress-list-wrapper').load(' #progress-list');
                    // reload data draft
                    $('#print-data-wrapper').load(' #print-data');
                },
            })
        })
    })
    </script>
<?php
endif;
?>
