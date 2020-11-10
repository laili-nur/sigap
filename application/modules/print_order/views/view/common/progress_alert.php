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

<?php if (!$print_order->{"is_{$progress}"}) : ?>
    <div
        class="alert alert-warning alert-dismissible fade show mb-1"
        role="alert"
    >
        <strong>PERHATIAN!</strong> Pastikan mengisi data-data sebelum menyetujui proses <?= $progress_text ?>.
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
<?php endif; ?>
