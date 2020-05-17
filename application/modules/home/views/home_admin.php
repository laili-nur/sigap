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
                            <span class="badge badge-lg badge-info">
                                DESK SCREENING
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-tasks"></i>
                            </sub>
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
                            <span class="badge badge-lg badge-info">
                                REVIEW
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-tasks"></i>
                            </sub>
                            <span class="value">
                                <?= $count['draft_review']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="
                <?= base_url('draft?progress=edit'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-info">
                                EDITORIAL
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-tasks"></i>
                            </sub>
                            <span class="value">
                                <?= $count['draft_edit']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="
                <?= base_url('draft?progress=layout'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-info">
                                LAYOUT
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-tasks"></i>
                            </sub>
                            <span class="value">
                                <?= $count['draft_layout']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="
                <?= base_url('draft?progress=proofread'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-info">
                                PROOFREAD
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-tasks"></i>
                            </sub>
                            <span class="value">
                                <?= $count['draft_proofread']; ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="
                <?= base_url('draft?progress=print'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-info">
                                CETAK
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <sub>
                                <i class="fa fa-tasks"></i>
                            </sub>
                            <span class="value">
                                <?= $count['draft_print']; ?>
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
                    <div class="metric metric-bordered align-items-center">
                        <a
                            href="<?= base_url('draft?progress=final'); ?>"
                            class="metric-label"
                        >
                            <i class="fa fa-check"></i> Draft final
                        </a>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_final']; ?>
                            </span>
                            <a
                                href="#"
                                onclick="event.preventDefault()"
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Draft yang sudah selesai proses"
                            ><i class="fa fa-info-circle"></i></a>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="metric metric-bordered align-items-center">
                        <a
                            href="<?= base_url('draft?reprint=y'); ?>"
                            class="metric-label"
                        >
                            <i class="fa fa-redo"></i> Draft Cetak Ulang
                        </a>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_reprint']; ?>
                            </span>
                            <a
                                href="#"
                                onclick="event.preventDefault()"
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-html="true"
                                data-placement="left"
                                title="Draft final yang di cetak ulang"
                            ><i class="fa fa-info-circle"></i></a>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="metric metric-bordered align-items-center">
                        <a
                            href="<?= base_url('draft?progress=reject'); ?>"
                            class="metric-label"
                        >
                            <i class="fa fa-times"></i> Draft ditolak
                        </a>
                        <p class="metric-value">
                            <span class="value h3">
                                <?= $count['draft_rejected_total']; ?>
                            </span>
                            <a
                                href="#"
                                onclick="event.preventDefault()"
                                class="font-weight-bold info-home"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Draft yang ditolak pada tahap desk screening dan tahap selanjutnya"
                            ><i class="fa fa-info-circle"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
