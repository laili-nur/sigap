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
                <?php if (is_admin() && !$is_final) {
                    //modal select
                    $this->load->view('print_order/view/common/select_modal', [
                        'progress' => 'print',
                    ]);
                } ?>
                <?php if (!$is_final) : ?>
                    <div class="card-header-control">
                        <button
                            id="btn-start-print"
                            title="Mulai proses cetak"
                            type="button"
                            class="d-inline btn <?= !$is_print_started ? 'btn-warning' : 'btn-secondary'; ?> <?= $is_print_started ? 'btn-disabled' : ''; ?>"
                            <?= $is_print_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                        <?php if ($print_order->category == 'outsideprint') : ?>
                            <button
                                id="btn-finish-print-postprint"
                                title="Selesai proses cetak"
                                type="button"
                                class="d-inline btn btn-secondary <?= !$is_print_started ? 'btn-disabled' : '' ?>"
                                <?= !$is_print_started ? 'disabled' : '' ?>
                            ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                        <?php else : ?>
                            <button
                                id="btn-finish-print"
                                title="Selesai proses cetak"
                                type="button"
                                class="d-inline btn btn-secondary <?= !$is_print_started ? 'btn-disabled' : '' ?>"
                                <?= !$is_print_started ? 'disabled' : '' ?>
                            ><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                        <?php endif; ?>
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
                    <?php if ($print_order->category != "outsideprint") : ?>
                        <button
                            title="Aksi admin"
                            class="btn btn-outline-dark <?= !$is_print_started ? 'btn-disabled' : ''; ?>"
                            data-toggle="modal"
                            data-target="#modal-action-print"
                            <?= !$is_print_started ? 'disabled' : ''; ?>
                        >Aksi</button>
                        <?php
                        // modal action
                        $this->load->view('print_order/view/common/action_modal', [
                            'progress' => 'print',
                        ]);
                        ?>
                    <?php else : ?>
                        <?php
                        $progress = 'print';
                        $progress_text = 'cetak';
                        ?>
                        <button
                            title="Aksi admin"
                            class="btn btn-outline-dark <?= !$is_print_started ? 'btn-disabled' : ''; ?>"
                            data-toggle="modal"
                            data-target="#modal-action-print-postprint"
                            <?= !$is_print_started ? 'disabled' : ''; ?>
                        >Aksi</button>
                        <!-- modal aksi print-postprint -->

                        <div
                            class="modal fade"
                            id="modal-action-print-postprint"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="modal-action-print-postprint"
                            aria-hidden="true"
                        >
                            <div
                                class="modal-dialog modal-dialog-centered"
                                role="document"
                            >
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Aksi <?= $progress_text ?></h5>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <fieldset>
                                            <?= form_hidden('progress', $progress) ?>
                                            <div class="form-group">
                                                <label
                                                    for="action_notes_admin"
                                                    class="font-weight-bold"
                                                >Catatan Admin</label>
                                                <div class="alert alert-info">
                                                    Catatan admin dapat dilihat oleh semua user yang terkait dengan draft ini.
                                                </div>
                                                <?php
                                                if (!is_admin()) {
                                                    echo '<div class="font-italic">' . nl2br($print_order->{"{$progress}_notes_admin"}) . '</div>';
                                                } else {
                                                    echo form_textarea([
                                                        'name'  => "{$progress}_notes_admin",
                                                        'class' => 'form-control',
                                                        'id'    => "{$progress}_notes_admin",
                                                        'rows'  => '6',
                                                        'value' => $print_order->{"{$progress}_notes_admin"},
                                                    ]);
                                                }
                                                ?>
                                                <hr class="my-3">
                                                <div class="alert alert-info">
                                                    Pilih aksi dibawah ini: <br>
                                                    Jika <strong class="text-success">Setuju</strong>, maka tahap <?= $progress_text ?> akan
                                                    diakhiri
                                                    dan tanggal selesai <?= $progress_text ?> akan dicatat <br>
                                                    Jika <strong class="text-danger">Tolak</strong> maka proses draft akan diakhiri
                                                    sampai tahap ini.<br>
                                                    Pilih <strong class="text-primary">Reset</strong> jika ingin mengembalikan status progress.
                                                </div>
                                                <button
                                                    class="btn btn-link"
                                                    id="btn-<?= $progress ?>-revert"
                                                ><i class="fa fa-history"></i> Reset Aksi</button>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                            data-dismiss="modal"
                                        >Close</button>
                                        <button
                                            id="btn-<?= $progress ?>-decline"
                                            class="btn btn-danger"
                                            type="button"
                                        >Tolak</button>
                                        <button
                                            id="btn-<?= $progress ?>-accept"
                                            class="btn btn-success"
                                            type="button"
                                        >Setuju</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        $(document).ready(function() {
                            const progress = '<?= $progress ?>'
                            const url = "<?= base_url('print_order/action_print_postprint'); ?>"

                            const printOrderId = '<?= $print_order->print_order_id ?>'

                            function send_action_data({
                                isAccept,
                                isRevert
                            }) {
                                this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");

                                $.ajax({
                                    type: "POST",
                                    url: `${url}/${printOrderId}`,
                                    data: {
                                        progress,
                                        accept: isAccept,
                                        revert: isRevert,
                                        [`${progress}_notes_admin`]: $(`#${progress}_notes_admin`).val()
                                    },
                                    success: function(res) {
                                        console.log(res);
                                        showToast(true, res.data);
                                    },
                                    error: function(err) {
                                        console.log(err);
                                        showToast(false, err.responseJSON.message);
                                    },
                                    complete: function() {
                                        location.reload()
                                    },
                                });
                            }

                            // aksi setuju
                            $(`#${progress}-progress-wrapper`).on('click', `#btn-${progress}-accept`, function() {
                                send_action_data.call($(this), {
                                    isAccept: 1,
                                    isRevert: 0
                                })
                            });

                            // aksi tolak
                            $(`#${progress}-progress-wrapper`).on('click', `#btn-${progress}-decline`, function() {
                                send_action_data.call($(this), {
                                    isAccept: 0,
                                    isRevert: 0
                                })
                            });

                            // aksi revert
                            $(`#${progress}-progress-wrapper`).on('click', `#btn-${progress}-revert`, function() {
                                send_action_data.call($(this), {
                                    isAccept: null,
                                    isRevert: 1
                                })
                            })
                        })
                        </script>

                    <?php endif; ?>
                <?php endif; ?>

                <!-- button tanggapan print -->
                <button
                    type="button"
                    class="btn btn-outline-success"
                    data-toggle="modal"
                    data-target="#modal-print-notes"
                >Catatan</button>

                <!-- Modal Set Stok untuk Outside -->
                <?php
                if ($print_order->category == "outsideprint") {
                    $this->load->view('print_order/view/common/stock_modal', [
                        'progress' => 'print',
                    ]);
                }
                ?>
            </div>
        </div>

        <?php
        // modal deadline
        $this->load->view('print_order/view/common/deadline_modal', [
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

    // print-postprint
    // selesai cetak dan jilid
    $('#print-progress-wrapper').on('click', '#btn-finish-print-postprint', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('print_order/finish_print_postprint/'); ?>" + print_order_id,
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
