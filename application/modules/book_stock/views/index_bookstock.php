<?php
$level              = check_level();
$per_page           = $this->input->get('per_page') ?? 10;
$published_year     = $this->input->get('published_year');
// $bookshelf_location = $this->input->get('bookshelf_location');
$warehouse_present   = $this->input->get('warehouse_present');
$keyword            = $this->input->get('keyword');
$page               = $this->uri->segment(2);
$i                  = isset($page) ? $page * $per_page - $per_page : 0;

?>

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Stok Buku</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Stok Buku </h1>
            <span class="badge badge-info">Total:
                <?= $total; ?>
            </span>
        </div>
        <!-- <a  href="<?= base_url("$pages/add"); ?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-plus fa-fw"></i> Tambah
        </a> -->
    </div>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-12">
            <section class="card card-fluid">
                <div class="card-body p-0">
                    <div class="p-3">
                        <?= form_open($pages, ['method' => 'GET']); ?>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label for="per_page">Data per halaman</label>
                                <?= form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label for="category">Tahun Terbit</label>
                                <?= form_dropdown('published_year', get_published_date(), $published_year, 'id="published_year" class="form-control custom-select d-block" title="Filter Tahun Terbit"'); ?>
                            </div>
                            <!-- <div class="col-12 col-md-3 mb-3">
                                <label for="category">Lokasi Rak</label>
                                <?//= form_dropdown('bookshelf_location', get_bookshelf_location(), $bookshelf_location, 'id="bookshelf_location" class="form-control custom-select d-block" title="Lokasi Rak"'); ?>
                            </div> -->
                            <div class="col-12 col-md-4 mb-3">
                                <label for="category">Jumlah Stok (Gudang)</label>
                                <?= form_dropdown('warehouse_present', get_warehouse_stock(), $warehouse_present, 'id="warehouse_present" class="form-control custom-select d-block" title="Total Stok Buku (Gudang)"'); ?>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="status">Pencarian</label>
                                <?= form_input('keyword', $keyword, 'placeholder="Cari berdasarkan Nama" class="form-control"'); ?>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label>&nbsp;</label>
                                <div class="btn-group btn-block" role="group" aria-label="Filter button">
                                    <button class="btn btn-secondary" type="button"
                                        onclick="location.href = '<?= base_url($pages); ?>'"> Reset</button>
                                    <button class="btn btn-primary" type="submit" value="Submit"><i
                                            class="fa fa-filter"></i> Filter</button>
                                    <?php if ($level == "superadmin" || $level == "admin_gudang") : ?>
                                    <button class="btn btn-success" type="submit" id="excel" name="excel"
                                        value="1">Excel</button>
                                    <!-- <a class="btn btn-success" id="excel" name="excel"
                                        href = '<?= base_url('/book_stock/generate_excel'); ?>'>Excel</a>
 -->
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <?php if ($book_stocks) : ?>
                    <table class="table table-striped mb-0 table-responsive">
                        <thead>
                            <tr>
                                <th scope="col" class="pl-4 align-middle text-center" rowspan="2">No</th>
                                <th scope="col" style="min-width:350px;" class="align-middle text-center" rowspan="2">
                                    Judul</th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center" rowspan="2">
                                    Tahun Terbit
                                </th>
                                <th scope="col" style="min-width:150px;" class="align-middle text-center" rowspan="2">
                                    ISBN</th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center" colspan="3">
                                    Stok</th>
                                <th scope="col" style="min-width:150px;" class="align-middle text-center" rowspan="2">
                                    Laris/Semi
                                    Laris
                                </th>
                                <?php if ($level == 'superadmin') : ?>
                                <th style="min-width:150px;" class="align-middle text-center" rowspan="2"> Aksi </th>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Gudang</th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Perpus</th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Showroom</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($book_stocks as $book_stock) : ?>
                            <tr>
                                <td class="align-middle text-center"><?= ++$i; ?></td>
                                <td class="align-middle">
                                    <!-- Perlu diedit sprtinya,, -->
                                    <a href="<?= base_url('book_stock/view/' . $book_stock->book_stock_id . ''); ?>"
                                        class="font-weight-bold">
                                        <?= highlight_keyword($book_stock->book_title, $keyword); ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?=konversiTahun($book_stock->published_date);?>
                                </td>
                                <td class="align-middle text-center">
                                    <?= $book_stock->isbn; ?></td>
                                </td>
                                <?php if($book_stock->warehouse_present <= 50) : ?>
                                <td class="align-middle text-center text-danger"><b>
                                        <?=$book_stock->warehouse_present; ?></b>
                                </td>
                                <?php else : ?>
                                <td class="align-middle text-center">
                                    <?=$book_stock->warehouse_present; ?>
                                </td>
                                <?php endif?>
                                <td class="align-middle text-center"><?=$book_stock->library_present?></td>
                                <td class="align-middle text-center"><?=$book_stock->showroom_present?></td>
                                <td class="align-middle text-center"><?=$book_stock->selling?></td>
                                <?php if ($level == 'superadmin') : ?>
                                <td style="min-width: 130px" class="align-middle text-center">
                                    <a href="<?= base_url('book_stock/edit/' . $book_stock->book_stock_id . ''
                                    // . $print_order->print_order_id . ''
                                    ); ?>" class="btn btn-sm btn-secondary" title="Edit Stok Buku">
                                        <i class="fa fa-pencil-alt"></i>
                                        <span class="sr-only">Edit Stok Buku</span>
                                    </a>
                                    <button title="Delete" type="button" class="btn btn-sm btn-danger"
                                        data-toggle="modal" data-target="#modal-hapus-<?= $book_stock->book_id; ?>"><i
                                            class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                    <div class="text-left">
                                        <div class="modal modal-alert fade"
                                            id="modal-hapus-<?= $book_stock->book_id; ?>" tabindex="-1" role="dialog"
                                            aria-labelledby="modal-hapus" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><i
                                                                class="fa fa-exclamation-triangle text-red mr-1"></i>
                                                            Konfirmasi Hapus</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin akan menghapus data stok buku <span
                                                                class="font-weight-bold"><?= $book_stock->book_title; ?></span>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                            data-dismiss="modal">Close</button>
                                                        <!-- <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Hapus</button> -->
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="location.href='<?= base_url('book_stock/delete/' . $book_stock->book_stock_id . ''); ?>'"
                                                            data-dismiss="modal">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <?php endif?>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <?php else : ?>
                    <p class="text-center my-5">Data tidak tersedia</p>
                    <?php endif; ?>
                    <?= $pagination ?? null; ?>
                </div>
            </section>
        </div>
    </div>
</div>