<div class="section-block">
    <div class="metric-row">
        <div class="col-12">
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('category'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <h2 class="metric-label"> Total Kategori </h2>
                        <p class="metric-value h3">
                            <sub><i class="fa fa-list-alt"></i></sub>
                            <span class="value"><?= $count['total_category']; ?></span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('draft'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <h2 class="metric-label"> Total Draft Masuk </h2>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-paperclip"></i>
                            </sub>
                            <span class="value">
                                <?= $count['total_draft']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('book'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <h2 class="metric-label"> Total Buku </h2>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-book"></i>
                            </sub>
                            <span class="value">
                                <?= $count['total_book']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('author'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <h2 class="metric-label"> Total Penulis </h2>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-users"></i>
                            </sub>
                            <span class="value">
                                <?= $count['total_author']; ?>
                            </span>
                        </p>
                    </a>
                </div>
            </div>
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('reviewer'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <h2 class="metric-label"> Total Reviewer </h2>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-university"></i>
                            </sub>
                            <span class="value">
                                <?= $count['total_reviewer']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <h2 class="metric-label"> Total Antrian Order Cetak </h2>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-paperclip"></i>
                            </sub>
                            <span class="value">
                                <?= $count['total_print_order']; ?>
                            </span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-block card px-4 pt-3">
    <h4 class="card-title m-0 p-0"> Ringkasan Draft </h4>
    <hr>
    <small class="text-muted">Data dibawah ini merupakan jumlah keseluruhan draft sampai saat ini.</small>
    <div class="metric-row">
        <div class="col-12">
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('draft?progress=desk_screening'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                DESK SCREENING
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_desk']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('draft?progress=review'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                REVIEW
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_review']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('draft?progress=edit'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                EDITORIAL
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_edit']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('draft?progress=layout'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                LAYOUT
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_layout']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('draft?progress=proofread'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                PROOFREAD
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_proofread']; ?>
                            </span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="metric-row">
        <div class="col-12">
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('draft?progress=final'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-success">
                            <i class="fa fa-check"></i> Draft final
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_final']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Draft yang sudah selesai proses"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('draft?reprint=y'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-warning">
                            <i class="fa fa-redo"></i> Draft Cetak Ulang
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_reprint']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Draft final yang di cetak ulang"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('draft?progress=reject'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-danger">
                            <i class="fa fa-times"></i> Draft ditolak
                        </span>
                        <p class="metric-value">
                            <span class="value h3">
                                <?= $count['draft_rejected_total']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Draft yang ditolak pada tahap desk screening dan tahap selanjutnya"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-block card px-4 pt-3">
    <h4 class="card-title m-0 p-0"> Ringkasan Order Cetak </h4>
    <hr>
    <small class="text-muted">Data dibawah ini merupakan jumlah keseluruhan order cetak sampai saat ini.</small>
    <div class="metric-row">
        <div class="col-12">
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('print_order?print_order_status=preprint'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                PRA CETAK
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_preprint']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?print_order_status=print'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                CETAK
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_print']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?print_order_status=postprint'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                JILID
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_postprint']; ?>
                            </span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="metric-row">
        <div class="col-12">
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('print_order?category=new'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-primary">
                            <i class="fa fa-book"></i> BARU
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_new']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Kategori Cetak Baru"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?category=revise'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-dark">
                            <i class="fa fa-book"></i> ULANG REVISI
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_revise']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Kategori Cetak Ulang Revisi"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?category=reprint'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-success">
                            <i class="fa fa-book"></i> ULANG NON REVISI
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_reprint']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Kategori Cetak Ulang Non Revisi"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?category=nonbook'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-danger">
                            <i class="fa fa-book"></i> NON BUKU
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_nonbook']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Kategori Cetak Non Buku"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
            </div>
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('print_order?category=outsideprint'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-warning">
                            <i class="fa fa-book"></i> DI LUAR
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_outsideprint']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Kategori Cetak Di Luar"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?category=from_outside'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <span class="metric-label text-info">
                            <i class="fa fa-book"></i> DARI LUAR
                        </span>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['total_from_outside']; ?>
                            </span>
                            <span
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Kategori Cetak Dari Luar"
                            ><i class="fa fa-info-circle"></i></span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
