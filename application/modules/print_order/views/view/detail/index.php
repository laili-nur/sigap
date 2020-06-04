<section
    id="data-print"
    class="card"
>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <tbody>
                    <tr>
                        <td width="200px"> Judul Buku </td>
                        <td><strong><?= $print_order->book_title; ?></strong> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Nomor Order </td>
                        <td><?= $print_order->order_number; ?> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Jumlah Copy </td>
                        <td><?= $print_order->copies; ?> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Tipe Cetak </td>
                        <td><?= $print_order->type; ?> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Prioritas </td>
                        <td><?= $print_order->priority; ?> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Tanggal Masuk </td>
                        <td><?= $print_order->entry_date; ?> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Tanggal Selesai </td>
                        <td><?= $print_order->finish_date; ?> </td>
                    </tr>
                    <tr>
                        <td width="200px"> Diinput oleh </td>
                        <td><?= $print_order->input_by; ?> </td>
                    </tr>
                    <tr>
                        <td width="200px"> File Buku </td>
                        <td>
                            <?php
                            if (!empty($print_order->book_file)) {
                                echo '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->book_file . '" class="btn btn-success btn-xs my-0" href="' . base_url('book/download_file/bookfile/' . $print_order->book_file) . '"><i class="fa fa-book"></i> File Buku</a>';
                            }
                            ?>

                            <?= (!empty($print_order->book_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->book_file_link . '" class="btn btn-success btn-xs my-0" target="_blank" href="' . $print_order->book_file_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> File Cover </td>
                        <td>
                            <?= (!empty($print_order->cover_file)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->cover_file . '" class="btn btn-success btn-xs my-0" href="' . base_url('book/download_file/draftfile/' . urlencode($print_order->cover_file)) . '"><i class="fa fa-file-image"></i> File Cover</a>' : ''; ?>

                            <?= (!empty($print_order->cover_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->cover_file_link . '" class="btn btn-success btn-xs my-0" target="_blank" href="' . $print_order->cover_file_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="200px"> Catatan Buku </td>
                        <td><?= $print_order->book_notes; ?></td>
                    </tr>
                    <tr>
                        <td width="200px"> Referensi Buku </td>
                        <td><a href="<?= base_url('book/view/' . $print_order->book_id); ?>"><?= $print_order->book_title; ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
