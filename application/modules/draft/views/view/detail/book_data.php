<div
    class="tab-pane fade"
    id="book-data"
>
    <?php if (isset($book)) : ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0 nowrap">
                <tbody>
                    <tr>
                        <td width="200px"> Judul Buku </td>
                        <td>
                            <a href="<?= base_url("book/view/$book->book_id") ?>"><?= $book->book_title; ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> Nomor Hak Cipta </td>
                        <td><strong>
                                <?= $book->nomor_hak_cipta; ?></strong> </td>
                    </tr>
                    <tr>
                        <td width="200px"> File hak cipta </td>
                        <td>
                            <?= (!empty($book->file_hak_cipta)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $book->file_hak_cipta . '" class="btn btn-success btn-xs m-0" href="' . base_url('hakcipta/' . $book->file_hak_cipta) . '"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                            <?= (!empty($book->file_hak_cipta_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $book->file_hak_cipta_link . '" class="btn btn-success btn-xs m-0" href="' . $book->file_hak_cipta_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> Status Hak Cipta</td>
                        <td>
                            <?= ($book->status_hak_cipta == '') ? '-' : ''; ?>
                            <?= ($book->status_hak_cipta == 1) ? '<span class="badge badge-info">Dalam Proses</span>' : ''; ?>
                            <?= ($book->status_hak_cipta == 2) ? '<span class="badge badge-success">Sudah Jadi</span>' : ''; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div
            class="alert alert-info alert-dismissible fade show mb-0"
            role="alert"
        >
            <h5 class="alert-heading">Draft belum final</h5>
            Data buku akan tampil apabila draft telah disetujui untuk menjadi buku.
        </div>
    <?php endif; ?>
</div>
