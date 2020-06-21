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
            <div class="modal-body">
                <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk mengubah stok buku.</div>
            <form action="<?= base_url('book/add_book_stock');?>" method="post">
                <div class="form-group">
                    <label class="font-weight-bold">Judul Buku</label>
                    <input type="text" class="form-control" value="<?= $input->book_title; ?>" disabled/>
                    <input type="hidden" class="form-control" id="book_id" name="book_id" value="<?= $input->book_id;?>"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_in_warehouse">Stok dalam gudang</label>
                    <input type="number" class="form-control" name="stock_in_warehouse" id="stock_in_warehouse" value="<?= $stock_last->stock_in_warehouse;?>"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_out_warehouse">Stok luar gudang</label>
                    <input type="number" class="form-control" name="stock_out_warehouse" id="stock_out_warehouse" value="<?= $stock_last->stock_out_warehouse;?>"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_pemasaran">Stok pemasaran</label>
                    <input type="number" class="form-control" name="stock_marketing" id="stock_marketing" value="<?= $stock_last->stock_marketing;?>"/>
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