<div
    class="tab-pane fade"
    id="data-buku"
>
    <?php if ($books): ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered mb-0 nowrap">
            <tbody>
                <tr>
                    <td width="200px"> Judul Buku </td>
                    <td><strong>
                            <?=$books->book_title;?></strong> </td>
                </tr>
                <tr>
                    <td width="200px"> Nomor Hak Cipta </td>
                    <td><strong>
                            <?=$books->nomor_hak_cipta;?></strong> </td>
                </tr>
                <tr>
                    <td width="200px"> File hak cipta </td>
                    <td>
                        <?=(!empty($books->file_hak_cipta)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $books->file_hak_cipta . '" class="btn btn-success btn-xs m-0" href="' . base_url('hakcipta/' . $books->file_hak_cipta) . '"><i class="fa fa-download"></i> Download</a>' : '';?>
                        <?=(!empty($books->file_hak_cipta_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $books->file_hak_cipta_link . '" class="btn btn-success btn-xs m-0" href="' . $books->file_hak_cipta_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : '';?>
                    </td>
                </tr>
                <tr>
                    <td width="200px"> Status Hak Cipta</td>
                    <td>
                        <?=($books->status_hak_cipta == '') ? '-' : '';?>
                        <?=($books->status_hak_cipta == 1) ? '<span class="badge badge-info">Dalam Proses</span>' : '';?>
                        <?=($books->status_hak_cipta == 2) ? '<span class="badge badge-success">Sudah Jadi</span>' : '';?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div
        class="alert alert-info alert-dismissible fade show"
        role="alert"
    >
        Data akan tampil apabila draft telah disetujui untuk menjadi buku.
    </div>
    <p class="text-center my-4">Draft belum final</p>
    <?php endif;?>
</div>