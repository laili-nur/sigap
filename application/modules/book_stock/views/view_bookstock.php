<?php
$level              = check_level();
?>
<header class="page-title-bar mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('book_stock'); ?>">Stok Buku</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">
                    <?= $input->book_title; ?>
                </a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Stok Buku </h1>
        </div>
        <!-- <div>
            <a href="<?//= base_url("$pages/edit/$input->book_id"); ?>" class="btn btn-primary btn-sm"><i
                    class="fa fa-edit fa-fw"></i> Edit Buku</a>
            <a href="<?//= base_url("$pages/edit_hakcipta/$input->book_id"); ?>" class="btn btn-primary btn-sm"><i
                    class="fa fa-edit fa-fw"></i> Edit Hak Cipta</a>
        </div> -->
    </div>
</header>

<div class="page-section">
    <section id="data-draft" class="card">
        <header class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <?php //if ($input->from_outside == 0) : ?>
                <li class="nav-item ">
                    <a class="nav-link active show" data-toggle="tab" href="#stock-data"><i
                            class="fa fa-warehouse pr-1"></i>Detail Stok Buku</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="tab" href="#chart-book"><i
                            class="fa fa-chart-line pr-1"></i>Transaksi Buku</a>
                </li>
                <?php //endif; ?>
            </ul>
        </header>
        <div class="card-body">
            <div class="tab-content">
                <!--stock data-->
                <div class="tab-pane fade active show" id="stock-data">
                    <div id="reload-stock">
                        <?php if ($level == 'superadmin'|| $level == 'admin_gudang' || $level == 'admin_pemasaran') : ?>
                        <?php $i = 1; ?>
                        <div class="row">
                            <div class="col-6 text-left">
                                <strong>Stok Buku</strong>
                            </div>
                            <div class="col-6 text-right">
                                Edit
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mb-0 nowrap">
                                <tbody>
                                    <tr>
                                        <td width="160px">Judul Buku</td>
                                        <td><strong>
                                                <?= $input->book_title; ?>
                                            </strong></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td width="160px">Stok Keseluruhan</td>
                                        <td>554</td>
                                    </tr>
                                    <td width="160px">Stok Gudang</td>
                                    <td>
                                        <?= $input->warehouse_present; ?>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td width="160px">Stok Perpustakaan</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <td width="160px">Stok Showroom</td>
                                        <td>52</td>
                                    </tr>
                                    <tr>
                                        <td width="160px">Perubahan Terakhir</td>
                                        <td class="text-success">+ 102</td>
                                    </tr>
                                    <tr>
                                        <td width="160px">Lokasi Rak (Gudang)</td>
                                        <td>R12B</td>
                                    </tr>
                                    <tr>
                                        <td width="160px">Perubahan Terakhir</td>
                                        <td>19 December 2020 12:00:00</td>
                                    </tr>
                                    <tr>
                                        <td width="160px">Perubahan Terakhir</td>
                                        <td><?php /* if (empty($stock_last) == FALSE) {
                                                        echo date('d F Y H:i:s', strtotime($stock_last->date));
                                                } else {
                                                    echo "-";
                                            } */?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php //if (empty($stock_history) == FALSE) : ?>
                        <hr>
                        <!-- Log Perubahan Stok -->
                        <p class="font-weight-bold">Log Perubahan Stok</p>
                        <div class="table-responsive" style="max-height:500px;">
                            <table class="table table-striped table-bordered mb-0">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">No</th>
                                        <th scope="col">Awal</th>
                                        <th scope="col">Perubahan</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Catatan</th>
                                        <?php if ($level == 'superadmin' || $level == 'admin_gudang') : ?>
                                        <th scope="col"></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php// foreach ($stock_history as $history) : ?>
                                    <tr class="text-center">
                                        <td>
                                            <?= $i++; ?>
                                        </td>
                                        <td>
                                            <?//= $history->warehouse_past; ?>
                                        </td>
                                        <td>
                                            <?php /*
                                                            if ($history->warehouse_operator == "+") {
                                                                echo '<div class="text-success"> ' . $history->warehouse_operator . ' ' . $history->warehouse_modifier . '</div>';
                                                            } elseif ($history->warehouse_operator == "-") {
                                                                echo '<div class="text-danger"> ' . $history->warehouse_operator . ' ' . $history->warehouse_modifier . '</div>';
                                                            } */
                                                            ?>
                                        </td>
                                        <td>
                                            <?//= get_username($history->user_id); ?>
                                        </td>
                                        <td>
                                            <?//= date('d F Y H:i:s', strtotime($history->date)); ?>
                                        </td>
                                        <td>
                                            <?//= $history->notes; ?>
                                        </td>
                                        <?php if ($level == 'superadmin' || $level == 'admin_gudang') : ?>
                                        <td>
                                            <button title="Delete" type="button" class="btn btn-sm btn-danger"
                                                data-toggle="modal"
                                                data-target="#modal_delete_stock<?//= $history->book_stock_id; ?>">
                                                <i class="fa fa-trash-alt"></i>
                                                <span class="sr-only">Delete</span>
                                            </button>
                                            <!-- Modal Hapus -->
                                            <div class="modal modal-alert fade"
                                                id="modal_delete_stock<?//= $history->book_stock_id; ?>" tabindex="-1"
                                                role="dialog"
                                                aria-labelledby="modal_delete_stock<?//= $history->book_stock_id; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="fa fa-exclamation-triangle text-red mr-1"></i>
                                                                Konfirmasi
                                                                Hapus
                                                            </h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah anda yakin akan menghapus data stok buku dari
                                                                buku
                                                                <span class="font-weight-bold">
                                                                    <?//= $input->book_title; ?>
                                                                </span>
                                                                ?<br>Menghapus riwayat akan mengubah jumlah stok di
                                                                gudang.
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="<?//= base_url('book/delete_book_stock/' . $history->book_stock_id); ?>"
                                                                type="button" class="btn btn-danger">
                                                                Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Hapus -->
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php //endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                        <!-- Log perubahan Stok -->
                        <?php //else : ?>
                        <!-- <p>Data hanya dapat dilihat oleh Superadmin, Admin Penerbitan, Admin Percetakan, Admin Gudang,
                        dan Admin Pemasaran</p> -->
                        <?php //endif; ?>
                    </div>
                </div>
                <!--stock data-->

                <!-- book chart data -->
                <div class="tab-pane fade" id="chart-book">
                    <div class="row">
                        <!-- <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div> -->
                        <!-- <div class="col-12">
                                                    <p class="font-weight-bold mb-0">Transaksi Buku</p>
                                                </div> -->
                        <p class="col-12 font-weight-bold">Transaksi Buku per Bulan</p>
                        <canvas id="myChart" class="mb-3 chartjs-render-monitor" width="1420" height="532"
                            style="display: block; height: 355px; width: 947px;"></canvas>
                        <script>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                                    'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ],
                                datasets: [{
                                    label: 'Transaksi Buku per Bulan',
                                    data: [12, 19, 10, 12, 15, 14, 10, 22, 18, 11, 12, 21],
                                    backgroundColor: [
                                        'rgba(74, 138, 216, 0.2)'
                                        // 'rgba(54, 162, 235, 0.2)',
                                        // 'rgba(255, 206, 86, 0.2)',
                                        // 'rgba(75, 192, 192, 0.2)',
                                        // 'rgba(153, 102, 255, 0.2)',
                                        // 'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(74, 138, 216, 1)',
                                        // 'rgba(54, 162, 235, 1)',
                                        // 'rgba(255, 206, 86, 1)',
                                        // 'rgba(75, 192, 192, 1)',
                                        // 'rgba(153, 102, 255, 1)',
                                        // 'rgba(255, 159, 64, 1)'
                                    ],
                                    // borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        </script>
                        <p class="font-weight-bold col-12">Transaksi Buku per Hari</p>
                        <canvas id="myChart2" class="col chartjs-render-monitor" width="1420" height="532"
                            style="display: block; height: 355px; width: 947px;"></canvas>
                        <script>
                        var ctx = document.getElementById('myChart2').getContext('2d');
                        var myChart2 = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['1 Des', '2 Des', '3 Des', '4 Des', '5 Des', '6 Des', '7 Des',
                                    '8 Des', '9 Des', '10 Des', '11 Des'
                                ],
                                datasets: [{
                                    label: 'Transaksi Buku per Hari',
                                    data: [1, 1, 2, 1, 1, 1, 2, 1, 2, 2, 4, 3],
                                    backgroundColor: [
                                        'rgba(74, 138, 216, 0.2)'
                                        // 'rgba(54, 162, 235, 0.2)',
                                        // 'rgba(255, 206, 86, 0.2)',
                                        // 'rgba(75, 192, 192, 0.2)',
                                        // 'rgba(153, 102, 255, 0.2)',
                                        // 'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(74, 138, 216, 1)',
                                        // 'rgba(54, 162, 235, 1)',
                                        // 'rgba(255, 206, 86, 1)',
                                        // 'rgba(75, 192, 192, 1)',
                                        // 'rgba(153, 102, 255, 1)',
                                        // 'rgba(255, 159, 64, 1)'
                                    ],
                                    // borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                        </script>
                    </div>
                </div>
                <!-- book transaction data -->

            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
    $('.dates').flatpickr({
        altInput: true,
        altFormat: 'j F Y H:i:S',
        dateFormat: 'Y-m-d H:i:S',
        enableTime: true
    });

    $("#date_clear").click(function() {
        $('.dates').clear();
    })
})
</script>