<?php
$is_ready = $print_order->is_preprint && $print_order->is_print && $print_order->is_postprint;

if (!$is_final) :
    if ($_SESSION['level'] == 'superadmin') :
?>
        <div
            id="final-progress-wrapper"
            class="mx-3 mx-md-0"
        >
            <div
                id="final-progress"
                class="card-button"
            >
                <?= (!$is_ready) ? '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Terdapat proses yang belum disetujui</small></div>' : null
                ?>

                <button
                    class="btn btn-primary <?= ($is_ready) ? null : 'btn-disabled'; ?>"
                    data-toggle="modal"
                    data-target="#modal-accept-print-order"
                    <?= ($is_ready) ? null : 'disabled'; ?>
                >Finalisasi</button>
                <button
                    class="btn btn-danger <?= ($is_ready) ? null : 'btn-disabled'; ?>"
                    data-toggle="modal"
                    data-target="#modal-reject-print-order"
                    <?= ($is_ready) ? null : 'disabled'; ?>
                >Tolak</button>
            </div>
        </div>

        <div
            class="modal modal-warning fade"
            id="modal-accept-print-order"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modal-accept-print-order"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-bullhorn text-yellow mr-1"></i> Konfirmasi finalisasi order cetak</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin akan menyelesaikan cetak ini?</p>
                        <div class="alert alert-info">Tanggal selesai cetak akan tercatat ketika klik Submit</div>
                    </div>
                    <div class="modal-footer">
                        <button
                            id="btn-accept-print-order"
                            class="btn btn-primary"
                        >Submit</button>
                        <button
                            type="button"
                            class="btn btn-light"
                            data-dismiss="modal"
                        >Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal modal-alert fade"
            id="modal-reject-print-order"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modal-reject-print-order"
            aria-hidden="true"
        >
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-exclamation-triangle text-red mr-1"></i> Tolak Draft</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yain akan menolak cetak ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-danger"
                            id="btn-reject-print-order"
                        >Tolak</button>
                        <button
                            type="button"
                            class="btn btn-light"
                            data-dismiss="modal"
                        >Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(document).ready(function() {
            const printOrderId = '<?= $print_order->print_order_id ?>';
            const url = '<?= base_url('print_order/final/'); ?>' + printOrderId

            // order cetak disetujui
            $('#btn-accept-print-order').on('click', function() {
                $(this).attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
                window.location = url + '/finish'
            });

            // order cetak ditolak
            $('#btn-reject-print-order').on('click', function() {
                $(this).attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
                window.location = url + '/reject'
            });
        })
        </script>
    <?php endif; ?>
<?php else : ?>
    <div>Print Order telah selesai.&nbsp;
        <span>
            <a
                href="<?= base_url('book/view/' . $print_order->book_id); ?>"
                target="_blank"
            ><i class="fa fa-external-link-alt"></i> Link buku</a>
        </span>
    </div>
<?php endif; ?>
