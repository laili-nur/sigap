<?php
$role  = $this->session->userdata('role_id');
?>
<div class="section-block">
    <div class="metric-row">
        <div class="col-12">
            <div class="metric-row metric-flush">
                <div class="col">
                    <div class="metric metric-bordered align-items-center">
                        <h2 class="metric-label"><i class="fa fa-paperclip"></i> Total Draft</h2>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_total']; ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="metric metric-bordered align-items-center">
                        <h2 class="metric-label">
                            <i class="fa fa-check"></i> Draft disetujui
                        </h2>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_approve']; ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="metric metric-bordered align-items-center">
                        <h2 class="metric-label">
                            <i class="fa fa-times"></i> Draft ditolak
                        </h2>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_reject']; ?>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="metric metric-bordered align-items-center">
                        <h2 class="metric-label">
                            <i class="fa fa-book"></i> Total Buku
                        </h2>
                        <p class="metric-value h3">
                            <span class="value">
                                <?= $count['draft_book']; ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <div class="d-flex align-items-center">
                <span class="mr-auto">Progress Draft</span>
            </div>
        </header>
        <div class="metric-row px-4 pt-3">
            <div class="col-12">
                <div class="metric-row metric-flush">
                    <div class="col">
                        <a
                            href="<?= base_url('draft?progress=desk_screening'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-secondary">
                                    <span class="fa fa-compact-disc pulse mr-1"></span> DESK SCREENING
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
                                <span class="badge badge-lg badge-success">
                                    <span class="fa fa-compact-disc pulse mr-1"></span> REVIEW
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
                            href="<?= base_url('draft?progress=edit'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-danger">
                                    <span class="fa fa-compact-disc pulse mr-1"></span> EDITORIAL
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
                            href="<?= base_url('draft?progress=layout'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-warning">
                                    <span class="fa fa-compact-disc pulse mr-1"></span> LAYOUT
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
                            href="<?= base_url('draft?progress=proofread'); ?>"
                            class="metric metric-bordered align-items-center"
                        >
                            <div class="metric-badge">
                                <span class="badge badge-lg badge-info">
                                    <span class="fa fa-compact-disc pulse mr-1"></span> PROOFREAD
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
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-12">
            <section class="card card-fluid">
                <header class="card-header">
                    <div class="d-flex align-items-center">
                        <span class="mr-auto">Kategori Hibah Baru</span>
                    </div>
                </header>
                <?php if ($role == 0) : ?>
                    <div class="alert alert-warning m-3">
                        <strong>Penulis belum didaftarkan</strong><br>
                        Untuk mengusulkan kategori, penulis perlu didaftarkan oleh admin
                    </div>
                <?php else : ?>
                    <?php if ($categories) : ?>
                        <div class="table-responsive table-striped">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            style="min-width: 150px;max-width: 150px"
                                        >Kategori</th>
                                        <th
                                            scope="col"
                                            style="min-width: 250px;max-width: 400px"
                                        >Keterangan</th>
                                        <th
                                            scope="col"
                                            style="min-width: 120px;max-width: 150px"
                                        >Tanggal Buka</th>
                                        <th
                                            scope="col"
                                            style="min-width: 100px;max-width: 100px"
                                        >Sisa Waktu Buka</th>
                                        <th
                                            scope="col"
                                            style="min-width: 120px;max-width: 150px"
                                        >Tanggal Tutup</th>
                                        <th
                                            scope="col"
                                            style="min-width: 100px;max-width: 100px"
                                        >Sisa Waktu Tutup</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $category) : ?>
                                        <tr>
                                            <td class="align-middle">
                                                <?= $category->category_name; ?>
                                            </td>
                                            <td class="align-middle">
                                                <?= $category->category_note; ?>
                                            </td>
                                            <td class="align-middle">
                                                <?= format_datetime($category->date_open, 'dateonly'); ?>
                                            </td>
                                            <td class="align-middle">
                                                <?php
                                                $sisa_waktu_buka = ceil((strtotime($category->date_open) - strtotime(date('Y-m-d H:i:s'))) / 86400);
                                                if ($sisa_waktu_buka >= 1) {
                                                    echo $sisa_waktu_buka . ' hari';
                                                } else {
                                                    echo '<span style="color:green">Sudah dibuka</span>';
                                                }
                                                ?>
                                            </td>

                                            <td class="align-middle">
                                                <?= format_datetime($category->date_close, 'dateonly'); ?>
                                            </td>
                                            <td class="align-middle">

                                                <?php $range_open_now = ceil((strtotime($category->date_open) - strtotime(date('Y-m-d H:i:s'))) / 86400); ?>

                                                <?php
                                                $sisa_waktu = ceil((strtotime($category->date_close) - strtotime(date('Y-m-d H:i:s'))) / 86400);
                                                if ($range_open_now <= 0) {
                                                    if ($sisa_waktu <= 0) {
                                                        echo '<span style="color:red">Berakhir</span>';
                                                    } else {
                                                        echo $sisa_waktu . ' hari';
                                                    }
                                                } else {
                                                    echo '<span style="color:#F7C46C">Belum dibuka</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="align-middle">

                                                <?php if ($category->category_status == 'y' and $range_open_now <= 0) : ?>
                                                    <button
                                                        class="btn btn-success btn-xs"
                                                        onclick="location.href='<?= base_url('draft/add/' . $category->category_id); ?>'"
                                                    >Daftar</button>
                                                <?php else : ?>
                                                    <button
                                                        type="button"
                                                        class="btn btn-success btn-xs disabled"
                                                        disabled=""
                                                        style="cursor:not-allowed"
                                                    >Daftar</button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <p class="text-center my-4">Data tidak tersedia</p>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </div>
    </div> -->
</div>
