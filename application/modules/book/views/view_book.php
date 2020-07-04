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
                <a href="<?= base_url('book'); ?>">Buku</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">
                    <?= $input->book_title; ?></a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Buku </h1>
        </div>
        <div>
            <a
                href="<?= base_url("$pages/edit/$input->book_id"); ?>"
                class="btn btn-primary btn-sm"
            ><i class="fa fa-edit fa-fw"></i> Edit Buku</a>
            <a
                href="<?= base_url("$pages/edit_hakcipta/$input->book_id"); ?>"
                class="btn btn-primary btn-sm"
            ><i class="fa fa-edit fa-fw"></i> Edit Hak Cipta</a>
        </div>
    </div>
</header>

<div class="page-section">
    <section
        id="data-draft"
        class="card"
    >
        <header class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link active show"
                        data-toggle="tab"
                        href="#book-data"
                    ><i class="fa fa-info-circle"></i> Detail Buku</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-toggle="tab"
                        href="#stock-data"
                    ><i class="fa fa-poll"></i> Stok Buku</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-toggle="tab"
                        href="#author-data"
                    ><i class="fa fa-user-tie"></i> Penulis</a>
                </li>
            </ul>
        </header>
        <div class="card-body">
            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
            <div class="tab-content">
                <!-- book-data -->
                <div
                    class="tab-pane fade active show"
                    id="book-data"
                >
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Judul Buku </td>
                                    <td><strong><?= $input->book_title; ?></strong> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Kode Buku </td>
                                    <td><?= $input->book_code; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Edisi Buku </td>
                                    <td><?= $input->book_edition; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Halaman Buku </td>
                                    <td><?= $input->book_pages; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> ISBN </td>
                                    <td><?= $input->isbn; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> eISBN </td>
                                    <td><?= $input->eisbn; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Kategori </td>
                                    <td>
                                        <?= isset($input->category_id) ? konversiID('category', 'category_id', $input->category_id)->category_name : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tema </td>
                                    <td>
                                        <?= isset($input->theme_id) ? konversiID('theme', 'theme_id', $input->theme_id)->theme_name : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> File Buku </td>
                                    <td>
                                        <?php
                                        if (!empty($input->book_file)) {
                                            echo '<a data-toggle="tooltip" data-placement="right" title="' . $input->book_file . '" class="btn btn-success btn-xs my-0" href="' . base_url('book/download_file/bookfile/' . $input->book_file) . '"><i class="fa fa-book"></i> File Buku</a>';
                                        }
                                        ?>

                                        <?= (!empty($input->book_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->book_file_link . '" class="btn btn-success btn-xs my-0" target="_blank" href="' . $input->book_file_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> File Cover </td>
                                    <td>
                                        <?= (!empty($input->cover_file)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->cover_file . '" class="btn btn-success btn-xs my-0" href="' . base_url('book/download_file/draftfile/' . urlencode($input->cover_file)) . '"><i class="fa fa-file-image"></i> File Cover</a>' : ''; ?>

                                        <?= (!empty($input->cover_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->cover_file_link . '" class="btn btn-success btn-xs my-0" target="_blank" href="' . $input->cover_file_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Catatan Buku </td>
                                    <td><?= $input->book_notes; ?></td>
                                </tr>
                                <tr>
                                    <td width="200px"> Referensi Draft </td>
                                    <td><a href="<?= base_url('draft/view/' . $input->draft_id); ?>"><?= $input->draft_title; ?></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Nomor Hak Cipta</td>
                                    <td><?= $input->nomor_hak_cipta; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Status Hak Cipta</td>
                                    <td>
                                        <?= ($input->status_hak_cipta == '') ? '-' : ''; ?>
                                        <?= ($input->status_hak_cipta == 1) ? 'Dalam Proses' : ''; ?>
                                        <?= ($input->status_hak_cipta == 2) ? 'Sudah Jadi' : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> File Hak Cipta </td>
                                    <td>
                                        <?= (!empty($input->file_hak_cipta)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->file_hak_cipta . '" class="btn btn-success btn-xs my-0" href="' . base_url('book/download_file/hakcipta/' . urlencode($input->file_hak_cipta)) . '"><i class="fa fa-file-alt"></i> File Hak Cipta</a>' : ''; ?>

                                        <?= (!empty($input->file_hak_cipta_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $input->file_hak_cipta_link . '" class="btn btn-success btn-xs my-0" target="_blank" href="' . $input->file_hak_cipta_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Tanggal Masuk Draft</td>
                                    <td><?= format_datetime($input->entry_date); ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tanggal Selesai Draft</td>
                                    <td><?= format_datetime($input->finish_date); ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tanggal Terbit </td>
                                    <td><?= format_datetime($input->published_date); ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- book-data -->

                <!-- stock-data -->
                <div
                    class="tab-pane fade"
                    id="stock-data"
                >
                    <div id="reload-stock">
                        <?php if($level == 'superadmin' || $level == 'admin_penerbitan' || $level == 'admin_percetakan' || $level == 'admin_gudang' || $level == 'admin_pemasaran'): ?>
                            <?php $i = 1; ?>
                            <div class="row">
                                <div class="col-6 text-left">
                                    <strong>Stok Buku</strong>
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
                                            <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
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
                                                <?php if($level == 'superadmin' || $level == 'admin_gudang'): ?>
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

                <!-- author-data -->
                <div
                    class="tab-pane fade"
                    id="author-data"
                >
                    <div id="reload-author">
                        <?php if ($authors) : ?>
                            <?php $i = 1; ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">NIP</th>
                                            <th scope="col">Unit Kerja</th>
                                            <th scope="col">Institusi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($authors as $author) : ?>
                                            <tr>
                                                <td class="align-middle"><?= $i++; ?></td>
                                                <td class="align-middle"><a href="<?= base_url('author/view/profile/' . $author->author_id); ?>"><?= $author->author_name; ?></a>
                                                </td>
                                                <td class="align-middle"><?= $author->author_nip; ?></td>
                                                <td class="align-middle"><?= $author->work_unit_name; ?></td>
                                                <td class="align-middle"><?= $author->institute_name; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <p>Data penulis tidak tersedia</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- author-data -->
            </div>
        </div>
    </section>
</div>