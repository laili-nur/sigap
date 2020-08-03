<?php
$is_print_started      = format_datetime($print_order->print_start_date);
?>
<section
    id="print-progress-wrapper"
    class="card"
>
    <div id="print-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Cetak</span>
                <?php if (!$is_final) : ?>
                    <div class="card-header-control">
                        <button
                            id="btn-start-print"
                            title="Mulai proses cetak"
                            type="button"
                            class="d-inline btn <?= !$is_print_started ? 'btn-warning' : 'btn-secondary'; ?> <?= $is_print_started ? 'btn-disabled' : ''; ?>"
                            <?= $is_print_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                        <button
                            id="btn-finish-print"
                            title="Selesai proses cetak"
                            type="button"
                            class="d-inline btn btn-secondary <?= !$is_print_started ? 'btn-disabled' : '' ?>"
                            <?= !$is_print_started ? 'disabled' : '' ?>
                        ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                    </div>
                <?php endif ?>
            </div>
        </header>

        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-print"
        >
            <div class="list-group-item justify-content-between">
                <span class="text-muted">Status</span>
                <span class="font-weight-bold">
                    <?php if ($print_order->is_print) : ?>
                        <span class="text-success">
                            <i class="fa fa-check"></i>
                            <span>Selesai</span>
                        </span>
                    <?php elseif (!$print_order->is_print && $print_order->print_order_status == 'reject') : ?>
                        <span class="text-danger">
                            <i class="fa fa-times"></i>
                            <span>Ditolak</span>
                        </span>
                    <?php elseif (!$print_order->is_print && $print_order->print_start_date) : ?>
                        <span class="text-primary">
                            <span>Sedang Diproses</span>
                        </span>
                    <?php endif ?>
                </span>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong>
                    <?= format_datetime($print_order->print_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong>
                    <?= format_datetime($print_order->print_end_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <?php if (is_admin() && !$is_final) : ?>
                    <a
                        href="#"
                        id="btn-modal-deadline-print"
                        title="Ubah deadline"
                        data-toggle="modal"
                        data-target="#modal-deadline-print"
                    >Deadline <i class="fas fa-edit fa-fw"></i></a>
                <?php else : ?>
                    <span class="text-muted">Deadline</span>
                <?php endif ?>
                <strong><?= format_datetime($print_order->print_deadline); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">User</span>
                <strong>
                    <?= $print_order->print_user ?></strong>
            </div>

            <div class="m-3">
                <div class="text-muted pb-1">Catatan Admin</div>
                <?= $print_order->print_notes_admin ?>
            </div>

            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin() && !$is_final) : ?>
                    <button
                        title="Aksi admin"
                        class="btn btn-outline-dark <?= !$is_print_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-print"
                        <?= !$is_print_started ? 'disabled' : ''; ?>
                    >Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan print -->
                <button
                    type="button"
                    class="btn btn-outline-success"
                    data-toggle="modal"
                    data-target="#modal-print-notes"
                >Catatan</button>
            </div>
        </div>

        <?php
        // modal deadline
        $this->load->view('print_order/view/common/deadline_modal', [
            'progress' => 'print',
        ]);

        // modal action
        $this->load->view('print_order/view/common/action_modal', [
            'progress' => 'print',
        ]);

        // modal note
        $this->load->view('print_order/view/common/notes_modal', [
            'progress' => 'print',
        ]);
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const print_order_id = '<?= $print_order->print_order_id ?>'

    // inisialisasi segment
    reload_print_segment()

    // ketika load segment, re-initialize call function-nya
    function reload_print_segment() {
        $('#print-progress-wrapper').load(' #print-progress', function() {
            // reinitiate modal after load
            initFlatpickrModal()
        });
    }

    // mulai cetak
    $('#print-progress-wrapper').on('click', '#btn-start-print', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/api_start_progress/'); ?>" + print_order_id,
            datatype: "JSON",
            data: {
                progress: 'print'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen print
                reload_print_segment()
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
                // reload data draft
                $('#print-data-wrapper').load(' #print-data');
            },
        })
    })

    // selesai cetak
    $('#print-progress-wrapper').on('click', '#btn-finish-print', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/api_finish_progress/'); ?>" + print_order_id,
            datatype: "JSON",
            data: {
                progress: 'print'
            },
            success: function(res) {
                showToast(true, res.data);
            },
            error: function(err) {
                showToast(false, err.responseJSON.message);
            },
            complete: function() {
                // reload segmen print
                reload_print_segment()
                // reload progress
                $('#progress-list-wrapper').load(' #progress-list');
                // reload data draft
                $('#print-data-wrapper').load(' #print-data');
            },
        })
    })
})
</script>
