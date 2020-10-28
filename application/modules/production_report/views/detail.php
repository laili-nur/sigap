<?php
$date_year          = $this->input->get('date_year');
$date_month         = $this->input->get('date_month');

$date_year_options = [];

for ($dy = intval(date('Y')); $dy >= 2015; $dy--) {
    $date_year_options[$dy] = $dy;
}

$date_month_options = [
    ''  => '- Filter Bulan Cetak -',
];

for ($m = 1; $m <= 12; $m++) {
    $date_month_options[$m] = date('F', mktime(0, 0, 0, $m, 1));
}
?>

<link
    rel="stylesheet"
    href="<?= base_url('assets/vendor/chart.js/new/Chart.min.css'); ?>"
>
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
                <a class="text-muted">Detail Cetak</a>
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
                                    class="nav-link"
                                    href="<?= base_url('production_report/total?date_year=' . date('Y')); ?>"
                                >Hasil Cetak Produksi</a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    href="<?= base_url('production_report/detail?date_year=' . date('Y')); ?>"
                                >Detail Cetak</a>
                            </li>
                        </ul>
                    </header>
                    <div class="p-3">
                        <?= form_open($pages, ['method' => 'GET']); ?>
                        <div class="row">
                            <div class="col-md"></div>
                            <div class="col-md">
                                <div class="row">
                                    <div class="col-4">
                                        <?= form_dropdown('date_year', $date_year_options, $date_year, 'id="date_year" class="form-control custom-select d-block" title="Filter Tahun Cetak"'); ?>
                                    </div>
                                    <div class="col-4">
                                        <?= form_dropdown('date_month', $date_month_options, $date_month, 'id="date_month" class="form-control custom-select d-block" title="Filter Bulan Cetak"'); ?>
                                    </div>
                                    <div class="col-4">
                                        <div
                                            class="btn-group btn-block"
                                            role="group"
                                            aria-label="Filter button"
                                        >
                                            <button
                                                class="btn btn-secondary"
                                                type="button"
                                                onclick="location.href = '<?= base_url('production_report/detail?date_year=' . date('Y')); ?>'"
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
                        <?= form_close(); ?>
                    </div>
                    <div class="container">
                        <div style="text-align: center;">
                            <b>
                                <h5>DETAIL JUDUL TERCETAK</h5>
                            </b>
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
                        <div class="row">
                            <div class="col-md-6">
                                <canvas id="chart_category"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="chart_type"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="chart_laminate"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="chart_binding"></canvas>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <b>
                                <p>TOTAL JUMLAH JUDUL TERCETAK = <?= $model[0]['total'] ?></p>
                            </b>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/vendor/chart.js/new/Chart.bundle.min.js'); ?>"></script>

<script>
var new_ = "<?= $model[0]['new'] ?>";
var revise = "<?= $model[0]['revise'] ?>";
var reprint = "<?= $model[0]['reprint'] ?>";
var nonbook = "<?= $model[0]['nonbook'] ?>";
var outsideprint = "<?= $model[0]['outsideprint'] ?>";
var from_outside = "<?= $model[0]['from_outside'] ?>";
var pod = "<?= $model[0]['pod'] ?>";
var offset = "<?= $model[0]['offset'] ?>";
var laminate_inside = "<?= $model[0]['laminate_inside'] ?>";
var laminate_outside = "<?= $model[0]['laminate_outside'] ?>";
var laminate_partial = "<?= $model[0]['laminate_partial'] ?>";
var binding_inside = "<?= $model[0]['binding_inside'] ?>";
var binding_outside = "<?= $model[0]['binding_outside'] ?>";
var binding_partial = "<?= $model[0]['binding_partial'] ?>";

var ctx = document.getElementById("chart_category").getContext('2d');
var chart_category = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Cetak Baru", "Cetak Ulang Revisi", "Cetak Ulang Non Revisi", "Cetak Non Buku", "Cetak Di Luar", "Cetak Dari Luar"],
        datasets: [{
            data: [new_, revise, reprint, nonbook, outsideprint, from_outside],
            backgroundColor: [
                'rgba(0, 0, 150, 0.8)',
                'rgba(102, 51, 0, 0.8)',
                'rgba(0, 102, 0, 0.8)',
                'rgba(255, 102, 0, 0.8)',
                'rgba(255, 0, 102, 0.8)',
                'rgba(255, 255, 0, 0.8)'
            ],
            borderColor: [
                'rgba(0, 0, 150, 0.2)',
                'rgba(102, 51, 0, 0.2)',
                'rgba(0, 102, 0, 0.2)',
                'rgba(255, 102, 0, 0.2)',
                'rgba(255, 0, 102, 0.2)',
                'rgba(255, 255, 0, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
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
        title: {
            display: true,
            text: 'Kategori Cetak'
        }
    }
});

var ctx = document.getElementById("chart_type").getContext('2d');
var chart_type = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["POD", "Offset"],
        datasets: [{
            data: [pod, offset],
            backgroundColor: [
                'rgba(0, 153, 51, 0.8)',
                'rgba(255, 153, 0, 0.8)'
            ],
            borderColor: [
                'rgba(0, 153, 51, 0.2)',
                'rgba(255, 153, 0, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
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
        title: {
            display: true,
            text: 'Tipe Cetak'
        }
    }
});

var ctx = document.getElementById("chart_laminate").getContext('2d');
var chart_laminate = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Laminasi di Dalam", "Laminasi di Luar", "Parsial"],
        datasets: [{
            data: [laminate_inside, laminate_outside, laminate_partial],
            backgroundColor: [
                'rgba(51, 204, 255, 0.8)',
                'rgba(153, 153, 102, 0.8)',
                'rgba(255, 51, 153, 0.8)'
            ],
            borderColor: [
                'rgba(51, 204, 255, 0.2)',
                'rgba(153, 153, 102, 0.2)',
                'rgba(255, 51, 153, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
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
        title: {
            display: true,
            text: 'Tipe Laminasi'
        }
    }
});

var ctx = document.getElementById("chart_binding").getContext('2d');
var chart_binding = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Jilid di Dalam", "Jilid di Luar", "Parsial"],
        datasets: [{
            data: [binding_inside, binding_outside, binding_partial],
            backgroundColor: [
                'rgba(51, 204, 255, 0.8)',
                'rgba(153, 153, 102, 0.8)',
                'rgba(255, 51, 153, 0.8)'
            ],
            borderColor: [
                'rgba(51, 204, 255, 0.2)',
                'rgba(153, 153, 102, 0.2)',
                'rgba(255, 51, 153, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
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
        title: {
            display: true,
            text: 'Tipe Jilid'
        }
    }
});
</script>
