<section class="card">
    <header class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a
                    class="nav-link active show"
                    data-toggle="tab"
                    href="#print-data-wrapper"
                ><i class="fa fa-info-circle"></i> Detail Order Cetak</a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="tab"
                    href="#book-data-wrapper"
                ><i class="fa fa-book"></i> Buku</a>
            </li>
        </ul>
    </header>

    <div class="card-body">
        <div class="tab-content">
            <!-- PRINT ORDER DATA -->
            <div
                id="print-data-wrapper"
                class="tab-pane fade active show"
            >
                <div id="print-data">
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
                                    <td width="200px"> Tipe Cetak </td>
                                    <td><?= $print_order->type; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Jumlah Cetak </td>
                                    <td><?= $print_order->total; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Kategori Cetak (data draft)</td>
                                    <td><?= $print_order->is_reprint == 'y' ? 'Cetak ulang' : 'Cetak baru'; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Edisi Cetak (data buku)</td>
                                    <td><?= $print_order->book_edition  ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Prioritas </td>
                                    <td><?= get_print_order_priority()[$print_order->priority] ?? '' ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tanggal Masuk </td>
                                    <td><?= format_datetime($print_order->entry_date); ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Tanggal Selesai </td>
                                    <td><?= format_datetime($print_order->finish_date); ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Diinput oleh </td>
                                    <td><?= $print_order->input_by; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Status </td>
                                    <td><?= get_print_order_status()[$print_order->print_order_status] ?? $print_order->print_order_status; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- BOOK DATA -->
            <div
                class="tab-pane fade"
                id="book-data-wrapper"
            >
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <tbody>
                            <tr>
                                <td width="200px"> Judul Buku </td>
                                <td><strong><?= $print_order->book_title; ?></strong> </td>
                            </tr>
                            <tr>
                                <td width="200px"> Edisi Cetak Buku</td>
                                <td><?= $print_order->book_edition  ?> </td>
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
                                <td width="200px"> Nomor Hak Cipta </td>
                                <td><strong>
                                        <?= $print_order->nomor_hak_cipta; ?></strong> </td>
                            </tr>
                            <tr>
                                <td width="200px"> File hak cipta </td>
                                <td>
                                    <?= (!empty($print_order->file_hak_cipta)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->file_hak_cipta . '" class="btn btn-success btn-xs m-0" href="' . base_url('hakcipta/' . $print_order->file_hak_cipta) . '"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                                    <?= (!empty($print_order->file_hak_cipta_link)) ? '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->file_hak_cipta_link . '" class="btn btn-success btn-xs m-0" href="' . $print_order->file_hak_cipta_link . '"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                                </td>
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
        </div>
    </div>
</section>
