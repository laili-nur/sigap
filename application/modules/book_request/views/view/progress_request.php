<?php
$level              = check_level();
?>
<section
    id="section_request"
    class="card"
>
    <div id="request_progress">
        <header class="card-header">
            <span class="mr-auto">Permintaan Buku</span>
        </header>
        <?php if($level == 'admin_pemasaran' && $rData->request_status != 2): ?>
        <div class="alert alert-warning"><strong>PERHATIAN!</strong> Harap tunggu Admin Gudang untuk konfirmasi permintaan ini.</div>
        <?php elseif($level == 'admin_pemasaran' && $rData->request_status == 2 && $rData->flag == 2 && $rData->final_status != 2): ?>
        <div class="alert alert-success">
            <strong>PERHATIAN!</strong> Permintaan telah di konfirmasi. Harap tunggu Admin Gudang memproses permintaan ini.
        </div>
        <?php endif; ?>
        <div
            class="list-group list-group-flush list-group-bordered"
            id="list-group-edit"
        >

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Judul Buku</span>
                <strong style="max-width:50%"><?= $rData->book_title; ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Nomor Order</span>
                <strong style="max-width:50%"><?= $rData->order_number; ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Jumlah Permintaan</span>
                <strong style="max-width:50%"><?= $rData->total; ?></strong>
            </div>

            <div class="list-group-item justify-content-between">
                <span class="text-muted">Catatan</span>
                <strong class="text-justify" style="max-width:50%"><?= $rData->notes; ?></strong>
            </div>
        </div>

        <?php if($rData->request_status != 2 && ($level == 'superadmin' || $level == 'admin_gudang')): ?>
        <hr class="m-0">
        <div class="card-body">
            <div class="card-button">
<!-- button aksi -->
<button
    id="btn_modal_request_action"
    title="Aksi admin"
    class="btn btn-secondary btn-disabled"
    data-toggle="modal"
    data-target="#modal_request_action"
><i class="fa fa-thumbs-up"></i> Aksi</button>
<!-- Modal Aksi -->
<div
    class="modal fade"
    id="modal_request_action"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal_request_action"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aksi permintaan</h5>
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
            <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk melakukan aksi pada progress permintaan.</div>
                <form action="<?= base_url('book_request/action_request/'.$rData->book_request_id);?>" method="post">
                <fieldset>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="font-weight-bold">Aksi</label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="flag" value="2"/>
                                <i class="fa fa-check text-success"></i> Setuju
                            </label>
                        </div>
                        <div class="row">
                            <label>
                                <input type="radio" name="flag" value="1"/>
                                <i class="fa fa-times text-danger"></i> Tolak
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan</label>
                        <textarea
                            cols="40"
                            rows="6"
                            class="form-control summernote-basic"
                            id="request_notes_admin"
                            name="request_notes_admin"
                        ></textarea>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light ml-auto"
                    data-dismiss="modal"
                >Close</button>
                <button
                    class="btn btn-primary"
                    type="submit"
                >Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Aksi -->
            </div>
        </div>
        <?php elseif($rData->request_status == 2 && ($level == 'superadmin' || $level == 'admin_gudang' || $level == 'admin_pemasaran')): ?>
        <hr class="m-0">
        <div class="card-body">
            <div class="card-button">
                <button title="Catatan admin" class="btn btn-outline-success" data-toggle="modal" data-target="#modal_request_notes_admin">Catatan Admin</button>
                <!-- modal_request_notes_admin -->
                <div
                    class="modal fade"
                    id="modal_request_notes_admin"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="modal_request_notes_admin"
                    aria-hidden="true"
                >
                    <div
                        class="modal-dialog modal-dialog-centered"
                        role="document"
                    >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Catatan aksi permintaan oleh admin</h5>
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
                                <label for="" class="font-weight-bold">Aksi</label>
                                <p><?php if($rData->flag == 1){echo 'Ditolak.';}elseif($rData->flag == 2){echo 'Diterima.';}?></p>
                                <label for="" class="font-weight-bold">Tanggal Permintaan di Proses</label>
                                <p><?= date('d F Y H:i:s', strtotime($rData->request_date)); ?></p>
                                <label for="" class="font-weight-bold">User</label>
                                <p><?= $rData->request_user; ?></p>
                                <label for="" class="font-weight-bold">Catatan</label>
                                <p class="text-justify"><?= $rData->request_notes_admin; ?></p>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-light ml-auto"
                                    data-dismiss="modal"
                                >Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal_request_notes_admin -->
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>