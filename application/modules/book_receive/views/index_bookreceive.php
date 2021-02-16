<?php
$level              = check_level();
$per_page           = $this->input->get('per_page') ?? 10;
$published_year     = $this->input->get('published_year');
$bookshelf_location = $this->input->get('bookshelf_location');
$book_stock_total   = $this->input->get('book_stock_total');
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
                <a class="text-muted">Penerimaan Buku</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Penerimaan Buku </h1>
            <span class="badge badge-info">Total:
                <?//= $total; ?>
            </span>
        </div>
        <a  href="<?= base_url("$pages/add"); ?>"
            class="btn btn-primary btn-sm">
            <i class="fa fa-plus fa-fw"></i> Tambah
        </a>
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
                                <label for="per_page">Data per halaman</label>
                                <?= form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="category">Tahun Terbit</label>
                                <?= form_dropdown('published_year', get_published_date(), $published_year, 'id="published_year" class="form-control custom-select d-block" title="Filter Tahun Terbit"'); ?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="category">Lokasi Rak</label>
                                <?= form_dropdown('bookshelf_location', get_bookshelf_location(), $bookshelf_location, 'id="bookshelf_location" class="form-control custom-select d-block" title="Lokasi Rak"'); ?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label for="category">Jumlah Dicetak</label>
                                <?= form_dropdown('book_stock_total', get_book_stock_total(), $book_stock_total, 'id="book_stock_total" class="form-control custom-select d-block" title="Total Stok Buku"'); ?>
                            </div>
                            <div class="col-12 col-md-6">
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
                    <!-- hard code -->
                    <small class="ml-3">*tabelnya masih hard code</small>
                    <table class="table table-striped mb-0 table-responsive">
                        <thead>
                            <tr>
                            <th
                                    scope="col"
                                    class="pl-4 align-middle text-center"
                                >No</th>
                                <th
                                    scope="col"
                                    style="min-width:400px;"
                                    class="align-middle text-center"
                                >Judul</th>
                                <th
                                    scope="col"
                                    style="min-width:100px;"
                                    class="align-middle text-center"
                                >Nomor Order</th>
                                <th
                                    scope="col"
                                    style="min-width:100px;"
                                    class="align-middle text-center"
                                >Tahun Terbit</th>
                                <th
                                    scope="col"
                                    style="min-width:100px;"
                                    class="align-middle text-center"
                                >ISBN</th>
                                <th
                                    scope="col"
                                    style="min-width:100px;"
                                    class="align-middle text-center"
                                >Tanggal Masuk Gudang</th>
                                <th
                                    scope="col"
                                    style="min-width:100px;"
                                    class="align-middle text-center"
                                >Jumlah Dicetak</th>
                                <th
                                    scope="col"
                                    style="min-width:100px;"
                                    class="align-middle text-center"
                                >Lokasi Rak</th>
                                <th
                                    style="min-width:100px"
                                    class="align-middle text-center"
                                >
                                    &nbsp; </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="align-middle text-center pl-4">1</td>
                                <td class="align-middle text-left">
                                    <a
                                        href="detailbuku.html"
                                        class="font-weight-bold"
                                    >
                                        Sistem Pengendalian Manajemen </a>
                                </td>
                                <td class="align-middle text-center">2019</td>
                                <td class="align-middle text-center">2019-12-182</td>
                                <td class="align-middle text-center">457-324-744-348-2</td>
                                <td class="align-middle text-center">27/11/2020 10:02:43</td>
                                <td class="align-middle text-center">554</td>
                                <td class="align-middle text-center">R12B</td>
                                <td class="align-middle text-center">
                                    <button
                                        title="Edit Stok"
                                        data-toggle="modal"
                                        data-target="#modal_add_stock"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        <i class="fa fa-pencil-alt"></i>
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <!-- Modal add stock -->
                                    <!-- <div
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
                                                    <h5 class="modal-title">Ubah Stok</h5>
                                                    <button
                                                        type="button"
                                                        class="close"
                                                        data-dismiss="modal"
                                                        aria-label="Close"
                                                    >
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-left">
                                                    <div class="alert alert-warning">
                                                        <strong>PERHATIAN!</strong> Fitur ini
                                                        berfungsi untuk mengubah stok buku.
                                                    </div>
                                                    <form
                                                        action="https://sigapdev.com/book/add_book_stock"
                                                        method="post"
                                                    >
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Judul
                                                                Buku</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                value="Sistem Pengendalian Manajemen"
                                                                disabled=""
                                                            >
                                                            <input
                                                                type="hidden"
                                                                class="form-control"
                                                                id="book_id"
                                                                name="book_id"
                                                                value="41"
                                                            >
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                for="type"
                                                                class="d-block font-weight-bold"
                                                            >
                                                                Tipe Operasi <abbr title="Required">*</abbr>
                                                            </label>
                                                            <div
                                                                class="btn-group btn-group-toggle"
                                                                data-toggle="buttons"
                                                            >
                                                                <label class="btn btn-secondary active">
                                                                    <input
                                                                        type="radio"
                                                                        name="warehouse_operator"
                                                                        value="+"
                                                                        checked="checked"
                                                                        class="custom-control-input"
                                                                    >
                                                                    Tambah</label>

                                                                <label class="btn btn-secondary">
                                                                    <input
                                                                        type="radio"
                                                                        name="warehouse_operator"
                                                                        value="-"
                                                                        class="custom-control-input"
                                                                    >
                                                                    Kurang</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="font-weight-bold"
                                                                for="warehouse_modifier"
                                                            >Perubahan<abbr title="Required">*</abbr></label>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                name="warehouse_modifier"
                                                                id="warehouse_modifier"
                                                            >
                                                            <input
                                                                type="hidden"
                                                                name="warehouse_past"
                                                                id="warehouse_past"
                                                                value=""
                                                            >
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="font-weight-bold"
                                                                for="date"
                                                            >Tanggal Input<abbr title="Required">*</abbr></label>
                                                            <input
                                                                type="text"
                                                                name="date"
                                                                id="date"
                                                                value=""
                                                                class="form-control dates"
                                                            >
                                                        </div>
                                                        <div class="form-group">
                                                            <label
                                                                class="font-weight-bold"
                                                                for="notes"
                                                            >Catatan</label>
                                                            <textarea
                                                                rows="6"
                                                                class="form-control summernote-basic"
                                                                id="notes"
                                                                name="notes"
                                                            ></textarea>
                                                        </div>
                                                    </form>
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

                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- Modal Add Stok -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#modal-hapus-11"
                                    ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                    <div class="text-left">
                                        <div
                                            class="modal modal-alert fade"
                                            id="modal-hapus-11"
                                            tabindex="-1"
                                            role="dialog"
                                            aria-labelledby="modal-hapus"
                                            aria-hidden="true"
                                        >
                                            <div
                                                class="modal-dialog modal-dialog-centered"
                                                role="document"
                                            >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fa fa-exclamation-triangle text-red mr-1"></i>
                                                            Konfirmasi
                                                            Hapus
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin akan menghapus
                                                            print_order <span class="font-weight-bold">Toksikologi
                                                                Lingkungan</span>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger"
                                                            onclick="location.href='https://sigapdev.com/print_order/delete/11'"
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
                            <tr>
                                <td class="align-middle text-center pl-4">2</td>
                                <td class="align-middle text-left">
                                    <a
                                        href="#"
                                        class="font-weight-bold"
                                    >
                                        Toksikologi Lingkungan </a>
                                </td>
                                <td class="align-middle text-center">2018</td>
                                <td class="align-middle text-center">2018-11-328</td>
                                <td class="align-middle text-center">978-602-386-124-8</td>
                                <td class="align-middle text-center">27/11/2020 09:05:15</td>
                                <td class="align-middle text-center">503</td>
                                <td class="align-middle text-center">R10A</td>
                                <td class="align-middle text-center">
                                    <a
                                        href="https://sigapdev.com/print_order/edit/11"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        <i class="fa fa-pencil-alt"></i>
                                        <span class="sr-only">Edit</span>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        data-toggle="modal"
                                        data-target="#modal-hapus-11"
                                    ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                    <div class="text-left">
                                        <div
                                            class="modal modal-alert fade"
                                            id="modal-hapus-11"
                                            tabindex="-1"
                                            role="dialog"
                                            aria-labelledby="modal-hapus"
                                            aria-hidden="true"
                                        >
                                            <div
                                                class="modal-dialog modal-dialog-centered"
                                                role="document"
                                            >
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="fa fa-exclamation-triangle text-red mr-1"></i>
                                                            Konfirmasi
                                                            Hapus
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin akan menghapus
                                                            print_order <span class="font-weight-bold">Toksikologi
                                                                Lingkungan</span>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger"
                                                            onclick="location.href='https://sigapdev.com/print_order/delete/11'"
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
                        </tbody>
                    </table>
                    <!-- end of hard code -->
                </div>
            </section>
        </div>
    </div>
</div>
