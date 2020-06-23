<!-- BREADCUMB,TITLE -->
<header class="page-title-bar mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('printing'); ?>">Printing</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted"><?= $pData->book_title; ?></a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center my-3">
        <div class="page-title mb-0 pb-0 h1"> Order Cetak </div>
        <?php if($level == 'superadmin'): ?>
        <a
            href="<?= base_url('printing/view_printing_edit/'.$pData->print_id); ?>"
            class="btn btn-secondary btn-sm"
        ><i class="fa fa-edit fa-fw"></i> Edit Order Cetak</a>
        <?php endif; ?>
    </div>
</header>
<!-- BREADCUMB,TITLE -->

<!-- DETAIL -->
<section class="card" id="detail_print">
    <header class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a
                    class="nav-link active show"
                    data-toggle="tab"
                    href="#detail_print_wrapper"
                ><i class="fa fa-info-circle"></i> Detail Order Cetak</a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="tab"
                    href="#detail_book_wrapper"
                ><i class="fa fa-book"></i> Buku</a>
            </li>
        </ul>
    </header>

    <div class="card-body">
        <div class="tab-content">
<!-- DRAFT DATA -->
<div
    id="detail_print_wrapper"
    class="tab-pane fade active show"
>
    <div id="draft-data">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0 nowrap">
                <tbody>
                    <tr>
                        <td width="140px">Judul buku</td>
                        <td><strong><?= $pData->book_title; ?></strong></td>
                    </tr>
                    <tr>
                        <td width="140px">Nomor order</td>
                        <td><?= $pData->order_number; ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Tipe cetak</td>
                        <td>
                        <?php
                        if($pData->print_type == 0){echo 'POD';}
                        elseif($pData->print_type == 1){echo 'Offset';}
                        else{echo '';}
                        ?>                        
                        </td>
                    </tr>
                    <tr>
                        <td width="140px">Jumlah cetak</td>
                        <td><?= $pData->print_total; ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Kategori cetak</td>
                        <td>
                        <?php
                        if($pData->print_category == 0){echo 'Cetak baru';}
                        elseif($pData->print_category == 1){echo 'Cetak ulang';}
                        else{echo '';}
                        ?>                        
                        </td>
                    </tr>
                    <tr>
                        <td width="140px">Edisi cetak</td>
                        <td><?= $pData->print_edition; ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Kertas isi</td>
                        <td><?= $pData->paper_content; ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Kertas cover</td>
                        <td><?= $pData->paper_cover; ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Ukuran kertas</td>
                        <td><?= $pData->paper_size; ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Prioritas cetak</td>
                        <td>
                        <?php
                        if($pData->print_priority == 0){echo 'Rendah';}
                        elseif($pData->print_priority == 1){echo 'Sedang';}
                        elseif($pData->print_priority == 2){echo 'Tinggi';}
                        else{echo '';}
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="140px">Tanggal masuk</td>
                        <td><?php if(empty($pData->entry_date) == FALSE){echo date('d F Y H:i:s', strtotime($pData->entry_date));} ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Tanggal selesai</td>
                        <td><?php if(empty($pData->finish_date) == FALSE){echo date('d F Y H:i:s', strtotime($pData->finish_date));} ?></td>
                    </tr>
                    <tr>
                        <td width="140px">User entry</td>
                        <td><?= $pData->user_entry; ?></td>
                    </tr>
                    <tr>
                        <td width="140px">Status proses</td>
                        <td>
                        <?php
                        if($pData->progress_status == 0){echo 'Belum di proses.';}
                        elseif($pData->progress_status == 1){echo 'Proses Pracetak';}
                        elseif($pData->progress_status == 2){echo 'Proses Cetak';}
                        elseif($pData->progress_status == 3){echo 'Proses Jilid';}
                        elseif($pData->progress_status == 4){echo 'Proses Final';}
                        elseif($pData->progress_status == 5){echo 'Ditolak';}
                        elseif($pData->progress_status == 6){echo 'Selesai';}
                        else{echo '';}
                        ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- DRAFT DATA -->

<!-- DATA BUKU -->
<div
    class="tab-pane fade"
    id="detail_book_wrapper"
>
    <?php
    $book = $this->printing->fetch_book_data($pData->book_id);
    if (isset($book)) :
    ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0 nowrap">
                <tbody>
                    <tr>
                        <td width="200px"> Judul Buku </td>
                        <td><strong>
                            <?= $book->book_title; ?></strong> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Nomor Hak Cipta </td>
                        <td><strong>
                            <?= $book->nomor_hak_cipta; ?></strong> </td>
                    </tr>
                    <tr>
                        <td width="200px"> File hak cipta </td>
                        <td>
                            <?= (!empty($book->file_hak_cipta)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $book->file_hak_cipta . '" class="btn btn-success btn-xs m-0" href="' . base_url('hakcipta/' . $book->file_hak_cipta) . '"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                            <?= (!empty($book->file_hak_cipta_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $book->file_hak_cipta_link . '" class="btn btn-success btn-xs m-0" href="' . $book->file_hak_cipta_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> Status Hak Cipta</td>
                        <td>
                            <?= ($book->status_hak_cipta == '') ? '-' : ''; ?>
                            <?= ($book->status_hak_cipta == 1) ? '<span class="badge badge-info">Dalam Proses</span>' : ''; ?>
                            <?= ($book->status_hak_cipta == 2) ? '<span class="badge badge-success">Sudah Jadi</span>' : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> File Buku </td>
                        <td>
                            <a data-toggle="tooltip" data-placement="right" title="" class="btn btn-success btn-xs my-0" href="<?= base_url("book/download_file/bookfile/$book->book_file");?>" data-original-title="<?= $book->book_file;?>"><i class="fa fa-book"></i> File Buku</a>
                            <a data-toggle="tooltip" data-placement="right" title="" class="btn btn-success btn-xs my-0" target="_blank" href="<?= $book->book_file_link; ?>"><i class="fa fa-external-link-alt"></i> External file</a>
                            <a data-toggle="tooltip" data-placement="right" title="" class="btn btn-success btn-xs my-0" target="_blank" href="<?= base_url('book/view/'.$book->book_id); ?>"><i class="fa fa-external-link-alt"></i> Link buku</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<!-- DATA BUKU -->
        </div>
    </div>
</section>
<!-- DETAIL -->

<!-- PROGRESS -->
<hr class="my-3">
<?php
$progress_list = ['pracetak', 'cetak', 'jilid', 'final'];

$pracetak_class = '';
$pracetak_title = '';
if($pData->preprint_flag == 0 && $pData->preprint_status == 0){
    $pracetak_title = 'Belum mulai';
}elseif($pData->preprint_flag == 1){
    $pracetak_class .= 'error ';
    $pracetak_title = 'Ditolak';
}elseif($pData->preprint_flag == 2){
    $pracetak_class .= 'success ';
    $pracetak_title = 'Selesai';
}elseif($pData->preprint_status == 1){
    $pracetak_class .= 'active ';
    $pracetak_title = 'Dalam Proses';
}

$cetak_class = '';
$cetak_title = '';
if($pData->print_flag == 0 && $pData->print_status == 0){
    $cetak_title = 'Belum mulai';
}elseif($pData->print_flag == 1){
    $cetak_class .= 'error ';
    $cetak_title = 'Ditolak';
}elseif($pData->print_flag == 2){
    $cetak_class .= 'success ';
    $cetak_title = 'Selesai';
}elseif($pData->print_status == 1){
    $cetak_class .= 'active ';
    $cetak_title = 'Dalam Proses';
}

$jilid_class = '';
$jilid_title = '';
if($pData->binding_flag == 0 && $pData->binding_status == 0){
    $jilid_title = 'Belum mulai';
}elseif($pData->binding_flag == 1){
    $jilid_class .= 'error ';
    $jilid_title = 'Ditolak';
}elseif($pData->binding_flag == 2){
    $jilid_class .= 'success ';
    $jilid_title = 'Selesai';
}elseif($pData->binding_status == 1){
    $jilid_class .= 'active ';
    $jilid_title = 'Dalam Proses';
}

$final_class = '';
$final_title = '';
if($pData->final_status == 0){
    $final_title = 'Belum mulai';
}elseif($pData->final_status == 1){
    $final_class .= 'success ';
    $final_title = 'Selesai';
}
?>

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
<hr class="my-3">
<!-- PROGRESS -->

<!-- PRACETAK -->
<?php
    $this->load->view('printing/view/progress_preprint');
?>
<!-- PRACETAK -->

<!-- CETAK -->
<?php
    if($pData->preprint_status == 2 && $pData->preprint_flag == 2):
    $this->load->view('printing/view/progress_print');
    endif;
?>
<!-- CETAK -->

<!-- JILID -->
<?php
    if($pData->print_status == 2 && $pData->print_flag == 2):
    $this->load->view('printing/view/progress_binding');
    endif;
?>
<!-- JILID -->

<!-- FINAL -->
<?php
    if($pData->binding_status == 2 && $pData->binding_flag == 2 && $pData->final_status == 0){
        $this->load->view('printing/view/progress_final');
    }elseif($pData->final_status == 1){
?>
<section id="section_final">
    <div>Order cetak telah selesai. Anda bisa melihat stok buku di sini :<br><span><a href="<?= base_url('book/view/'.$pData->book_id);?>" target="_blank"><i class="fa fa-external-link-alt"></i> Link buku</a></span>
    </div>
</section>
<?php
    }
?>
<!-- FINAL -->

<script>
$(document).ready(function() {
    $('.dates').flatpickr({
        disableMobile: true,
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d',
        minDate: "2000-01-01",
    });
});
</script>