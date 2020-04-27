<div class="section-block">
    <div class="card">
        <div class="card-body">
            <div class="alert alert-warning mb-0">
                <a href="<?= base_url('worksheet?status=waiting'); ?>">
                    <span>
                        MENUNGGU DESK SCREENING
                    </span>
                    <p class="h3">
                        <span class="value">
                            <?= $count['desk_screening']; ?>
                        </span>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="metric-row px-4 pt-3">
            <div class="col-12">
                <div class="metric-row metric-flush">
                    <div class="col">
                        <a
                            href="
                    <?= base_url('draft'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-info">
                                    <span class="oi oi-media-record pulse mr-1"></span> TOTAL DRAFT
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                                    <i class="fa fa-tasks"></i>
                                </sub>
                                <span class="value">
                                    <?= $count['total']; ?>
                                </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="<?= base_url('draft?status=y'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-success">
                                    <span class="oi oi-media-record pulse mr-1"></span> SUDAH DIKERJAKAN
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                                    <i class="fa fa-tasks"></i>
                                </sub>
                                <span class="value">
                                    <?= $count['done']; ?>
                                </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="<?= base_url('draft?status=n'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-danger">
                                    <span class="oi oi-media-record pulse mr-1"></span> BELUM DIKERJAKAN
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                                    <i class="fa fa-tasks"></i>
                                </sub>
                                <span class="value">
                                    <?= $count['wait']; ?>
                                </span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="metric-row px-4">
            <div class="col-12">
                <div class="metric-row metric-flush">
                    <div class="col">
                        <a
                            href="<?= base_url('draft?status=approve'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <h2 class="metric-label">
                                <i class="fa fa-check"></i> Draft Disetujui
                            </h2>
                            <p class="metric-value h3">
                                <span class="value">
                                    <?= $count['approve']; ?>
                                </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="<?= base_url('draft?status=reject'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <h2 class="metric-label">
                                <i class="fa fa-times"></i> Draft Ditolak
                            </h2>
                            <p class="metric-value h3">
                                <span class="value">
                                    <?= $count['reject']; ?>
                                </span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
