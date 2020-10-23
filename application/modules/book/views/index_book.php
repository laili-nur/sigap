<?php
$per_page       = $this->input->get('per_page') ?? 10;
$keyword        = $this->input->get('keyword');
$category       = $this->input->get('category');
$status         = $this->input->get('status');
$reprint        = $this->input->get('reprint');
$published_year = $this->input->get('published_year');
$from_outside   = $this->input->get('from_outside');
$page           = $this->uri->segment(2);
// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;

$hakcipta_status_options = [
    '' => 'Semua',
    'done' => 'Sudah jadi',
    'process' => 'Dalam Proses'
];

$reprint_options = [
    '' => 'Semua',
    'n' => ' Buku Baru',
    'y' => ' Buku Cetak Ulang',
];
echo $this->db->last_query();
?>

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Buku</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Buku </h1>
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
                            <div class="col-12 col-md-2 mb-3">
                                <label for="per_page">Data per halaman</label>
                                <?= form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="category">Kategori</label>
                                <?= form_dropdown('category', get_dropdown_list_category(), $category, 'id="category" class="form-control custom-select d-block" title="Filter Kategori"'); ?>
                            </div>
                            <div class="col-12 col-md-2 mb-3">
                                <label for="published_year">Tahun Terbit</label>
                                <?= form_dropdown('published_year', get_published_date(), $published_year, 'id="published_year" class="form-control custom-select d-block" title="Filter Tahun Terbit"'); ?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="reprint">Status Buku</label>
                                <?= form_dropdown('reprint', $reprint_options, $reprint, 'id="reprint" class="form-control custom-select d-block" title="Filter Naskah"'); ?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="hakcipta_status">Status Hak Cipta</label>
                                <?= form_dropdown('hakcipta_status', $hakcipta_status_options, $status, 'id="hakcipta_status" class="form-control custom-select d-block" title="Filter Status Hak Cipta"'); ?>
                            </div>
                            <div class="col-12 col-lg-2 mb-3">
                                <label for="from_outside">Asal Buku</label>
                                <?= form_dropdown('from_outside', ['' => '-- Pilih --', 0 => 'Buku UGM Press', 1 => 'Buku dari Luar'], $from_outside, 'id="from_outside" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <div class="col-12 col-lg-7 mb-3">
                                <label>&nbsp;</label>
                                <?= form_input('keyword', $keyword, 'id="keyword" placeholder="Cari berdasarkan Judul Buku, Kode Buku, Penulis, atau ISBN" class="form-control"'); ?>
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
                    <?php if ($books) : ?>
                        <div class="double-scroll">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            class="pl-3"
                                        >No</th>
                                        <th
                                            scope="col"
                                            style="min-width:350px;"
                                        >Judul Buku</th>
                                        <th
                                            scope="col"
                                            style="min-width:220px;"
                                        >Kategori</th>
                                        <th
                                            scope="col"
                                            style="min-width:50px;"
                                        >Tahun Terbit</th>
                                        <th
                                            scope="col"
                                            style="min-width:150px;"
                                        >Penulis</th>
                                        <!-- <th
                                            scope="col"
                                            style="min-width:150px;"
                                        >Fakultas</th> -->
                                        <th scope="col">Kode</th>
                                        <th
                                            scope="col"
                                            style="min-width:150px;"
                                        >ISBN</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Hak Cipta</th>
                                        <?php if (is_admin()) : ?>
                                            <th style="min-width:170px;"> &nbsp; </th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($books as $book) : ?>
                                        <tr>
                                            <td class="align-middle pl-3"><?= ++$i; ?></td>
                                            <td class="align-middle">
                                                <a
                                                    href="<?= base_url('book/view/' . $book->book_id . ''); ?>"
                                                    class="font-weight-bold"
                                                >
                                                    <?= highlight_keyword($book->book_title, $keyword); ?>
                                                </a>
                                            </td>
                                            <td class="align-middle"><?= $book->category_name; ?></td>
                                            <td class="align-middle"><?= konversiTahun($book->published_date); ?></td>
                                            <td class="align-middle">
                                                <?= isset($book->author_name) ? highlight_keyword($book->author_name, $keyword) : '-'; ?>
                                                <button
                                                    type="button"
                                                    class="btn btn-link btn-sm m-0 p-0 <?= count($book->authors) <= 1 ? 'd-none' : ''; ?>"
                                                    data-container="body"
                                                    data-toggle="popover"
                                                    data-placement="right"
                                                    data-html="true"
                                                    data-trigger="hover"
                                                    data-content='<?= expand($book->authors); ?>'
                                                >
                                                    <i class="fa fa-users"></i>
                                                </button>
                                            </td>
                                            <!-- <td class="align-middle"><?= $book->work_unit_name; ?></td> -->
                                            <td class="align-middle"><?= $book->book_code; ?></td>
                                            <td class="align-middle"><?= $book->isbn; ?></td>
                                            <td class="align-middle"><?= $book->is_reprint == 'y' ? 'Cetak Ulang' : 'Baru'; ?></td>
                                            <td class="align-middle">
                                                <?= $book->status_hak_cipta == '2' ? '<span class="badge badge-success">Sudah Jadi</span>' : ''; ?>
                                                <?= $book->status_hak_cipta == '1' ? '<span class="badge badge-warning">Dalam Proses</span>' : ''; ?>
                                            </td>
                                            <?php if (is_admin()) : ?>
                                                <td
                                                    style="min-width: 130px"
                                                    class="align-middle text-right"
                                                >
                                                    <a
                                                        title="Edit Hak Cipta"
                                                        href="<?= base_url('book/edit_hakcipta/' . $book->book_id . ''); ?>"
                                                        class="btn btn-sm btn-secondary"
                                                    >
                                                        <i class="fa fa-file-alt"></i>
                                                    </a>
                                                    <a
                                                        title="Edit Buku"
                                                        href="<?= base_url('book/edit/' . $book->book_id . ''); ?>"
                                                        class="btn btn-sm btn-secondary"
                                                    >
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                    <button
                                                        title="Delete"
                                                        type="button"
                                                        class="btn btn-sm btn-danger"
                                                        data-toggle="modal"
                                                        data-target="#modal-hapus-<?= $book->book_id; ?>"
                                                    ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                                    <div class="text-left">
                                                        <div
                                                            class="modal modal-alert fade"
                                                            id="modal-hapus-<?= $book->book_id; ?>"
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
                                                                        <h5 class="modal-title"><i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi Hapus</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah anda yakin akan menghapus buku <span class="font-weight-bold"><?= $book->book_title; ?></span>?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-danger"
                                                                            onclick="location.href='<?= base_url('book/delete/' . $book->book_id . ''); ?>'"
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
                        </div>
                    <?php else : ?>
                        <p class="text-center">Data tidak tersedia</p>
                    <?php endif; ?>
                    <?= $pagination ?? null; ?>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    doublescroll();
});
</script>
