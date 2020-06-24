<?php
$level              = check_level();
?>
<section
    id="section_final"
    class="card"
>
    <div id="final_progress">
        <header class="card-header">
            <span class="mr-auto">Final</span>
        </header>

        <?php if($rData->flag == 2): ?>
        <div class="alert alert-success">
            Permintaan Buku telah disetujui dan akan segera dikirim. Anda bisa melihat perubahan stok di halaman buku.
            <br><span><a href="<?= base_url('book/view/'.$rData->book_id);?>" target="_blank"><i class="fa fa-external-link-alt"></i> Link buku</a></span>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            Permintaan Buku telah ditolak, ajukan kembali permintaan buku.
            <br><span><a href="<?= base_url('book_request/add');?>" target="_blank"><i class="fa fa-external-link-alt"></i> Tambah Permintaan Buku Baru</a></span>
        </div>
        <?php endif;?>
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-edit"
        >
            <div class="list-group-item justify-content-between">
                <span class="text-muted">Tanggal di Proses</span>
                <strong class="text-justify" style="max-width:50%">
                    <?php if(empty($rData->finish_date) == FALSE){echo date('d F Y H:i:s', strtotime($rData->finish_date));} ?>
                </strong>
            </div>
            <div class="list-group-item justify-content-between">
                <span class="text-muted">User</span>
                <strong class="text-justify" style="max-width:50%"><?= $rData->final_user; ?></strong>
            </div>
            <div class="list-group-item justify-content-between">
                <span class="text-muted">Catatan</span>
                <strong class="text-justify" style="max-width:50%"><?= $rData->final_notes_admin; ?></strong>
            </div>
        </div>
        
    </div>
</section>