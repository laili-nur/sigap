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
            <?php if ($print_order->book_id) : ?>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-toggle="tab"
                        href="#book-data-wrapper"
                    ><i class="fa fa-book"></i> Buku</a>
                </li>
            <?php endif ?>
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
                                    <td width="200px"> <?= $this->lang->line('form_print_order_category') ?> </td>
                                    <td><?= get_print_order_category()[$print_order->category]; ?> </td>
                                </tr>
                                <tr>
                                    <td width="140px">File Surat Tugas</td>
                                    <td>
                                        <?= ($print_order->letter_file) ? '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->letter_file . '" class="btn btn-success btn-xs m-0" href="' . base_url('print_order/download_file/printorderletter/' . $print_order->letter_file) . '" target="_blank"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                                    </td>
                                </tr>
                                <?php if ($print_order->book_id) : ?>
                                    <tr>
                                        <td width="200px"> <?= $this->lang->line('form_book_title') ?> </td>
                                        <td><strong><?= $print_order->book_title; ?></strong> </td>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <td width="200px"> <?= $this->lang->line('form_print_order_name') ?> </td>
                                        <td><strong><?= $print_order->name; ?></strong> </td>
                                    </tr>
                                <?php endif ?>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_notes') ?> </td>
                                    <td><?= $print_order->print_order_notes; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_number') ?> </td>
                                    <td><?= $print_order->order_number; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_code') ?> </td>
                                    <td><?= $print_order->order_code; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_type') ?> </td>
                                    <td><?= $print_order->type; ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_total') ?> </td>
                                    <td><?= $print_order->total; ?> </td>
                                </tr>
                                <?php if ($print_order->book_id) : ?>
                                    <tr>
                                        <td width="200px"> Kategori Cetak (data draft)</td>
                                        <td><?= $print_order->is_reprint == 'y' ? 'Cetak ulang' : 'Cetak baru'; ?> </td>
                                    </tr>
                                    <tr>
                                        <td width="200px"> Edisi Cetak (data buku)</td>
                                        <td><?= $print_order->book_edition  ?> </td>
                                    </tr>
                                <?php endif ?>
                                <tr>
                                    <td width="140px"><?= $this->lang->line('form_print_order_file') ?></td>
                                    <td>
                                        <?= ($print_order->print_order_file) ? '<a data-toggle="tooltip" data-placement="right" title="' . $print_order->print_order_file . '" class="btn btn-success btn-xs m-0" href="' . base_url('print_order/download_file/printorderfile/' . $print_order->print_order_file) . '" target="_blank"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_start_date') ?> </td>
                                    <td><?= format_datetime($print_order->entry_date); ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_finish_date') ?></td>
                                    <td><?= format_datetime($print_order->finish_date); ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> Deadline</td>
                                    <td>
                                        <?php
                                        if (!$print_order->deadline_date) {
                                            echo '-';
                                        } elseif (strtotime($print_order->deadline_date) <= strtotime("+3 day")) {
                                            echo '<div class="text-danger">' . $print_order->deadline_date . '</div>';
                                        } elseif (strtotime($print_order->deadline_date) <= strtotime("+7 day")) {
                                            echo '<div class="text-warning">' . $print_order->deadline_date . '</div>';
                                        } elseif (strtotime($print_order->deadline_date) >= strtotime("+7 day")) {
                                            echo '<div>' . $print_order->deadline_date . '</div>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_input_by') ?> </td>
                                    <td><?= get_username($print_order->user_id); ?> </td>
                                </tr>
                                <tr>
                                    <td width="200px"> <?= $this->lang->line('form_print_order_status') ?> </td>
                                    <td><?= get_print_order_status()[$print_order->print_order_status] ?? $print_order->print_order_status; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>


                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="200px"> Waktu Pengerjaan Order Cetak </td>
                                    <?php if ($print_order->finish_date) : ?>
                                        <td> <?php processing_time(strtotime($print_order->finish_date), strtotime($print_order->entry_date)) ?> </td>
                                    <?php else : ?>
                                        <td>Order Cetak belum selesai.</td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td width="200px"> Waktu Pengerjaan Progress Pracetak </td>
                                    <?php if ($print_order->preprint_end_date) : ?>
                                        <td> <?php processing_time(strtotime($print_order->preprint_end_date), strtotime($print_order->preprint_start_date)) ?> </td>
                                    <?php else : ?>
                                        <td>Progress pracetak belum selesai.</td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td width="200px"> Waktu Pengerjaan Progress Cetak </td>
                                    <?php if ($print_order->print_end_date) : ?>
                                        <td> <?php processing_time(strtotime($print_order->print_end_date), strtotime($print_order->print_start_date)) ?> </td>
                                    <?php else : ?>
                                        <td>Progress cetak belum selesai.</td>
                                    <?php endif; ?>
                                </tr>
                                <?php if ($print_order->category != 'outsideprint') : ?>
                                    <tr>
                                        <td width="200px"> Waktu Pengerjaan Progress Jilid </td>
                                        <?php if ($print_order->postprint_end_date) : ?>
                                            <td> <?php processing_time(strtotime($print_order->postprint_end_date), strtotime($print_order->postprint_start_date)) ?> </td>
                                        <?php else : ?>
                                            <td>Progress jilid belum selesai.</td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>

            <?php if ($print_order->book_id) : ?>
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
            <?php endif ?>
        </div>
    </div>
</section>
