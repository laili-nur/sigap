<?php
$progress_list = ['review', 'edit', 'layout', 'proofread', 'final'];

$review_class = '';
$review_title = '';
if ($input->is_review == 'n' && $input->draft_status == 99) {
    $review_class .= 'error ';
    $review_title = 'Ditolak';
} else if ($input->is_review == 'y') {
    $review_class .= 'success ';
    $review_title = 'Selesai';
} else if (format_datetime($input->review_start_date)) {
    $review_class .= 'active ';
    $review_title = 'Dalam Proses';
} else {
    $review_title = 'Belum mulai';
}

$edit_class = '';
$edit_title = '';
if ($input->is_review == 'y' && $input->is_edit == 'n' && $input->draft_status == 99) {
    $edit_class .= 'error ';
    $edit_title = 'Ditolak';
} else if ($input->is_edit == 'y') {
    $edit_class .= 'success ';
    $edit_title = 'Selesai';
} else if (format_datetime($input->edit_start_date)) {
    $edit_class .= 'active ';
    $edit_title = 'Dalam Proses';
} else {
    $edit_title = 'Belum mulai';
}

$layout_class = '';
$layout_title = '';
if ($input->is_edit == 'y' && $input->is_layout == 'n' && $input->draft_status == 99) {
    $layout_class .= 'error ';
    $layout_title = 'Ditolak';
} else if ($input->is_layout == 'y') {
    $layout_class .= 'success ';
    $layout_title = 'Selesai';
} else if (format_datetime($input->layout_start_date)) {
    $layout_class .= 'active ';
    $layout_title = 'Dalam Proses';
} else {
    $layout_title = 'Belum mulai';
}

$proofread_class = '';
$proofread_title = '';
if ($input->is_layout == 'y' && $input->is_proofread == 'n' && $input->draft_status == 99) {
    $proofread_class .= 'error ';
    $proofread_title = 'Ditolak';
} else if ($input->is_proofread == 'y') {
    $proofread_class .= 'success ';
    $proofread_title = 'Selesai';
} else if (format_datetime($input->proofread_start_date)) {
    $proofread_class .= 'active ';
    if ($revision_total['editor'] != 0 || $revision_total['layouter'] != 0) {
        $proofread_title = 'Revisi Edit = ' . $revision_total['editor'] . '<br>' . 'Revisi Layout = ' . $revision_total['layouter'];
    }
} else {
    $proofread_title = 'Belum mulai';
}

// $print_class = '';
// $print_title = '';
// if ($input->is_proofread == 'y' && $input->is_print == 'n' && $input->draft_status == 99) {
//     $print_class .= 'error ';
//     $print_title = 'Ditolak';
// } else if ($input->is_print == 'y') {
//     $print_class .= 'success ';
//     $print_title = 'Selesai';
// } else if (format_datetime($input->print_start_date)) {
//     $print_class .= 'active ';
//     $print_title = 'Dalam Proses';
// } else {
//     $print_title = 'Belum mulai';
// }

$final_class = '';
$final_title = '';
if ($input->is_review == 'y' && $input->is_edit == 'y' && $input->is_layout == 'y' && $input->is_proofread == 'y' && $input->draft_status == 99) {
    $final_class .= 'error ';
    $final_title = 'Ditolak';
} else if ($input->draft_status == 14) {
    $final_class .= 'success ';
    $final_title = 'Selesai';
} else if (format_datetime($input->print_end_date)) {
    $final_class .= 'active ';
    $final_title = 'Dalam Proses';
} else {
    $final_title = 'Belum mulai';
}
?>

<hr class="my-4">
<section
    id="progress-list-wrapper"
    class="card"
>
    <div id="progress-list">
        <header class="card-header">Progress</header>
        <div class="card-body">
            <ol class="progress-list mb-0 mb-sm-4">

                <?php foreach ($progress_list as $progress) : ?>
                    <li class="<?= ${"{$progress}_class"} ?>">
                        <button
                            data-html="true"
                            type="button"
                            data-toggle="tooltip"
                            title="<?= ${"{$progress}_title"}; ?>"
                        >
                            <span
                                width="300px"
                                class="progress-indicator"
                            ></span>
                        </button>
                        <span class="progress-label d-none d-sm-inline-block"><?= $progress; ?></span>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>


<!--
<?php if ($input->is_layout == 'y' && ($revision_total['editor'] != 0 or $revision_total['layouter'] != 0)) {
    $warna        = 'style="border-color: #ffc107"';
    $tebal_kuning = 'font-weight-bold text-warning';
} else {
    $warna        = '';
    $tebal_kuning = '';
} ?> -->
