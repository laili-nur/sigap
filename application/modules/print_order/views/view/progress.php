<?php
if($print_order->category != 'outsideprint') :
    $progress_list = ['preprint', 'print', 'postprint', 'stock'];
else :
    $progress_list = ['preprint', 'print', 'stock'];
endif ;

function get_print_order_progress($progress = null, $print_order, $progress_list)
{
    if (!in_array($progress, $progress_list)) {
        return [
            'class' => '',
            'title' => '',
        ];
    }

    ${"{$progress}_class"} = '';
    ${"{$progress}_title"} = '';
    if (!$print_order->{"is_{$progress}"} && $print_order->print_order_status == 'reject') {
        ${"{$progress}_class"} .= 'error ';
        ${"{$progress}_title"} = 'Ditolak';
    } else if ($print_order->{"is_{$progress}"}) {
        ${"{$progress}_class"} .= 'success ';
        ${"{$progress}_title"} = 'Selesai';
    } else if (format_datetime($print_order->{"{$progress}_start_date"})) {
        ${"{$progress}_class"} .= 'active ';
        ${"{$progress}_title"} = 'Dalam Proses';
    } else {
        ${"{$progress}_title"} = 'Belum mulai';
    }

    if ($progress == 'preprint') {
        $text = 'pracetak';
    } elseif ($progress == 'print') {
        $text = 'cetak';
    } elseif ($progress == 'postprint') {
        $text = 'jilid';
    } else {
        $text = '';
    }

    return [
        'class' => ${"{$progress}_class"},
        'title' => ${"{$progress}_title"},
        'text' => $text
    ];
}


// $final_class = '';
// $final_title = '';
// if ($pData->final_status == 0) {
//     $final_title = 'Belum mulai';
// } elseif ($pData->final_status == 1) {
//     $final_class .= 'success ';
//     $final_title = 'Selesai';
// }
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
                    <?php $progress_data = get_print_order_progress($progress, $print_order, $progress_list) ?>
                    <li class="<?= $progress_data['class'] ?>">
                        <button
                            data-html="true"
                            type="button"
                            data-toggle="tooltip"
                            title="<?= $progress_data['title'] ?>"
                        >
                            <span
                                width="300px"
                                class="progress-indicator"
                            ></span>
                        </button>
                        <span class="progress-label d-none d-sm-inline-block"><?= $progress_data['text']; ?></span>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>
