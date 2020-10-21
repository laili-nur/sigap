<?php
$this->load->helper('ugmpress_helper');
$date_year          = $this->input->get('date_year');

$date_year_options = [
    ''  => '- Filter Tahun Cetak -',
];

for ($dy = intval(date('Y')); $dy >= 2015; $dy--) {
    $date_year_options[$dy] = $dy;
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

                        <div
                            id="table_laporan"
                            name="table_laporan"
                            style="display:none;"
                        >
                            <hr>
                            <div style="text-align: center;">
                                <b>
                                    <p id="month_year">

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
                                <tbody
                                    id="to_fill"
                                    class="align-middle text-center"
                                >

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
var jan_data = <?= json_encode($model[0]['data']) ?>;
var jan_total_order = <?= $model[0]['count_order'] ?>;
var jan_total_old = <?= $model[0]['count_total'] ?>;
var jan_total_new = <?= $model[0]['count_total_new'] ?>;
var feb_data = <?= json_encode($model[1]['data']) ?>;
var feb_total_order = <?= $model[1]['count_order'] ?>;
var feb_total_old = <?= $model[1]['count_total'] ?>;
var feb_total_new = <?= $model[1]['count_total_new'] ?>;
var mar_data = <?= json_encode($model[2]['data']) ?>;
var mar_total_order = <?= $model[2]['count_order'] ?>;
var mar_total_old = <?= $model[2]['count_total'] ?>;
var mar_total_new = <?= $model[2]['count_total_new'] ?>;
var apr_data = <?= json_encode($model[3]['data']) ?>;
var apr_total_order = <?= $model[3]['count_order'] ?>;
var apr_total_old = <?= $model[3]['count_total'] ?>;
var apr_total_new = <?= $model[3]['count_total_new'] ?>;
var may_data = <?= json_encode($model[4]['data']) ?>;
var may_total_order = <?= $model[4]['count_order'] ?>;
var may_total_old = <?= $model[4]['count_total'] ?>;
var may_total_new = <?= $model[4]['count_total_new'] ?>;
var jun_data = <?= json_encode($model[5]['data']) ?>;
var jun_total_order = <?= $model[5]['count_order'] ?>;
var jun_total_old = <?= $model[5]['count_total'] ?>;
var jun_total_new = <?= $model[5]['count_total_new'] ?>;
var jul_data = <?= json_encode($model[6]['data']) ?>;
var jul_total_order = <?= $model[6]['count_order'] ?>;
var jul_total_old = <?= $model[6]['count_total'] ?>;
var jul_total_new = <?= $model[6]['count_total_new'] ?>;
var aug_data = <?= json_encode($model[7]['data']) ?>;
var aug_total_order = <?= $model[7]['count_order'] ?>;
var aug_total_old = <?= $model[7]['count_total'] ?>;
var aug_total_new = <?= $model[7]['count_total_new'] ?>;
var sep_data = <?= json_encode($model[8]['data']) ?>;
var sep_total_order = <?= $model[8]['count_order'] ?>;
var sep_total_old = <?= $model[8]['count_total'] ?>;
var sep_total_new = <?= $model[8]['count_total_new'] ?>;
var oct_data = <?= json_encode($model[9]['data']) ?>;
var oct_total_order = <?= $model[9]['count_order'] ?>;
var oct_total_old = <?= $model[9]['count_total'] ?>;
var oct_total_new = <?= $model[9]['count_total_new'] ?>;
var nov_data = <?= json_encode($model[10]['data']) ?>;
var nov_total_order = <?= $model[10]['count_order'] ?>;
var nov_total_old = <?= $model[10]['count_total'] ?>;
var nov_total_new = <?= $model[10]['count_total_new'] ?>;
var dec_data = <?= json_encode($model[11]['data']) ?>;
var dec_total_order = <?= $model[11]['count_order'] ?>;
var dec_total_old = <?= $model[11]['count_total'] ?>;
var dec_total_new = <?= $model[11]['count_total_new'] ?>;
var base_url = '<?= base_url('print_order/view/'); ?>';
var date_year = '<?= $this->input->get('date_year') ?>';

function get_category(category) {
    if (category == 'new') {
        return "Cetak Baru";
    } else if (category == 'revise') {
        return "Cetak Ulang Revisi";
    } else if (category == 'reprint') {
        return "Cetak Ulang Non Revisi";
    } else if (category == 'nonbook') {
        return "Cetak Non Buku";
    } else if (category == 'outsideprint') {
        return "Cetak Di Luar";
    } else if (category == 'from_outside') {
        return "Cetak Dari Luar";
    } else {
        return null;
    }
}

function populateTable(items, date_month) {
    $('#month_year').html(date_month + ' ' + date_year);
    var i = 1;
    const table = document.getElementById("to_fill");
    items.forEach(item => {
        let row = table.insertRow();
        let no = row.insertCell(0);
        no.innerHTML = i++;
        let title = row.insertCell(1);
        title.innerHTML = item.title;
        let category = row.insertCell(2);
        category.innerHTML = get_category(item.category);
        let total = row.insertCell(3);
        total.innerHTML = item.total;
        let total_new = row.insertCell(4);
        total_new.innerHTML = item.total_new;
        let id = row.insertCell(5);
        id.innerHTML = "<a href='" + base_url + item.id + "'> Link Order Cetak </a>";
    });

}

var ctx = document.getElementById("total_year").getContext('2d');
var total_year = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
            label: 'Jumlah Judul Buku Tercetak',
            data: [
                jan_total_order,
                feb_total_order,
                mar_total_order,
                apr_total_order,
                may_total_order,
                jun_total_order,
                jul_total_order,
                aug_total_order,
                sep_total_order,
                oct_total_order,
                nov_total_order,
                dec_total_order
            ],
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
            data: [
                jan_total_old,
                feb_total_old,
                mar_total_old,
                apr_total_old,
                may_total_old,
                jun_total_old,
                jul_total_old,
                aug_total_old,
                sep_total_old,
                oct_total_old,
                nov_total_old,
                dec_total_old
            ],
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
            data: [
                jan_total_new,
                feb_total_new,
                mar_total_new,
                apr_total_new,
                may_total_new,
                jun_total_new,
                jul_total_new,
                aug_total_new,
                sep_total_new,
                oct_total_new,
                nov_total_new,
                dec_total_new
            ],
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
                $("#to_fill").empty();
                populateTable(jan_data, "January");
            } else if (index == 1) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(feb_data, "February");
            } else if (index == 2) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(mar_data, "March");
            } else if (index == 3) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(apr_data, "April");
            } else if (index == 4) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(may_data, "May");
            } else if (index == 5) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(jun_data, "June");
            } else if (index == 6) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(jul_data, "July");
            } else if (index == 7) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(aug_data, "August");
            } else if (index == 8) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(sep_data, "September");
            } else if (index == 9) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(oct_data, "October");
            } else if (index == 10) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(nov_data, "November");
            } else if (index == 11) {
                $('#table_laporan').toggle();
                $("#to_fill").empty();
                populateTable(dec_data, "December");
            }
        }
    }
});
</script>
