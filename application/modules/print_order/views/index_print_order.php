<?php
// data number
$per_page = 10;
$keyword = $this->input->get('keyword');
$page     = $this->uri->segment(2);
$i        = isset($page) ? $page * $per_page - $per_page : 0;
?>

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Order Cetak</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Order Cetak </h1>
            <span class="badge badge-info">Total : <?= $total; ?></span>
        </div>
        <a
            href="<?= base_url("$pages/add"); ?>"
            class="btn btn-primary btn-sm"
        ><i class="fa fa-plus fa-fw"></i> Tambah</a>
    </div>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-12">
            <section class="card card-fluid">
                <div class="card-body p-0">
                    <?php if ($print_orders) : ?>
                        <table class="table table-striped mb-0 table-responsive">
                            <thead>
                                <tr>
                                    <th
                                        scope="col"
                                        class="pl-4"
                                    >No</th>
                                    <th
                                        scope="col"
                                        style="min-width:200px;"
                                    >Judul</th>
                                    <th
                                        scope="col"
                                        style="min-width:150px;"
                                    >Kategori</th>
                                    <th
                                        scope="col"
                                        style="min-width:100px;"
                                    >Penulis</th>
                                    <th
                                        scope="col"
                                        style="min-width:100px;"
                                    >Nomor Order</th>
                                    <th
                                        scope="col"
                                        style="min-width:100px;"
                                    >Jumlah Copy</th>
                                    <th
                                        scope="col"
                                        style="min-width:100px;"
                                    >Tipe Cetak</th>
                                    <th
                                        scope="col"
                                        style="min-width:100px;"
                                    >Prioritas</th>
                                    <th
                                        scope="col"
                                        style="min-width:100px;"
                                    >Tanggal Masuk</th>
                                    <th
                                        scope="col"
                                        style="min-width:70px;"
                                    >Status</th>
                                    <th style="min-width:150px;"> &nbsp; </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($print_orders as $print_order) : ?>
                                    <tr>
                                        <td class="align-middle pl-4"><?= ++$i; ?></td>
                                        <td class="align-middle">
                                            <a
                                                href="<?= base_url('print_order/view/' . $print_order->print_order_id . ''); ?>"
                                                class="font-weight-bold"
                                            >
                                                <?= highlight_keyword($print_order->book_title, $keyword); ?>
                                            </a>
                                        </td>
                                        <td class="align-middle"><?= $print_order->category_name; ?></td>
                                        <td class="align-middle">
                                            <?= isset($print_order->author_name) ? highlight_keyword($print_order->author_name, $keyword) : '-'; ?>
                                            <button
                                                type="button"
                                                class="btn btn-link btn-sm m-0 p-0 <?= count($print_order->authors) <= 1 ? 'd-none' : ''; ?>"
                                                data-container="body"
                                                data-toggle="popover"
                                                data-placement="right"
                                                data-html="true"
                                                data-trigger="hover"
                                                data-content='<?= expand($print_order->authors); ?>'
                                            >
                                                <i class="fa fa-users"></i>
                                            </button>
                                        </td>
                                        <td class="align-middle"><?= $print_order->order_number; ?></td>
                                        <td class="align-middle"><?= $print_order->copies; ?></td>
                                        <td class="align-middle"><?= $print_order->type; ?></td>
                                        <td class="align-middle"><?= $print_order->priority; ?></td>
                                        <td class="align-middle"><?= $print_order->entry_date; ?></td>
                                        <td class="align-middle"><?= $print_order->status; ?></td>
                                        <td class="align-middle text-right">
                                            <a
                                                href="<?= base_url('print_order/edit/' . $print_order->print_order_id . ''); ?>"
                                                class="btn btn-sm btn-secondary"
                                            >
                                                <i class="fa fa-pencil-alt"></i>
                                                <span class="sr-only">Edit</span>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger"
                                                data-toggle="modal"
                                                data-target="#modal-hapus-<?= $print_order->print_order_id; ?>"
                                            ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                            <div class="text-left">
                                                <div
                                                    class="modal modal-alert fade"
                                                    id="modal-hapus-<?= $print_order->print_order_id; ?>"
                                                    tabindex="-1"
                                                    role="dialog"
                                                    aria-labelledby="modal-hapus"
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
                                                                <p>Apakah anda yakin akan menghapus print_order <span class="font-weight-bold"><?= $print_order->book_title; ?></span>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-danger"
                                                                    onclick="location.href='<?= base_url('print_order/delete/' . $print_order->print_order_id . ''); ?>'"
                                                                    data-dismiss="modal"
                                                                >Hapus</button>
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-light"
                                                                    data-dismiss="modal"
                                                                >Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p class="text-center">Data tidak tersedia</p>
                    <?php endif; ?>
                    <?= $pagination ?? null; ?>
                </div>
            </section>
        </div>
    </div>
</div>
