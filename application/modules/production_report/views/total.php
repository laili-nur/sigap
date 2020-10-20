<?php
$this->load->helper('ugmpress_helper');
$date_year          = $this->input->get('date_year');

$date_year_options = [
    ''  => '- Filter Tahun Cetak -',
];

for ($dy = intval(date('Y')); $dy >= 2015; $dy--) {
    $date_year_options[$dy] = $dy;
}

$jan_order = 0;
foreach ($jan as $key => $value) {
    if (isset($value->total))
        $jan_order += $value->total;
}
$jan_new = 0;
foreach ($jan as $key => $value) {
    if (isset($value->total_new))
        $jan_new += $value->total_new;
}
$feb_order = 0;
foreach ($feb as $key => $value) {
    if (isset($value->total))
        $feb_order += $value->total;
}
$feb_new = 0;
foreach ($feb as $key => $value) {
    if (isset($value->total_new))
        $feb_new += $value->total_new;
}
$mar_order = 0;
foreach ($mar as $key => $value) {
    if (isset($value->total))
        $mar_order += $value->total;
}
$mar_new = 0;
foreach ($mar as $key => $value) {
    if (isset($value->total_new))
        $mar_new += $value->total_new;
}
$apr_order = 0;
foreach ($apr as $key => $value) {
    if (isset($value->total))
        $apr_order += $value->total;
}
$apr_new = 0;
foreach ($apr as $key => $value) {
    if (isset($value->total_new))
        $apr_new += $value->total_new;
}
$may_order = 0;
foreach ($may as $key => $value) {
    if (isset($value->total))
        $may_order += $value->total;
}
$may_new = 0;
foreach ($may as $key => $value) {
    if (isset($value->total_new))
        $may_new += $value->total_new;
}
$jun_order = 0;
foreach ($jun as $key => $value) {
    if (isset($value->total))
        $jun_order += $value->total;
}
$jun_new = 0;
foreach ($jun as $key => $value) {
    if (isset($value->total_new))
        $jun_new += $value->total_new;
}
$jul_order = 0;
foreach ($jul as $key => $value) {
    if (isset($value->total))
        $jul_order += $value->total;
}
$jul_new = 0;
foreach ($jul as $key => $value) {
    if (isset($value->total_new))
        $jul_new += $value->total_new;
}
$aug_order = 0;
foreach ($aug as $key => $value) {
    if (isset($value->total))
        $aug_order += $value->total;
}
$aug_new = 0;
foreach ($aug as $key => $value) {
    if (isset($value->total_new))
        $aug_new += $value->total_new;
}
$sep_order = 0;
foreach ($sep as $key => $value) {
    if (isset($value->total))
        $sep_order += $value->total;
}
$sep_new = 0;
foreach ($sep as $key => $value) {
    if (isset($value->total_new))
        $sep_new += $value->total_new;
}
$oct_order = 0;
foreach ($oct as $key => $value) {
    if (isset($value->total))
        $oct_order += $value->total;
}
$oct_new = 0;
foreach ($oct as $key => $value) {
    if (isset($value->total_new))
        $oct_new += $value->total_new;
}
$nov_order = 0;
foreach ($nov as $key => $value) {
    if (isset($value->total))
        $nov_order += $value->total;
}
$nov_new = 0;
foreach ($nov as $key => $value) {
    if (isset($value->total_new))
        $nov_new += $value->total_new;
}
$dec_order = 0;
foreach ($dec as $key => $value) {
    if (isset($value->total))
        $dec_order += $value->total;
}
$dec_new = 0;
foreach ($dec as $key => $value) {
    if (isset($value->total_new))
        $dec_new += $value->total_new;
}
?>

<link
    rel="stylesheet"
    href="<?= base_url('assets/vendor/chart.js/new/Chart.min.css'); ?>"
>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-url/2.5.3/url.js"></script>
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a
                    href="<?= base_url('production_report'); ?>"
                    class="text-muted"
                >Laporan Produksi</a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Hasil Cetak Produksi</a>
            </li>
        </ol>
    </nav>
</header>

<div class="page-section">
    <div class="row">
        <div class="col-12">
            <section class="card card-fluid">
                <div class="card-body p-0">
                    <header class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    href="<?= base_url('production_report/total'); ?>"
                                >Hasil Cetak Produksi</a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    href="<?= base_url('production_report/detail'); ?>"
                                >Detail Cetak</a>
                            </li>
                        </ul>
                    </header>
                    <div class="p-3">
                        <?= form_open($pages, ['method' => 'GET']); ?>
                        <div class="row">
                            <div class="col-md"></div>
                            <div class="col-md">
                                <div class="float-right">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <?= form_dropdown('date_year', $date_year_options, $date_year, 'id="date_year" class="form-control custom-select d-block" title="Filter Tahun Cetak"'); ?>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div
                                                class="btn-group btn-block"
                                                role="group"
                                                aria-label="Filter button"
                                            >
                                                <button
                                                    class="btn btn-secondary"
                                                    type="button"
                                                    onclick="location.href = '<?= base_url($pages); ?>'"
                                                > Reset</button>
                                                <button
                                                    class="btn btn-primary"
                                                    type="submit"
                                                    value="Submit"
                                                ><i class="fa fa-filter"></i> Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div
                                class="col-md-12"
                                style="text-align: center;"
                            >
                                <b>
                                    <h5>LAPORAN JUDUL BUKU YANG BERHASIL DI CETAK</h5>
                                </b>
                                <b>
                                    <p><?= $this->input->get('date_year'); ?></p>
                                </b>
                            </div>
                            <div class="col-md-12">
                                <canvas id="total_year"></canvas>
                            </div>
                            <div
                                class="col-md-12"
                                style="text-align: center;"
                            >
                                <b>
                                    <h5>HASIL CETAK PRODUKSI BUKU</h5>
                                </b>
                            </div>
                            <div class="col-md-12">
                                <canvas id="total_production"></canvas>
                            </div>
                        </div>

                        <pre>
                            <?php //print_r($data); 
                            ?>
                        </pre>

                        <div
                            id="table_laporan"
                            name="table_laporan"
                            style="display:none;"
                        >
                            <hr>
                            <div style="text-align: center;">
                                <b>
                                    <p>
                                        <?php
                                        if ($this->input->get('date_month')) {
                                            echo date('F', mktime(0, 0, 0, $this->input->get('date_month')));
                                        } else {
                                            echo '';
                                        }
                                        echo ' ' . $this->input->get('date_year');
                                        ?>
                                    </p>
                                </b>
                            </div>
                            <div style="text-align: left;">
                                <b>
                                    <p>LAPORAN JUDUL BUKU YANG BERHASIL DI CETAK</p>
                                </b>
                            </div>
                            <table class="table table-striped mb-0 table-responsive">
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            class="pl-4 align-middle text-center"
                                        >No</th>
                                        <th
                                            scope="col"
                                            class="align-middle text-center"
                                        >Judul Buku</th>
                                        <th
                                            scope="col"
                                            class="align-middle text-center"
                                        >Kategori Cetak</th>
                                        <th
                                            scope="col"
                                            class="align-middle text-center"
                                        >Jumlah Pesanan</th>
                                        <th
                                            scope="col"
                                            class="align-middle text-center"
                                        >Jumlah Hasil Cetak</th>
                                        <th class="align-middle text-center">Ref</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/vendor/chart.js/new/Chart.bundle.min.js'); ?>"></script>

<script>
var ctx = document.getElementById("total_year").getContext('2d');
var total_year = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
            label: 'Jumlah Judul Buku Tercetak',
            data: [<?= $jan_total; ?>, <?= $feb_total; ?>, <?= $mar_total; ?>, <?= $apr_total; ?>, <?= $may_total; ?>, <?= $jun_total; ?>, <?= $jul_total; ?>, <?= $aug_total; ?>, <?= $sep_total; ?>, <?= $oct_total; ?>, <?= $nov_total; ?>, <?= $dec_total; ?>],
            backgroundColor: [
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)',
                'rgba(255, 153, 0, 0.8)'
            ],
            borderColor: [
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)',
                'rgba(255, 153, 0, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        },
        legend: {
            position: 'bottom'
        }
    }
});

var ctx = document.getElementById("total_production").getContext('2d');
var total_production = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
            label: 'Jumlah Eks Pesanan',
            backgroundColor: [
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)',
                'rgba(51, 51, 204, 0.8)'
            ],
            borderColor: [
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)',
                'rgba(51, 51, 204, 0.2)'
            ],
            borderWidth: 1,
            data: [<?= $jan_order; ?>, <?= $feb_order; ?>, <?= $mar_order; ?>, <?= $apr_order; ?>, <?= $may_order; ?>, <?= $jun_order; ?>, <?= $jul_order; ?>, <?= $aug_order; ?>, <?= $sep_order; ?>, <?= $oct_order; ?>, <?= $nov_order; ?>, <?= $dec_order; ?>],
        }, {
            label: 'Jumlah Eks Hasil Cetak',
            backgroundColor: [
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)'
            ],
            borderColor: [
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)'
            ],
            borderWidth: 1,
            data: [<?= $jan_new; ?>, <?= $feb_new; ?>, <?= $mar_new; ?>, <?= $apr_new; ?>, <?= $may_new; ?>, <?= $jun_new; ?>, <?= $jul_new; ?>, <?= $aug_new; ?>, <?= $sep_new; ?>, <?= $oct_new; ?>, <?= $nov_new; ?>, <?= $dec_new; ?>],
        }]

    },
    options: {
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        },
        legend: {
            position: 'bottom'
        },
        onClick: function(e) {
            var bar = this.getElementAtEvent(e)[0];
            var index = bar._index;
            var datasetIndex = bar._datasetIndex;


            if (index == 0) {
                $('#table_laporan').toggle();
                // $.ajax({
                //     url: '<?= base_url('get_data_by_month/' . $this->input->get('date_year') . '/1'); ?>',
                //     dataType: 'json',
                //     success: function(data) {
                //         var $tr = $('<tr>').addClass('header');
                //         var base_url = "<?= base_url('print_order/view/'); ?>";
                //         $.each(data.headers, function(i, header) {
                //             $tr.append($('<th>').append($('a').addClass('sort').attr('href', '#').append($('span').text(header))));
                //         });
                //         $tr.appendTo('table.data');
                //         $.each(data.rows, function(i, row) {
                //             $('<tr>').attr('id', i).
                //             append($('<td>').text(row.category)).
                //             append($('<td>').text(row.total)).
                //             append($('<td>').text(row.total_new)).
                //             append($('<td>').text("<a href='" + base_url + row.print_order_id + "'> Link Order Cetak </a>")).appendTo('table.data');
                //         });
                //     }
                // });
            } else if (index == 1) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 2) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 3) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 4) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 5) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 6) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 7) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 8) {
                $('#table_laporan').toggle();
                // $.ajax({
                //     url: '<?= base_url('get_data_by_month/2020/9'); ?>',
                //     dataType: 'json',
                //     success: function(data) {
                //         var $tr = $('<tr>').addClass('header');
                //         var base_url = "<?= base_url('print_order/view/'); ?>";
                //         $.each(data.headers, function(i, header) {
                //             $tr.append($('<th>').append($('a').addClass('sort').attr('href', '#').append($('span').text(header))));
                //         });
                //         $tr.appendTo('table.data');
                //         $.each(data.rows, function(i, row) {
                //             $('<tr>').attr('id', i).
                //             append($('<td>').text(row.category)).
                //             append($('<td>').text(row.total)).
                //             append($('<td>').text(row.total_new)).
                //             append($('<td>').text("<a href='" + base_url + row.print_order_id + "'> Link Order Cetak </a>")).appendTo('table.data');
                //         });
                //     }
                // });
            } else if (index == 9) {
                $('#table_laporan').toggle();
                // $.ajax({
                //     url: '<?= base_url('get_data_by_month/2020/10'); ?>',
                //     dataType: 'json',
                //     success: function(data) {
                //         var $tr = $('<tr>').addClass('header');
                //         var base_url = "<?= base_url('print_order/view/'); ?>";
                //         $.each(data.headers, function(i, header) {
                //             $tr.append($('<th>').append($('a').addClass('sort').attr('href', '#').append($('span').text(header))));
                //         });
                //         $tr.appendTo('table.data');
                //         $.each(data.rows, function(i, row) {
                //             $('<tr>').attr('id', i).
                //             append($('<td>').text(row.category)).
                //             append($('<td>').text(row.total)).
                //             append($('<td>').text(row.total_new)).
                //             append($('<td>').text("<a href='" + base_url + row.print_order_id + "'> Link Order Cetak </a>")).appendTo('table.data');
                //         });
                //     }
                // });
            } else if (index == 10) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            } else if (index == 11) {
                // TAMBAH KODE UNTUK KASIH DATA DI TABEL
                $('#table_laporan').toggle();
            }
        }
    }
});
</script>
