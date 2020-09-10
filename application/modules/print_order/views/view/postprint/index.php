<?php
    $is_postprint_started      = format_datetime($print_order->postprint_start_date);
    if($print_order->category != 'outsideprint') :
?>
<section
    id="postprint-progress-wrapper"
    class="card"
>
    <div id="postprint-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Jilid</span>
                <?php if (!$is_final) : ?>
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
                <?php if (is_admin() && !$is_final) : ?>
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

            <hr class="m-0">
        </div>

        <div class="card-body">
            <div class="card-button">
                <!-- button aksi -->
                <?php if (is_admin() && !$is_final) : ?>
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