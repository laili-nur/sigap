<div class="section-block">
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
                              <?= $count['draft_total']; ?>
                           </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="
                    <?= base_url('worksheet'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-secondary">
                              <span class="oi oi-media-record pulse mr-1"></span> MENUNGGU DESK SCREENING
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
                            href="
                    <?= base_url('draft/filter?filter=sudah'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-success">
                              <span class="oi oi-media-record pulse mr-1"></span> SUDAH DIPROSES
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                                <span class="value">
                              <?= $count['draft_sudah']; ?>
                           </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="
                    <?= base_url('draft/filter?filter=belum'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-danger">
                              <span class="oi oi-media-record pulse mr-1"></span> BELUM DIPROSES
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                                <span class="value">
                              <?= $count['draft_belum']; ?>
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
                            href="
                <?= base_url('draft/filter?filter=approve'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <h2 class="metric-label">
                           <i class="fa fa-check"></i> Layout Disetujui
                        </h2>
                            <p class="metric-value h3">
                                <span class="value">
                              <?= $count['draft_approved']; ?>
                           </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="
                <?= base_url('draft/filter?filter=reject'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <h2 class="metric-label">
                           <i class="fa fa-times"></i> Layout Ditolak
                        </h2>
                            <p class="metric-value h3">
                                <span class="value">
                              <?= $count['draft_rejected']; ?>
                           </span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
