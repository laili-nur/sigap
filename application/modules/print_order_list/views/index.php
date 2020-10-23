<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >
    <!-- End Required meta tags -->

    <title>SIGAP - Sistem Informasi Gama Press</title>

    <!-- FAVICONS -->
    <link
        rel="apple-touch-icon-precomposed"
        sizes="144x144"
        href="<?= base_url('assets/apple-touch-icon.png'); ?>"
    >
    <link
        rel="shortcut icon"
        href="<?= base_url('assets/favicon.ico'); ?>"
    >
    <meta
        name="theme-color"
        content="#3063A0"
    >
    <!-- End FAVICONS -->

    <!-- GOOGLE FONT -->
    <link
        href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600"
        rel="stylesheet"
    >
    <!-- End GOOGLE FONT -->

    <!-- BEGIN PLUGINS STYLES -->
    <!-- <link
        rel="stylesheet"
        href="<?= base_url('assets/vendor/fontawesome/css/all.css'); ?>"
    > -->
    <link
        rel="stylesheet"
        href="<?= base_url('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css'); ?>"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/vendor/flatpickr/flatpickr.min.css'); ?>"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/vendor/select2/css/select2.min.css'); ?>"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/vendor/toastr/toastr.min.css'); ?>"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/vendor/summernote/summernote-bs4.min.css'); ?>"
    >
    <!-- END PLUGINS STYLES -->

    <!-- BEGIN THEME STYLES -->
    <link
        rel="stylesheet"
        href="<?= base_url('assets/stylesheets/theme.css'); ?>"
        data-skin="default"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/stylesheets/theme-dark.css'); ?>"
        data-skin="dark"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/stylesheets/custom.css'); ?>"
    >
    <!-- Disable unused skin immediately -->

    <script>
    var skin = localStorage.getItem('skin') || 'default';
    var unusedLink = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');

    unusedLink.setAttribute('rel', '');
    unusedLink.setAttribute('disabled', true);
    </script>
    <!-- END THEME STYLES -->

    <!-- BEGIN PLUGINS STYLES -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"> -->
    <!-- END PLUGINS STYLES -->

    <!-- JS -->
    <!-- jquery must load initially, because there is document ready in php scripts -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>

    <script>
    // global variable
    // allow passing to separate .js files
    window.BASE_URL = '<?= base_url('') ?>'
    </script>
</head>

<body>
    <div class="app">
        <div class="wrapper">
            <div class="page">
                <div class="page-inner">
                    <!-- flash message -->
                    <?php $this->load->view('_partial/flash_message'); ?>
                    <!-- tampilan utama -->
                    <?php
                    $level              = check_level();
                    $keyword            = $this->input->get('keyword');
                    $category           = $this->input->get('category');
                    $type               = $this->input->get('type');
                    $print_order_status = $this->input->get('print_order_status');
                    $date_year          = $this->input->get('date_year');
                    $date_month         = $this->input->get('date_month');
                    $i                  = 0;

                    $category_options = [
                        ''  => '- Filter Kategori Cetak -',
                        'new' => 'Cetak Baru',
                        'revise' => 'Cetak Ulang Revisi',
                        'reprint' => 'Cetak Ulang Non Revisi',
                        'nonbook' => 'Cetak Non Buku',
                        'outsideprint' => 'Cetak Di Luar',
                        'from_outside' => 'Cetak Dari Luar'
                    ];

                    $type_options = [
                        ''  => '- Filter Tipe Cetak -',
                        'pod' => 'Cetak POD',
                        'offset' => 'Cetak Offset'
                    ];

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

                    $print_order_status_options = [
                        ''  => '- Filter Status Cetak -',
                        'waiting' => 'Belum diproses',
                        'preprint' => 'Proses Pracetak',
                        'print' => 'Proses Cetak',
                        'postprint' => 'Proses Jilid'
                    ];
                    ?>

                    <header class="page-title-bar">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="page-title"> Daftar Order Cetak </h1>
                            </div>
                            <a
                                class="btn btn-primary"
                                data-toggle="collapse"
                                href="#filter-collapse"
                                role="button"
                                aria-expanded="false"
                                aria-controls="filter-collapse"
                            >
                                Filter
                            </a>
                        </div>
                    </header>
                    <div class="page-section">
                        <div class="row">
                            <div class="col-12">
                                <section class="card card-fluid">
                                    <div class="card-body p-0">
                                        <div
                                            class="collapse"
                                            id="filter-collapse"
                                        >
                                            <div class="p-3">
                                                <?= form_open($pages, ['method' => 'GET']); ?>
                                                <div class="row">
                                                    <div class="col-12 col-md-3 mb-3">
                                                        <label for="category">Kategori Cetak</label>
                                                        <?= form_dropdown('category', $category_options, $category, 'id="category" class="form-control custom-select d-block" title="Filter Kategori Cetak"'); ?>
                                                    </div>
                                                    <div class="col-12 col-md-3 mb-3">
                                                        <label for="type">Tipe Cetak</label>
                                                        <?= form_dropdown('type', $type_options, $type, 'id="type" class="form-control custom-select d-block" title="Filter Tipe Cetak"'); ?>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <label for="date_year">Tahun</label>
                                                        <?= form_dropdown('date_year', $date_year_options, $date_year, 'id="date_year" class="form-control custom-select d-block" title="Filter Tahun Cetak"'); ?>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <label for="date_month">Bulan</label>
                                                        <?= form_dropdown('date_month', $date_month_options, $date_month, 'id="date_month" class="form-control custom-select d-block" title="Filter Bulan Cetak"'); ?>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <label for="print_order_status">Status</label>
                                                        <?= form_dropdown('print_order_status', $print_order_status_options, $print_order_status, 'id="print_order_status" class="form-control custom-select d-block" title="Filter Status Cetak"'); ?>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="status">Pencarian</label>
                                                        <?= form_input('keyword', $keyword, 'placeholder="Cari berdasarkan Judul, Nomor, Kode, Nama Pesanan" class="form-control"'); ?>
                                                    </div>
                                                    <div class="col-12 col-lg-3">
                                                        <label>&nbsp;</label>
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
                                                <?= form_close(); ?>
                                            </div>
                                        </div>
                                        <?php if ($print_orders) : ?>
                                            <div class="table-responsive">
                                                <table class="table table-striped mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                scope="col"
                                                                class="pl-4 align-middle text-center"
                                                            >No</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Judul</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Nomor Order</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Jumlah Cetak</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Tipe Cetak</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Tanggal Masuk</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Deadline</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Status</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Lama Cetak</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Keterangan</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                            >Detail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($print_orders as $print_order) : ?>
                                                            <tr>
                                                                <td class="align-middle text-center pl-4"><?= ++$i; ?></td>
                                                                </td>
                                                                <td class="align-middle font-weight-bold">
                                                                    <?= highlight_keyword($print_order->title, $keyword); ?>
                                                                </td>
                                                                <td class="align-middle text-center"><?= highlight_keyword($print_order->order_number, $keyword); ?></td>
                                                                <td class="align-middle text-center"><?= $print_order->total; ?></td>
                                                                <td class="align-middle text-center"><?= $print_order->type; ?></td>
                                                                <td class="align-middle text-center"><?= $print_order->entry_date; ?></td>
                                                                <td class="align-middle text-center">
                                                                    <?php
                                                                    if (!$print_order->deadline_date) {
                                                                        echo '-';
                                                                    } else {
                                                                        echo $print_order->deadline_date;
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="align-middle text-center"><?= get_print_order_status()[$print_order->print_order_status] ?? $print_order->print_order_status; ?></td>
                                                                <td class="align-middle text-center">
                                                                    <?php
                                                                    if (!$print_order->deadline_date) {
                                                                        echo '-';
                                                                    } else {
                                                                        processing_time(strtotime($print_order->deadline_date), strtotime($print_order->entry_date));
                                                                    }
                                                                    ?>

                                                                </td>
                                                                <td class="align-middle text-center">
                                                                    <?php if (!$print_order->deadline_date) : ?>
                                                                        <span class="badge badge-info">Tidak ada deadline</span>
                                                                    <?php else : ?>
                                                                        <?php if (strtotime("now") >= strtotime($print_order->deadline_date)) : ?>
                                                                            <span class="badge badge-dark">Terlambat</span>
                                                                        <?php elseif (strtotime('+3 day') >= strtotime($print_order->deadline_date)) : ?>
                                                                            <span class="badge badge-danger">Mendekati deadline</span>
                                                                        <?php elseif (strtotime('+7 day') <= strtotime($print_order->deadline_date)) : ?>
                                                                            <span class="badge badge-success">Belum terlambat</span>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="align-middle text-center">
                                                                    <?php if (!$print_order->deadline_date) : ?>
                                                                        -
                                                                    <?php elseif (strtotime('now') >= strtotime($print_order->deadline_date)) : ?>
                                                                        <div class="text-danger">Terlambat, <?php processing_time(strtotime($print_order->deadline_date), strtotime("now")); ?></div>
                                                                    <?php elseif (strtotime('now') <= strtotime($print_order->deadline_date)) : ?>
                                                                        <div>Sisa, <?php processing_time(strtotime($print_order->deadline_date), strtotime("now")); ?></div>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else : ?>
                                            <p class="text-center my-5">Data tidak tersedia</p>
                                        <?php endif; ?>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('footer'); ?>
    </div>
    <!-- BEGIN BASE JS -->
    <script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/ugmpress.js'); ?>"></script>
    <!-- END BASE JS -->

    <!-- BEGIN PLUGINS JS -->
    <script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-validation/additional-methods.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/pace/pace.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/stacked-menu/js/stacked-menu.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/flatpickr/flatpickr.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/handlebars/handlebars.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/easy-pie-chart/jquery.easypiechart.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/DoubleScroll/jquery.doubleScroll.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/select2/js/select2.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/summernote/summernote-bs4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/toastr/toastr.min.js'); ?>"></script>
    <!-- END PLUGINS JS -->

    <!-- BEGIN THEME JS -->
    <script src="<?= base_url('assets/javascript/theme.min.js'); ?>"></script> <!-- END THEME JS -->

    <!-- BEGIN PAGE LEVEL JS -->
    <script src="<?= base_url('assets/javascript/pages/select2-demo.js'); ?>"></script>
    <script src="<?= base_url('assets/javascript/pages/flatpickr-demo.js'); ?>"></script>
    <script src="<?= base_url('assets/javascript/pages/summernote-demo.js'); ?>"></script>

    <!-- END PAGE LEVEL JS -->
</body>

</html>
