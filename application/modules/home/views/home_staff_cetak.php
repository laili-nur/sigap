<div class="section-block card px-4 pt-3">
    <h4 class="card-title m-0 p-0"> Ringkasan Order Cetak </h4>
    <hr>
    <small class="text-muted">Data dibawah ini merupakan jumlah keseluruhan order cetak sampai saat ini.</small>
    <div class="metric-row">
        <div class="col-12">
            <div class="metric-row metric-flush">
                <div class="col">
                    <a
                        href="<?= base_url('print_order'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                TOTAL ORDER CETAK
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count["total_print_order"] ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                SEDANG DIKERJAKAN
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count["total_ongoing"] ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?print_order_status=waiting'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                BELUM DIKERJAKAN
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count["total_waiting"] ?>
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
                        href="<?= base_url('print_order?print_order_status=finish'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                SELESAI
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count["total_finish"] ?>
                            </span>
                        </p>
                    </a>
                </div>
                <div class="col">
                    <a
                        href="<?= base_url('print_order?print_order_status=reject'); ?>"
                        class="metric metric-bordered align-items-center"
                    >
                        <div class="metric-badge">
                            <span class="badge badge-lg badge-secondary">
                                DITOLAK
                            </span>
                        </div>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count["total_reject"] ?>
                            </span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
