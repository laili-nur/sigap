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
                        href="#author-data"
                    ><i class="fa fa-user-tie"></i> Penulis</a>
                </li>
            </ul>
        </header>
        <div class="card-body">
            <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
            <div class="tab-content">
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
            </div>
        </div>
    </section>
</div>
