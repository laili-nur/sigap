<?php
$level              = check_level();
$per_page           = 10;
$keyword            = $this->input->get('keyword');
$category           = $this->input->get('category');
$type               = $this->input->get('type');
$print_order_status = $this->input->get('print_order_status');
$date_year          = $this->input->get('date_year');
$date_month         = $this->input->get('date_month');
$hide               = $this->input->get('hide');
$page               = $this->uri->segment(2);
$i                  = isset($page) ? $page * $per_page - $per_page : 0;

$category_options = [
    ''  => '- Filter Kategori Cetak -',
    'new' => 'Cetak Baru',
    'revise' => 'Cetak Ulang Revisi',
    'reprint' => 'Cetak Ulang Non Revisi',
    'nonbook' => 'Cetak Non Buku',
    'outsideprint' => 'Cetak Di Luar',
    'from_outside' => 'Cetak Dari Luar'
];

$type_options = [
    ''  => '- Filter Tipe Cetak -',
    'pod' => 'Cetak POD',
    'offset' => 'Cetak Offset'
];

$date_year_options = [
    ''  => '- Filter Tahun Cetak -',
];

for ($dy = intval(date('Y')); $dy >= 2015; $dy--) {
    $date_year_options[$dy] = $dy;
}

$date_month_options = [
    ''  => '- Filter Bulan Cetak -',
];

for ($m = 1; $m <= 12; $m++) {
    $date_month_options[$m] = date('F', mktime(0, 0, 0, $m, 1));
}

$print_order_status_options = [
    ''  => '- Filter Status Cetak -',
    'waiting' => 'Belum diproses',
    'preprint' => 'Proses Pracetak',
    'print' => 'Proses Cetak',
    'postprint' => 'Proses Jilid',
    'reject' => 'Ditolak',
    'finish' => 'Selesai'
];
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
        <?php if ($level == 'superadmin' || $level == 'admin_percetakan') : ?>
        <a href="<?= base_url("$pages/add"); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-fw"></i>
            Tambah</a>
        <?php endif; ?>
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
                            <div class="col-12 col-md-3 mb-2">
                                <label for="per_page">Data per halaman</label>
                                <?= form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="category">Kategori Cetak</label>
                                <?= form_dropdown('category', $category_options, $category, 'id="category" class="form-control custom-select d-block" title="Filter Kategori Cetak"'); ?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="type">Tipe Cetak</label>
                                <?= form_dropdown('type', $type_options, $type, 'id="type" class="form-control custom-select d-block" title="Filter Tipe Cetak"'); ?>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="print_order_status">Status</label>
                                <?= form_dropdown('print_order_status', $print_order_status_options, $print_order_status, 'id="print_order_status" class="form-control custom-select d-block" title="Filter Status Cetak"'); ?>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="date_year">Tahun</label>
                                <?= form_dropdown('date_year', $date_year_options, $date_year, 'id="date_year" class="form-control custom-select d-block" title="Filter Tahun Cetak"'); ?>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="date_month">Bulan</label>
                                <?= form_dropdown('date_month', $date_month_options, $date_month, 'id="date_month" class="form-control custom-select d-block" title="Filter Bulan Cetak"'); ?>
                            </div>
                            <div class="col-12 col-md-3">
                                <label for="status">Pencarian</label>
                                <?= form_input('keyword', $keyword, 'placeholder="Cari berdasarkan Judul, Nomor, Kode, Nama Pesanan" class="form-control"'); ?>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label>&nbsp;</label>
                                <div class="btn-group btn-block" role="group" aria-label="Filter button">
                                    <button class="btn btn-secondary" type="button"
                                        onclick="location.href = '<?= base_url($pages); ?>'"> Reset</button>
                                    <button class="btn btn-primary" type="submit" value="Submit"><i
                                            class="fa fa-filter"></i> Filter</button>
                                    <?php if ($level == "superadmin" || $level == "admin_percetakan") : ?>
                                    <button class="btn btn-success" type="submit" id="excel" name="excel"
                                        value="1">Excel</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <?php if ($print_orders) : ?>
                    <table class="table table-striped mb-0 table-responsive">
                        <thead>
                            <tr>
                                <th scope="col" class="pl-4 align-middle text-center">No</th>
                                <th scope="col" style="min-width:400px;" class="align-middle text-center">Judul</th>
                                <th scope="col" style="min-width:150px;" class="align-middle text-center">Kategori</th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Nomor Order
                                </th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Jumlah Cetak
                                </th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Tipe Cetak
                                </th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Tanggal Masuk
                                </th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Tanggal
                                    Selesai</th>
                                <th scope="col" style="min-width:100px;" class="align-middle text-center">Deadline</th>
                                <th scope="col" style="min-width:70px;" class="align-middle text-center">Status</th>
                                <?php if ($level == 'superadmin') : ?>
                                <th style="min-width:150px;" class="align-middle text-center"> &nbsp; </th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($print_orders as $print_order) : ?>
                            <tr>
                                <td class="align-middle text-center pl-4"><?= ++$i; ?></td>
                                <td class="align-middle text-left">
                                    <a href="<?= base_url('print_order/view/' . $print_order->print_order_id . ''); ?>"
                                        class="font-weight-bold">
                                        <?= highlight_keyword($print_order->title, $keyword); ?>
                                    </a>
                                </td>
                                <td class="align-middle text-center">
                                    <?= get_print_order_category()[$print_order->category]; ?></td>
                                <td class="align-middle text-center">
                                    <?= highlight_keyword($print_order->order_number, $keyword); ?></td>
                                <td class="align-middle text-center"><?= $print_order->total; ?></td>
                                <td class="align-middle text-center"><?= $print_order->type; ?></td>
                                <td class="align-middle text-center"><?= format_datetime($print_order->entry_date); ?>
                                </td>
                                <td class="align-middle text-center"><?= format_datetime($print_order->finish_date); ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?= deadline_color($print_order->deadline_date, $print_order->print_order_status); ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?= get_print_order_status()[$print_order->print_order_status] ?? $print_order->print_order_status; ?>
                                </td>
                                <?php if ($level == 'superadmin') : ?>
                                <td class="align-middle text-center">
                                    <a href="<?= base_url('print_order/edit/' . $print_order->print_order_id . ''); ?>"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fa fa-pencil-alt"></i>
                                        <span class="sr-only">Edit</span>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#modal-hapus-<?= $print_order->print_order_id; ?>"><i
                                            class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                    <div class="text-left">
                                        <div class="modal modal-alert fade"
                                            id="modal-hapus-<?= $print_order->print_order_id; ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-hapus" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fa fa-exclamation-triangle text-red mr-1"></i>
                                                            Konfirmasi
                                                            Hapus
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin akan menghapus print_order <span
                                                                class="font-weight-bold"><?= $print_order->title; ?></span>?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="location.href='<?= base_url('print_order/delete/' . $print_order->print_order_id . ''); ?>'"
                                                            data-dismiss="modal">Hapus</button>
                                                        <button type="button" class="btn btn-light"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
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