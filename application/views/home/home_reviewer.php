<div class="section-block">
    <div class="card">
        <div class="metric-row px-4 pt-3">
            <div class="col-12">
                <div class="metric-row metric-flush">
                    <div class="col">
                        <a
                            href="<?= base_url('draft'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-info">
                              <span class="oi oi-media-record pulse mr-1"></span> TOTAL REVIEW
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                                <span class="value">
                              <?= $count['count_total']; ?>
                           </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="<?= base_url('draft?review=done'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-success">
                              <span class="oi oi-media-record pulse mr-1"></span> SUDAH DIREVIEW
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                                <span class="value">
                              <?= $count['count_sudah']; ?>
                           </span>
                            </p>
                        </a>
                    </div>
                    <div class="col">
                        <a
                            href="
                    <?= base_url('draft?review=process'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-danger">
                              <span class="oi oi-media-record pulse mr-1"></span> BELUM DIREVIEW
                                </span>
                            </div>
                            <p class="metric-value h3">
                                <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                                <span class="value">
                              <?= $count['count_belum']; ?>
                           </span>
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-12">
            <section class="card card-fluid">
                <header class="card-header">
                    <div class="d-flex align-items-center">
                        <span class="mr-auto">Draft Terbaru Untuk Direview</span>
                    </div>
                </header>
                <?php if ($drafts_newest) : ?>
                    <div class="table-responsive table-striped">
                        <table class="table nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Tanggal masuk</th>
                                    <th scope="col">Deadline Review</th>
                                    <th scope="col">Sisa Waktu</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($drafts_newest as $draft) : ?>
                                    <?php if ($draft->flag == '') : ?>
                                        <tr>
                                            <td class="align-middle">
                                                <?= $draft->draft_title; ?>
                                            </td>
                                            <td class="align-middle">
                                                <?= $draft->entry_date; ?>
                                            </td>
                                            <td class="align-middle">
                                                <?= $draft->deadline; ?>
                                            </td>
                                            <td class="align-middle">
                                                <?php
                                                $sisa_waktu = round((strtotime($draft->deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
                                                if ($sisa_waktu <= 0) {
                                                    echo '<span class="font-weight-bold" style="color:red">Melebihi Deadline!</span>';
                                                } else {
                                                    echo $sisa_waktu . ' hari';
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle">
                                                <a
                                                    href="<?= base_url('draft/view/' . $draft->draft_id . ''); ?>"
                                                    class="btn btn-sm btn-secondary"
                                                >
                                                    <i class="fa fa-eye"></i> View

                                                    <span class="sr-only">View</span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-center my-4">Data tidak tersedia</p>
                <?php endif; ?>
                <footer class="card-footer">
                    <a
                        href="
                <?= base_url('draft'); ?>"
                        class="card-footer-item"
                    >Lihat selengkapnya

                        <i class="fa fa-fw fa-angle-right"></i>
                    </a>
                </footer>
            </section>
        </div>
    </div> -->
</div>
