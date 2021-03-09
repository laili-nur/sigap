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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <script>
    // global variable
    // allow passing to separate .js files
    window.BASE_URL = '<?= base_url('') ?>'
    </script>
</head>

<body>
    <div class="app">
        <?php $this->load->view('navbar'); ?>
        <!-- sidebar consume data 'pages' dari controller -->
        <?php $this->load->view('sidebar'); ?>
        <main
            class="app-main"
            id="app-main"
        >
            <div class="wrapper">
                <div class="page">
                    <div class="page-inner">
                        <!-- flash message -->
                        <?php $this->load->view('_partial/flash_message'); ?>
                        <!-- tampilan utama -->
                        <?php $this->load->view($main_view); ?>
                    </div>
                </div>
            </div>
            <?php $this->load->view('footer'); ?>
        </main>
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
    <!--
   <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
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
