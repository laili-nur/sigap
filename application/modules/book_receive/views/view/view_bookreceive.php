<header class="page-title-bar mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('book_receive'); ?>">Penerimaan Buku</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">
                    <?//= $print_order->book_id ? $print_order->book_title : $print_order->name; ?>
                </a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center my-3">
        <div class="page-title mb-0 pb-0 h1"> Penerimaan Buku </div>
        <div>
            <?php //if (!$is_final && $_SESSION['level'] == 'superadmin') : 
            ?>
            <!-- <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                data-target="#modal-additional-notes">Catatan Tambahan</button>
            <div class="modal fade" id="modal-additional-notes" tabindex="-1" role="dialog"
                aria-labelledby="modal-additional-notes" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Catatan Tambahan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <fieldset>
                                <div class="form-group">
                                    <?//= form_open('print_order/add_additional_notes/' . $print_order->print_order_id, ''); ?>
                                    <?php /*
                                        echo form_textarea([
                                            'name'  => "additional_notes",
                                            'class' => 'form-control',
                                            'id'    => "additional-notes",
                                            'rows'  => '6',
                                            'value' => $print_order->additional_notes
                                        ]); */
                                    ?>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light ml-auto" data-dismiss="modal">Close</button>
                            <?php //if (!$is_final) : 
                            ?>
                            <button class="btn btn-primary" type="submit" value="Submit"
                                id="btn-submit-additional-notes">Submit</button>
                            <?= form_close(); ?>
                            <?php //endif 
                            ?>
                        </div>
                    </div>
                </div>
            </div> -->
            <?php //endif; 
            ?>
            <?php //if ($_SESSION['level'] == 'superadmin') : 
            ?>
            <a href="<?//= base_url('print_order/edit/' . $print_order->print_order_id) ?>"
                class="btn btn-secondary btn-sm"><i class="fa fa-edit fa-fw"></i> Revisi Penerimaan Buku</a>
            <?php // endif 
            ?>
        </div>
    </div>

    <!-- FINAL ALERT -->
    <?php // if ($is_final) : 
    ?>
    <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-triangle"></i>
        <strong>Penerimaan buku telah selesai</strong>, data progress tidak dapat diubah.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> -->
    <?php //endif 
    ?>
</header>

<!--SECTION DETAIL-->

<section class="card">
    <header class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active show" data-toggle="tab" href="#book-receive-data-wrapper"><i
                        class="fa fa-info-circle"></i> Detail Penerimaan Buku</a>
            </li>
        </ul>
    </header>

    <div class="card-body">
        <div class="tab-content">
            <!-- BOOK RECEIVE DATA -->
            <div id="book-receive-data-wrapper" class="tab-pane fade active show">
                <div id="book-receive">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <!--HARD CODE-->
                                <tr>
                                    <td width="200px"> Kategori Cetak </td>
                                    <td>Cetak Ulang Non Revisi </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Judul Buku </td>
                                    <td><strong>Sistem Pengendalian Manajemen</strong> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Catatan Order Cetak </td>
                                    <td> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Nomor Order </td>
                                    <td>99228102 </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Kode Order </td>
                                    <td>700800 </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tipe Cetak </td>
                                    <td>pod </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Jumlah Eksemplar </td>
                                    <td>100 </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Hasil Cetak </td>
                                    <td>102 </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tanggal Masuk Gudang </td>
                                    <td>21/12/2020 14:11:14 </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tanggal Finalisasi</td>
                                    <td>30/12/2020 15:10:14 </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Deadline</td>
                                    <td>
                                        <div class="text-danger">01/01/2021 12:00:00</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Diinput Oleh </td>
                                    <td>superadmin </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Status</td>
                                    <td>Wrapping selesai, menunggu finalisasi</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--END OF SECTION DETAIL-->

<!--SECTION PROGRESS-->

<?php

function get_book_receive_progress($progress = null, $book_receive, $progress_list)
{
    if (!in_array($progress, $progress_list)) {
        return [
            'class' => '',
            'title' => '',
        ];
    }

    ${"{$progress}_class"} = '';
    ${"{$progress}_title"} = '';
    if (!$book_receive->{"is_{$progress}"} && $book_receive->book_receive_status == 'reject') {
        ${"{$progress}_class"} .= 'error ';
        ${"{$progress}_title"} = 'Ditolak';
    } else if ($book_receive->{"is_{$progress}"}) {
        ${"{$book_receive}_class"} .= 'success ';
        ${"{$book_receive}_title"} = 'Selesai';
    } else if (format_datetime($book_receive->{"{$progress}_start_date"})) {
        ${"{$progress}_class"} .= 'active ';
        ${"{$progress}_title"} = 'Dalam Proses';
    } else {
        ${"{$progress}_title"} = 'Belum mulai';
    }

    if ($progress == 'check_stock') {
        $text = 'pengecekan jumlah';
    } elseif ($progress == 'wrapping') {
        $text = 'wrapping';
    } elseif ($progress == 'finalisasi') {
        $text = 'menunggu finalisasi';
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
<section id="progress-list-wrapper" class="card">
    <div id="progress-list">
        <header class="card-header">Progress</header>
        <div class="card-body">
            <ol class="progress-list mb-0 mb-sm-4">
                <!-- HARD CODE -->
                <li class="success ">
                    <button data-html="true" type="button" data-toggle="tooltip" title="Selesai">
                        <span width="300px" class="progress-indicator"></span>
                    </button>
                    <span class="progress-label d-none d-sm-inline-block">Serah
                        Terima</span>
                </li>
                <li class="success ">
                    <button data-html="true" type="button" data-toggle="tooltip" title="Selesai">
                        <span width="300px" class="progress-indicator"></span>
                    </button>
                    <span class="progress-label d-none d-sm-inline-block">Wrapping</span>
                </li>
                <?php /* foreach ($progress_list as $progress) : ?>
                <?php $progress_data = get_book_receive_progress($progress, $book_receive, $progress_list) ?>
                <li class="<?= $progress_data['class'] ?>">
                    <button data-html="true" type="button" data-toggle="tooltip" title="<?= $progress_data['title'] ?>">
                        <span width="300px" class="progress-indicator"></span>
                    </button>
                    <span class="progress-label d-none d-sm-inline-block"><?= $progress_data['text']; ?></span>
                </li>
                <?php endforeach; */ ?>
            </ol>
        </div>
    </div>
</section>
<!--END OF ECTION PROGRESS-->

<!--SECTION SERAH TERIMA-->
