<?php
$keyword = $this->input->get('keyword');
$year   = $this->input->get('year');
$page = $this->uri->segment(2);
$per_page = 10;
// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;
?>

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Dokumen</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Dokumen </h1>
            <span class="badge badge-info">Total : <?= $total; ?></span>
        </div>
        <a
            href="<?= base_url("$pages/add"); ?>"
            class="btn btn-primary btn-sm <?= !is_admin() ? 'd-none' : ''; ?>"
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
                            <div class="col-12 col-md-3 mb-3">
                                <label for="year">Tahun</label>
                                <?= form_dropdown('year', getYearsDocument(), $this->input->get('year'), 'id="year" class="form-control custom-select d-block" title="Filter tahun"'); ?>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="keyword">Pencarian</label>
                                <?= form_input('keyword', $this->input->get('keyword'), ['placeholder' => 'Cari berdasarkan nama dokumen', 'class' => 'form-control']); ?>
                            </div>
                            <div class="col-12 col-md-3">
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
                    <div>
                        <?php if ($documents) : ?>
                            <div>
                                <?php foreach ($documents as $document) : ?>
                                    <div class="px-3 py-1">
                                        <div class="card card-fluid mb-2">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <a href="<?= base_url('document/download_file/documentfile/' . $document->document_file); ?>">
                                                            <div class="tile tile-circle tile-lg">
                                                                <?php if (lihatEkstensi($document->document_file) === 'pdf') : ?>
                                                                    <span class="far fa-file-pdf"></span>
                                                                <?php elseif (lihatEkstensi($document->document_file) === 'jpg' or lihatEkstensi($document->document_file) === 'jpeg' or lihatEkstensi($document->document_file) === 'png') : ?>
                                                                    <span class="far fa-file-image"></span>
                                                                <?php elseif (lihatEkstensi($document->document_file) === 'doc' or lihatEkstensi($document->document_file) === 'docx') : ?>
                                                                    <span class="far fa-file-word"></span>
                                                                <?php elseif (lihatEkstensi($document->document_file) === 'xls' or lihatEkstensi($document->document_file) === 'xlsx') : ?>
                                                                    <span class="far fa-file-excel"></span>
                                                                <?php elseif (lihatEkstensi($document->document_file) === 'zip' or lihatEkstensi($document->document_file) === 'rar') : ?>
                                                                    <span class="far fa-file-archive"></span>
                                                                <?php else : ?>
                                                                    <span class="far fa-file"></span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </a>
                                                    </div>


                                                    <div class="col">
                                                        <h3 class="card-title">
                                                            <?= $document->document_name; ?> <small class="text-muted"> -
                                                                <?= $document->document_year; ?></small>
                                                        </h3>
                                                        <h6 class="card-subtitle text-muted">
                                                            <?= $document->document_notes; ?>
                                                        </h6>
                                                    </div>


                                                    <div class="col-auto">
                                                        <?php if (!empty($document->document_file)) : ?>
                                                            <a
                                                                title="Download File"
                                                                class="btn btn-sm btn-primary"
                                                                href="<?= base_url('document/download_file/documentfile/' . $document->document_file); ?>"
                                                            ><i class="fa fa-download"></i><span class="sr-only">Download</span></a>
                                                        <?php endif; ?>
                                                        <?php if (!empty($document->document_file_link)) : ?>
                                                            <a
                                                                title="Kunjungi Link"
                                                                target="_blank"
                                                                class="btn btn-sm btn-primary"
                                                                href="<?= $document->document_file_link; ?>"
                                                            ><i class="fa fa-external-link-alt"></i><span class="sr-only">Download</span></a>
                                                        <?php endif; ?>
                                                        <a
                                                            title="Edit"
                                                            href="<?= base_url('document/edit/' . $document->document_id . ''); ?>"
                                                            class="btn btn-sm btn-secondary"
                                                        ><i class="fa fa-pencil-alt"></i><span class="sr-only">Edit</span>
                                                        </a>
                                                        <button
                                                            title="Hapus"
                                                            type="button"
                                                            class="btn btn-sm btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#modal-hapus-<?= $document->document_id; ?>"
                                                        ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div
                                        class="modal modal-alert fade"
                                        id="modal-hapus-<?= $document->document_id; ?>"
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
                                                        <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi Hapus</h5>
                                                </div>

                                                <div class="modal-body">
                                                    <p>Apakah anda yakin akan menghapus document <span class="font-weight-bold"><?= $document->document_name; ?></span>?</p>
                                                </div>

                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-danger"
                                                        onclick="location.href='<?= base_url('document/delete/' . $document->document_id . ''); ?>'"
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
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="text-center">Data tidak tersedia</p>
                            <?php endif; ?>
                            <?= $pagination ?? null; ?>
                            </div>
                    </div>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#year").select2({
        placeholder: '-- Filter tahun --',
        allowClear: true
    });
});
</script>
