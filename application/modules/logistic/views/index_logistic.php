<?php
$level              = check_level();
$per_page           = 10;
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
                <a class="text-muted">Logistik</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Logistik </h1>
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
                            <div class="col-12 col-md-4">
                                <label for="per_page">Data per halaman</label>
                                <?= form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <div class="col-12 col-md-4">
                                <label for="status">Pencarian</label>
                                <?= form_input('keyword', $keyword, 'placeholder="Cari berdasarkan Nama, Tipe, Kategori" class="form-control"'); ?>
                            </div>
                            <div class="col-12 col-lg-4">
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
                    <?php if ($logistic) : ?>
                        <table class="table table-striped mb-0 table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th
                                        scope="col"
                                        class="pl-4"
                                    >No</th>
                                    <th
                                        scope="col"
                                        style="min-width:600px;"
                                    >Nama Logistik</th>
                                    <th
                                        scope="col"
                                        style="min-width:200px;"
                                    >Tipe Logistik</th>
                                    <th
                                        scope="col"
                                        style="min-width:200px;"
                                    >Kategori Logistik</th>
                                    <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                                    <th style="min-width:100px;"> &nbsp; </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logistic as $lData) : ?>
                                    <tr class="text-center">
                                        <td class="align-middle pl-4"><?= ++$i; ?></td>
                                        <td class="text-left align-middle">
                                            <a
                                                href="<?= base_url('logistic/view/' . $lData->logistic_id . ''); ?>"
                                                class="font-weight-bold"
                                            >
                                                <?= highlight_keyword($lData->name, $keyword); ?>
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <?= highlight_keyword($lData->type, $keyword); ?>
                                        </td>
                                        <td class="align-middle">
                                            <?= highlight_keyword($lData->category, $keyword); ?>
                                        </td>
                                        <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
                                        <td class="align-middle">
                                            <a
                                                href="<?= base_url('logistic/edit/'.$lData->logistic_id); ?>"
                                                class="btn btn-sm btn-secondary"
                                            >
                                                <i class="fa fa-pencil-alt"></i>
                                                <span class="sr-only">Edit</span>
                                            </a>
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger"
                                                data-toggle="modal"
                                                data-target="#modal-hapus-<?= $lData->logistic_id; ?>"
                                            ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                            <div class="text-left">
                                                <div
                                                    class="modal modal-alert fade"
                                                    id="modal-hapus-<?= $lData->logistic_id; ?>"
                                                    tabindex="-1"
                                                    role="dialog"
                                                    aria-labelledby="modal-hapus-<?= $lData->logistic_id; ?>"
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
                                                                <p>Apakah anda yakin akan menghapus logistik <span class="font-weight-bold"><?= $lData->name; ?></span>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-danger"
                                                                    onclick="location.href='<?= base_url('logistic/delete_logistic/'.$lData->logistic_id); ?>'"
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