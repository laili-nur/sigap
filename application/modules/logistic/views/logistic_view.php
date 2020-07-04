<?php
$level              = check_level();
?>
<header class="page-title-bar mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('logistic'); ?>">logistic</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">
                    <?= $lData->name; ?></a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Logistik </h1>
        </div>
        <a href="<?= base_url("logistic/edit_logistic/".$lData->logistic_id); ?>" class="btn btn-primary btn-sm">
            <i class="fa fa-edit fa-fw"></i> Edit Logistik
        </a>
    </div>
</header>

<div class="page-section">
    <section
        id="data-logistic"
        class="card"
    >
        <header class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link active show"
                        data-toggle="tab"
                        href="#logistic-data"
                    ><i class="fa fa-info-circle"></i> Detail Logistik</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-toggle="tab"
                        href="#stock-data"
                    ><i class="fa fa-poll"></i> Stok Logistik</a>
                </li>
            </ul>
        </header>
        <div class="card-body">
            <?php //=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
            <div class="tab-content">
                <!-- book-data -->
                <div
                    class="tab-pane fade active show"
                    id="logistic-data"
                >
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Nama Logistik </td>
                                    <td><strong><?= $lData->name; ?></strong> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tipe </td>
                                    <td><?= $lData->type; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Kategori </td>
                                    <td><?= $lData->category; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Catatan </td>
                                    <td><?= $lData->notes; ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Tanggal di buat </td>
                                    <td><?= date('d F Y H:i:s',strtotime($lData->date_created)); ?></td>
                                </tr>
                                <tr>
                                    <td width="200px"> User </td>
                                    <td><?= $lData->user_created; ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Tanggal di edit </td>
                                    <td><?= date('d F Y H:i:s',strtotime($lData->date_edited)); ?></td>
                                </tr>
                                <tr>
                                    <td width="200px"> User </td>
                                    <td><?= $lData->user_edited; ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- book-data -->

                <!-- stock-data -->







<div
    class="tab-pane fade"
    id="stock-data"
>
    <div id="reload-stock">
        <?php if($level == 'superadmin' || $level == 'admin_penerbitan' || $level == 'admin_percetakan' || $level == 'admin_gudang' || $level == 'admin_keuangan'): ?>
            <?php $i = 1; ?>
            <div class="row">
                <div class="col-6 text-left">
                    <strong>Stok Logistik</strong>
                </div>
                <div class="col-6 text-right">
                    <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                    <button
                        class="btn btn-primary btn-sm "
                        title="Ubah Stok"
                        class="btn btn-primary btn-sm"
                        data-toggle="modal"
                        data-target="#modal_add_stock"
                    >
                        <i class="fa fa-plus fa-fw"></i> Tambah
                    </button>
                    <!-- Modal add stock -->
                    <div
                        class="modal fade"
                        id="modal_add_stock"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="modal_add_stock"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-dialog-centered"
                            role="document"
                        >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Stok</h5>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk mengubah stok logistik.</div>
                                <form action="<?= base_url('logistic/add_logistic_stock');?>" method="post">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nama Logistik</label>
                                        <input type="text" class="form-control" value="<?= $lData->name; ?>" disabled/>
                                        <input type="hidden" class="form-control" id="logistic_id" name="logistic_id" value="<?= $lData->logistic_id;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="stock_warehouse">Stok Gudang</label>
                                        <input type="number" class="form-control" name="stock_warehouse" id="stock_warehouse" value="<td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_warehouse;}else{echo "-";} ?></td>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="stock_production">Stok Produksi</label>
                                        <input type="number" class="form-control" name="stock_production" id="stock_production" value="<?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_production;}else{echo "-";} ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="stock_other">Stok Lainnya</label>
                                        <input type="number" class="form-control" name="stock_other" id="stock_other" value="<?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_other;}else{echo "-";} ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="input_notes">Catatan</label>
                                        <textarea
                                            rows="6"
                                            class="form-control summernote-basic"
                                            id="input_notes"
                                            name="input_notes"
                                        ></textarea>
                                    </div>
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
                    <!-- Modal Add Stok -->
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0 nowrap">
                    <tbody>
                        <tr>
                            <td width="160px">Nama Logistik</td>
                            <td><strong><?= $lData->name; ?></strong></td>
                        </tr>
                        <tr>
                            <td width="160px">Stok Gudang</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_warehouse;}else{echo "-";} ?></td>
                        </tr>
                        <tr>
                            <td width="160px">Stok Produksi</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_production;}else{echo "-";} ?></td>
                        </tr>
                        <tr>
                            <td width="160px">Stok Lainnya</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_other;}else{echo "-";} ?></td>
                        </tr>
                        <tr>
                            <td width="160px">Perubahan Terakhir</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo date('d F Y H:i:s',strtotime($stock_last->input_date));}else{echo "-";} ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if(empty($stock_history) == FALSE) : ?>
            <hr>
            <!-- Log Perubahan Stok -->
            <p class="font-weight-bold">Log Perubahan Stok</p>
            <div class="table-responsive" style="max-height:500px;">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">No</th>
                            <th scope="col">Stok Gudang</th>
                            <th scope="col">Stok Produksi</th>
                            <th scope="col">Stok Lainnya</th>
                            <th scope="col">Tipe Input</th>
                            <th scope="col">User Input</th>
                            <th scope="col">Tanggal Input</th>
                            <th scope="col">Catatan</th>
                            <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                            <th scope="col"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stock_history as $history) : ?>
                            <tr class="text-center">
                                <td><?= $i++; ?></td>
                                <td><?= $history->stock_warehouse; ?></td>
                                <td><?= $history->stock_production; ?></td>
                                <td><?= $history->stock_other; ?></td>
                                <td>
                                    <?php
                                        if($history->input_type == 0){echo 'Input menggunakan fitur logistik.';}
                                        elseif($history->input_type == 1){echo 'Input menggunakan fitur permintaan logistik.';}
                                        else{echo '';}
                                    ?>
                                </td>
                                <td><?= $history->input_user; ?></td>
                                <td><?= date('d F Y H:i:s',strtotime($history->input_date)); ?></td>
                                <td><?= $history->input_notes; ?></td>
                                <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                                <td>
                                    <button
                                        title="Delete"
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#modal_delete_stock<?= $history->logistic_stock_id; ?>"
                                    >
                                        <i class="fa fa-trash-alt"></i>
                                        <span class="sr-only">Delete</span>
                                    </button>
                                    <!-- Modal Hapus -->
                                    <div
                                        class="modal modal-alert fade"
                                        id="modal_delete_stock<?= $history->logistic_stock_id; ?>"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-labelledby="modal_delete_stock<?= $history->logistic_stock_id; ?>"
                                        aria-hidden="true"
                                    >
                                        <div
                                            class="modal-dialog"
                                            role="document"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi
                                                        Hapus</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin akan menghapus data stok logistik dari <span class="font-weight-bold"><?= $lData->name; ?></span> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-light"
                                                        data-dismiss="modal"
                                                    >Close</button>
                                                    <a
                                                        href="<?= base_url('logistic/delete_logistic_stock/'.$history->logistic_stock_id); ?>"
                                                        type="button"
                                                        class="btn btn-danger"
                                                    >
                                                        Hapus
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Hapus -->
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            <!-- Log perubahan Stok -->
            <?php else : ?>
            <p>Data hanya dapat dilihat oleh Superadmin, Admin Penerbitan, Admin Percetakan, Admin Gudang, dan Admin Keuangan.</p>
            <?php endif; ?>
    </div>
</div>























                <!-- stock-data -->
            </div>
        </div>
    </section>
</div>
