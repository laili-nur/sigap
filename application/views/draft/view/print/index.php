<?php
$level = check_level();
$is_print_started      = format_datetime($input->print_start_date);
?>
<section
    id="print-progress-wrapper"
    class="card"
>
    <div id="print-progress">
        <header class="card-header">
            <div class="d-flex align-items-center"><span class="mr-auto">Cetak</span>
                <div class="card-header-control">
                    <?php if (is_staff()) : ?>
                        <button
                            id="btn-start-print"
                            title="Mulai proses printing"
                            type="button"
                            class="d-inline btn <?= !$is_print_started ? 'btn-warning' : 'btn-secondary'; ?> <?= $is_print_started ? 'btn-disabled' : ''; ?>"
                            <?= $is_print_started ? 'disabled' : ''; ?>
                        ><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-print"
        >

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal mulai</span>
                <strong>
            <?= format_datetime($input->print_start_date); ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal selesai</span>
                <strong>
            <?= format_datetime($input->print_end_date); ?></strong>
            </div>

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
                    data-content="<?= $input->print_status; ?>"
                    data-original-title="Catatan Admin"
                >
                    <?php if ($input->is_print == 'n' and $input->draft_status == 99) : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Cetak Ditolak</span>
                    <?php elseif ($input->is_print == 'y') : ?>
                        <i class="fa fa-info-circle"></i>
                        <span>Cetak Selesai</span>
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
                        class="btn btn-secondary <?= !$is_print_started ? 'btn-disabled' : ''; ?>"
                        data-toggle="modal"
                        data-target="#modal-action-print"
                    ><i class="fa fa-thumbs-up"></i> Aksi</button>
                <?php endif; ?>

                <!-- button tanggapan print -->
                <button
                    type="button"
                    class="btn <?= ($input->print_notes) ? 'btn-success' : 'btn-outline-success'; ?>"
                    data-toggle="modal"
                    data-target="#modal-print"
                >Progress Cetak</button>
            </div>
        </div>

        <?php
        // modal aksi print
        $this->load->view('draft/view/common/action_modal', [
            'progress' => 'print'
        ]);

        // modal progress print
        $this->load->view('draft/view/print/print_modal');
        ?>
    </div>
</section>

<script>
$(document).ready(function() {
    const draft_id = $('input[name=draft_id]').val();

    // mulai print
    $('#print-progress-wrapper').on('click', '#btn-start-print', function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('draft/api_start_progress/'); ?>" + draft_id,
            data: {
                progress: 'print'
            },
            success: function(res) {
                show_toast(true, res.data);
            },
            error: function(err) {
                show_toast(false, err.responseJSON.message);
            },
            complete: function() {
                $('#print-progress-wrapper').load(' #print-progress', function() {
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
