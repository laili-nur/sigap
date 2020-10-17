<?php
$level = check_level();
if ($progress == 'preprint') {
    $progress_text = 'pracetak';
} elseif ($progress == 'print') {
    $progress_text = 'cetak';
} elseif ($progress == 'postprint') {
    $progress_text = 'jilid';
}
?>

<?php if ($level == 'superadmin' || $level == 'admin_percetakan') : ?>
    <?php if ($print_order->{"is_{$progress}"}) : ?>
        <div
            class="alert alert-success alert-dismissible fade show mb-1"
            role="alert"
        >
            Proses <?= $progress_text ?> telah selesai.
            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    <?php else : ?>
        <?php if (!$staff_percetakan || !$print_order->{"{$progress}_start_date"} || $print_order->{"{$progress}_deadline"}) : ?>
            <div
                class="alert alert-warning alert-dismissible fade show mb-1"
                role="alert"
            >
                <strong>PERHATIAN!</strong> Pastikan memilih staff cetak dan set deadline sebelum memulai proses <?= $progress_text ?>.

                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        <?php endif; ?>

        <?php if ($print_order->{"{$progress}_end_date"} || !$print_order->{"is_{$progress}"}) : ?>
            <div
                class="alert alert-warning alert-dismissible fade show mb-1"
                role="alert"
            >
                <strong>PERHATIAN!</strong> Pastikan mengisi data-data yang diperlukan sebelum menyetujui proses <?= $progress_text ?>.

                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
