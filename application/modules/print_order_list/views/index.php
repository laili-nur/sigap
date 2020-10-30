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
                    <header class="page-title-bar text-center">
                        <h1 class="page-title"> Daftar Order Cetak </h1>
                    </header>
                    <div class="page-section">
                        <div class="row">
                            <div class="col-12">
                                <section class="card card-fluid">
                                    <div class="card-body p-0">
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
                                                                style="min-width:200px"
                                                            >Judul</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:100px"
                                                            >Nomor Order</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:100px"
                                                            >Jumlah Cetak</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:100px"
                                                            >Tipe Cetak</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:150px"
                                                            >Tanggal Masuk</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:150px"
                                                            >Deadline</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:150px"
                                                            >Status</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:150px"
                                                            >Lama Cetak</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:100px"
                                                            >Keterangan</th>
                                                            <th
                                                                scope="col"
                                                                class="align-middle text-center"
                                                                style="min-width:150px"
                                                            >Detail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($print_orders as $print_order) : ?>
                                                            <tr>
                                                                <td class="align-middle text-center pl-4"><?= ++$i; ?></td>
                                                                </td>
                                                                <td class="align-middle font-weight-bold">
                                                                    <?= $print_order->title; ?>
                                                                </td>
                                                                <td class="align-middle text-center"><?= $print_order->order_number; ?></td>
                                                                <td class="align-middle text-center"><?= $print_order->total; ?></td>
                                                                <td class="align-middle text-center"><?= $print_order->type; ?></td>
                                                                <td class="align-middle text-center"><?= format_datetime($print_order->entry_date); ?></td>
                                                                <td class="align-middle text-center">
                                                                    <?= deadline_color($print_order->deadline_date, $print_order->print_order_status); ?>
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

                                                                    <?= deadline_detail($print_order->deadline_date, $print_order->print_order_id, $print_order->print_order_status); ?>
                                                                    <!-- Modal -->
                                                                    <div
                                                                        class="modal fade"
                                                                        id="notesModal<?= $print_order->print_order_id; ?>"
                                                                        tabindex="-1"
                                                                        role="dialog"
                                                                        aria-labelledby="notesModal<?= $print_order->print_order_id; ?>"
                                                                        aria-hidden="true"
                                                                    >
                                                                        <div
                                                                            class="modal-dialog"
                                                                            role="document"
                                                                        >
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5
                                                                                        class="modal-title"
                                                                                        id="notesModal<?= $print_order->print_order_id; ?>Label"
                                                                                    >Catatan Tambahan</h5>
                                                                                    <button
                                                                                        type="button"
                                                                                        class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close"
                                                                                    >
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <?= $print_order->additional_notes ? $print_order->additional_notes : 'Tidak ada catatan.'; ?>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button
                                                                                        type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal"
                                                                                    >Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
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
