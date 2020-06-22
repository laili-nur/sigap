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
                    <?php if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'): ?>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Tanggal di buat </td>
                                    <td><strong><?= $lData->date_created; ?></strong> </td>
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
                                    <td><strong><?= $lData->date_edited; ?></strong> </td>
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
    <div id="reload-author">
        <?php if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_penerbitan' || $_SESSION['level'] == 'admin_percetakan' || $_SESSION['level'] == 'admin_gudang' || $_SESSION['level'] == 'admin_pemasaran'): ?>
            <?php $i = 1; ?>
            <div class="row">
                <div class="col-6 text-left">
                    <strong>Stok Buku</strong>
                </div>
                <div class="col-6 text-right">
                    <?php if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'): ?>
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
                                    <h5 class="modal-title">Aksi pracetak</h5>
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
                                    <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk mengubah stok buku.</div>
                                <form action="<?= base_url('book/add_book_stock');?>" method="post">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Judul Buku</label>
                                        <input type="text" class="form-control" value="<?= $input->book_title; ?>" disabled/>
                                        <input type="hidden" class="form-control" id="book_id" name="book_id" value="<?= $input->book_id;?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="stock_in_warehouse">Stok dalam gudang</label>
                                        <input type="number" class="form-control" name="stock_in_warehouse" id="stock_in_warehouse" value="<td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_in_warehouse;}else{echo "-";} ?></td>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="stock_out_warehouse">Stok luar gudang</label>
                                        <input type="number" class="form-control" name="stock_out_warehouse" id="stock_out_warehouse" value="<?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_out_warehouse;}else{echo "-";} ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="stock_pemasaran">Stok pemasaran</label>
                                        <input type="number" class="form-control" name="stock_marketing" id="stock_marketing" value="<?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_marketing;}else{echo "-";} ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="stock_input_notes">Catatan</label>
                                        <textarea
                                            rows="6"
                                            class="form-control summernote-basic"
                                            id="stock_input_notes"
                                            name="stock_input_notes"
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
                            <td width="160px">Judul Buku</td>
                            <td><strong><?= $input->book_title; ?></strong></td>
                        </tr>
                        <tr>
                            <td width="160px">Stok Dalam gudang</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_in_warehouse;}else{echo "-";} ?></td>
                        </tr>
                        <tr>
                            <td width="160px">Stok Luar Gudang</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_out_warehouse;}else{echo "-";} ?></td>
                        </tr>
                        <tr>
                            <td width="160px">Stok Pemasaran</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo $stock_last->stock_marketing;}else{echo "-";} ?></td>
                        </tr>
                        <tr>
                            <td width="160px">Perubahan Terakhir</td>
                            <td><?php if(empty($stock_last) == FALSE){ echo date('d F Y H:i:s',strtotime($stock_last->stock_input_date));}else{echo "-";} ?></td>
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
                            <th scope="col">Stok Dalam Gudang</th>
                            <th scope="col">Stok Luar Gudang</th>
                            <th scope="col">Stok Pemasaran</th>
                            <th scope="col">Tipe Input</th>
                            <th scope="col">User Input</th>
                            <th scope="col">Tanggal Input</th>
                            <th scope="col">Catatan</th>
                            <?php if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'): ?>
                            <th scope="col"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stock_history as $history) : ?>
                            <tr class="text-center">
                                <td><?= $i++; ?></td>
                                <td><?= $history->stock_in_warehouse; ?></td>
                                <td><?= $history->stock_out_warehouse; ?></td>
                                <td><?= $history->stock_marketing; ?></td>
                                <td>
                                    <?php
                                        if($history->stock_input_type == 0){echo 'Input menggunakan fitur buku.';}
                                        elseif($history->stock_input_type == 1){echo 'Input menggunakan fitur printing.';}
                                        elseif($history->stock_input_type == 2){echo 'Input menggunakan fitur permintaan buku.';}
                                        else{echo '';}
                                    ?>
                                </td>
                                <td><?= $history->stock_input_user; ?></td>
                                <td><?= date('d F Y H:i:s',strtotime($history->stock_input_date)); ?></td>
                                <td><?= $history->stock_input_notes; ?></td>
                                <?php if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_gudang'): ?>
                                <td>
                                    <button
                                        title="Delete"
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#modal_delete_stock<?= $history->book_stock_id; ?>"
                                    >
                                        <i class="fa fa-trash-alt"></i>
                                        <span class="sr-only">Delete</span>
                                    </button>
                                    <!-- Modal Hapus -->
                                    <div
                                        class="modal modal-alert fade"
                                        id="modal_delete_stock<?= $history->book_stock_id; ?>"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-labelledby="modal_delete_stock<?= $history->book_stock_id; ?>"
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
                                                    <p>Apakah anda yakin akan menghapus data stok buku dari buku <span class="font-weight-bold"><?= $input->book_title; ?></span> ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-light"
                                                        data-dismiss="modal"
                                                    >Close</button>
                                                    <a
                                                        href="<?= base_url('book/delete_book_stock/'.$history->book_stock_id); ?>"
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
            <p>Data hanya dapat dilihat oleh Superadmin, Admin Penerbitan, Admin Percetakan, Admin Gudang, dan Admin Pemasaran</p>
            <?php endif; ?>
    </div>
</div>























                <!-- stock-data -->
            </div>
        </div>
    </section>
</div>
