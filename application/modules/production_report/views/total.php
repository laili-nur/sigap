<?php
$date_year          = $this->input->get('date_year');
$date_month         = $this->input->get('date_month');

$date_year_options = [
    ''  => '- Filter Tahun Cetak -',
];

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
    href="<?= base_url('assets/vendor/chart.js/Chart.min.css'); ?>"
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
                                        <div class="col-12 col-md-4">
                                            <?= form_dropdown('date_year', $date_year_options, $date_year, 'id="date_year" class="form-control custom-select d-block" title="Filter Tahun Cetak"'); ?>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <?= form_dropdown('date_month', $date_month_options, $date_month, 'id="date_month" class="form-control custom-select d-block" title="Filter Bulan Cetak"'); ?>
                                        </div>
                                        <div class="col-12 col-lg-4">
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
                        <div style="text-align: center;">
                            <b>
                                <h5>LAPORAN JUDUL BUKU YANG BERHASIL DI CETAK</h5>
                            </b>
                        </div>
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                        <div style="text-align: center;">
                            <b>
                                <h5>HASIL CETAK PRODUKSI BUKU</h5>
                            </b>
                        </div>
                        <div>
                            <canvas id="myChart2"></canvas>
                        </div>
                        <div
                            class="laporan"
                            style="text-align: left;"
                        >
                            <b>
                                <p>LAPORAN JUDUL BUKU YANG BERHASIL DI CETAK</p>
                            </b>
                        </div>
                        <div class="laporan">
                            <table
                                class="table table-striped mb-0 table-responsive"
                                style="width:100%;"
                            >
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            class="pl-4 align-middle text-center"
                                        >No</th>
                                        <th
                                            scope="col"
                                            style="min-width:70px;"
                                            class="align-middle text-center"
                                        >Judul Buku</th>
                                        <th
                                            scope="col"
                                            style="min-width:70px;"
                                            class="align-middle text-center"
                                        >Kategori Cetak</th>
                                        <th
                                            scope="col"
                                            style="min-width:70px;"
                                            class="align-middle text-center"
                                        >Jumlah Pesanan</th>
                                        <th
                                            scope="col"
                                            style="min-width:70px;"
                                            class="align-middle text-center"
                                        >Jumlah Hasil Cetak</th>
                                        <th
                                            style="min-width:150px;"
                                            class="align-middle text-center"
                                        > &nbsp; </th>
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
<script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>

<script>
$(".laporan").hide();

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
console.log(urlParams.get('date_month'));
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
            label: 'Jumlah Judul Buku Tercetak',
            data: [12, 19, 3, 23, 2, 3, 12, 19, 3, 23, 2, 3],
            backgroundColor: [
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
            borderColor: [
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)',
                'rgba(255, 153, 0,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        layout: {
            padding: {
                left: 50,
                right: 50,
                top: 0,
                bottom: 50
            }
        }
    }
});

var chart2 = document.getElementById("myChart2");
var ctx = chart2.getContext('2d');
var myChart2 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
            label: 'Jumlah Eks Pesanan',
            backgroundColor: [
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
            borderColor: [
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)',
                'rgba(51, 51, 204, 1)'
            ],
            borderWidth: 1,
            data: [12, 19, 3, 23, 2, 3, 12, 19, 3, 23, 2, 3],
        }, {
            label: 'Jumlah Eks Hasil Cetak',
            backgroundColor: [
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
            borderColor: [
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)',
                'rgba(0, 102, 0,1)'
            ],
            borderWidth: 1,
            data: [12, 19, 3, 23, 2, 3, 12, 19, 3, 23, 2, 3],
        }]

    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        layout: {
            padding: {
                left: 50,
                right: 50,
                top: 0,
                bottom: 50
            }
        }
    }
});

chart2.onclick = function(evt) {
    // console.log("preparasi");
    $.ajax({
        type: "POST",
        url: "http://localhost/sigap/production_report/coba",
        data: {
            year: urlParams.get('year'),
            month: urlParams.get('date_month')
        },
        success: function(result) {
            // console.log(JSON.parse(result));
            var detail_data = JSON.parse(result);
            var detail_table = "";
            for (i in detail_data) {
                // console.log(detail_data[i].total);
                var detail_row = "<tr>";
                var no = Number(i) + 1
                detail_row += "<td class='align-middle text-center pl-4'>" + no + "</td>";
                detail_row += "<td class='align-middle text-center4'>" + detail_data[i].book_title + "</td>";
                detail_row += "<td class='align-middle text-center4'> kategori </td>";
                detail_row += "<td class='align-middle text-center4'>" + detail_data[i].total + "</td>";
                detail_row += "<td class='align-middle text-center4'>" + detail_data[i].total_postprint + "</td>";
                detail_row += "<td class='align-middle text-center4'> saih </td> </tr>";
                detail_table += detail_row;
            }
            $("tbody").hide();
            $("tbody").html(detail_table);
            $(".laporan").fadeIn("slow");
            $("tbody").fadeIn("slow");
        }
    });
}
</script>
<script>
$(document).ready(function() {
    $("#coba_ajax").click(function() {
        $.ajax({
            url: "http://localhost/sigap/production_report/coba",
            success: function(result) {
                console.log(result);
            }
        });
    });
});
</script>
