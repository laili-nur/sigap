<?php
$level              = check_level();
$per_page           = 10;
$keyword            = $this->input->get('keyword');
$status             = $this->input->get('status');
$type               = $this->input->get('type');
$page               = $this->uri->segment(2);
$i                  = isset($page) ? $page * $per_page - $per_page : 0;

$status_options = [
    ''  => '- Filter Status -',
    '0' => 'Proses Permintaan',
    '1' => 'Proses Finalisasi',
    '2' => 'Ditolak',
    '3' => 'Selesai'
];

$type_options = [
    ''  => '- Filter Status -',
    '0' => 'Permintaan Percetakan',
    '1' => 'Permintaan Gudang'
];
?>

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Permintaan Logistik</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Permintaan Logistik </h1>
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
                    <div class="p-3">
                        <?= form_open($pages, ['method' => 'GET']); ?>
                        <div class="row">
                            <div class="col-12 <?php if($level == 'superadmin' || $level == 'admin_gudang'){echo 'col-md-4';}elseif($level == 'admin_keuangan'){echo 'col-md-6';} ?>">
                                <label for="per_page">Data per halaman</label>
                                <?= form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                            <div class="col-12 col-md-4">
                                <label for="status">Tipe</label>
                                <?= form_dropdown('type', $type_options, $type, 'id="type" class="form-control custom-select d-block" title="Filter Tipe"'); ?>
                            </div>
                            <?php endif; ?>
                            <div class="col-12 <?php if($level == 'superadmin' || $level == 'admin_gudang'){echo 'col-md-4';}elseif($level == 'admin_keuangan'){echo 'col-md-6';} ?>">
                                <label for="status">Status</label>
                                <?= form_dropdown('status', $status_options, $status, 'id="status" class="form-control custom-select d-block" title="Filter Status"'); ?>
                            </div>
                            <div class="col-12 col-md-9">
                                <label for="status">Pencarian</label>
                                <?= form_input('keyword', $keyword, 'placeholder="Cari berdasarkan Judul, Nomor Order, Jumlah" class="form-control"'); ?>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label>&nbsp;</label>
                                <div
                                    class="btn-group btn-block"
                                    role="group"
                                    aria-label="Filter button"
                                >
                                    <button
                                        class="btn btn-secondary"
                                        type="button"
                                        onclick="location.href = '<?= base_url($pages); ?>'"
                                    > Reset</button>
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                        value="Submit"
                                    ><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <?php if ($logistic_request) : ?>
                        <table class="table table-striped mb-0 table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th
                                        scope="col"
                                        class="pl-4"
                                    >No</th>
                                    <th
                                        scope="col"
                                        style="min-width:300px;"
                                    >Judul</th>
                                    <th
                                        scope="col"
                                        style="min-width:150px;"
                                    >Nomor Order</th>
                                    <th
                                        scope="col"
                                        style="min-width:150px;"
                                    >Jumlah Permintaan</th>
                                    <th
                                        scope="col"
                                        style="min-width:200px;"
                                    >Tanggal Masuk</th>
                                    <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                                    <th
                                        scope="col"
                                        style="min-width:200px;"
                                    >Tipe</th>
                                    <?php endif; ?>
                                    <th
                                        scope="col"
                                        style="min-width:200px;"
                                    >Status</th>
                                    <?php if($level == 'superadmin'): ?>
                                    <th style="min-width:100px;"> &nbsp; </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logistic_request as $rData) : ?>
                                    <tr class="text-center">
                                        <td class="align-middle pl-4"><?= ++$i; ?></td>
                                        <td class="text-left align-middle">
                                            <a
                                                href="<?= base_url('logistic_request/view/' . $rData->logistic_request_id . ''); ?>"
                                                class="font-weight-bold"
                                            >
                                                <?= highlight_keyword($rData->name, $keyword); ?>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <?= highlight_keyword($rData->order_number, $keyword); ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= highlight_keyword($rData->total, $keyword); ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= date('d F Y H:i:s', strtotime($rData->entry_date)); ?>
                                        </td>
                                        <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                                        <td class="align-middle">
                                            <?php
                                                if($rData->type == 0){echo 'Permintaan Percetakan';}
                                                elseif($rData->type == 1){echo 'Permintaan Gudang';}
                                                else{'';}
                                            ?>
                                        </td>
                                        <?php endif; ?>
                                        <td class="align-middle">
                                            <?php
                                                if($rData->status == 0){echo 'Proses Permintaan';}
                                                elseif($rData->status == 1){echo 'Proses Finalisasi';}
                                                elseif($rData->status == 5){echo 'Ditolak';}
                                                elseif($rData->status == 6){echo 'Selesai';}
                                                else{'';}
                                            ?>
                                        </td>
                                        <?php if($level == 'superadmin'): ?>
                                        <td class="align-middle text-right">
                                            <a
                                                href="<?= base_url('logistic_request/edit/'.$rData->logistic_request_id); ?>"
                                                class="btn btn-sm btn-secondary"
                                            >
                                                <i class="fa fa-pencil-alt"></i>
                                                <span class="sr-only">Edit</span>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger"
                                                data-toggle="modal"
                                                data-target="#modal-hapus-<?= $rData->logistic_request_id; ?>"
                                            ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                            <div class="text-left">
                                                <div
                                                    class="modal modal-alert fade"
                                                    id="modal-hapus-<?= $rData->logistic_request_id; ?>"
                                                    tabindex="-1"
                                                    role="dialog"
                                                    aria-labelledby="modal-hapus-<?= $rData->logistic_request_id; ?>"
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
                                                                <p>Apakah anda yakin akan menghapus order cetak <span class="font-weight-bold"><?= $rData->name; ?></span>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-danger"
                                                                    onclick="location.href='<?= base_url('logistic_request/delete_logistic_request/'.$rData->logistic_request_id); ?>'"
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
                                        <?php endif; ?>
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