<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- End Required meta tags -->
    <title>Sistem Informasi UGMPRESS</title>
    <!-- file bawaan template -->
    
    <!-- FAVICONS -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url('assets/apple-touch-icon.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico')?>">
    <meta name="theme-color" content="#3063A0">
    <!-- End FAVICONS -->
    <script src="<?= base_url('assets/vendor/pace/pace.min.js')?>"></script>
    <!-- BEGIN BASE STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/pace/pace.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/open-iconic/css/open-iconic-bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/fontawesome-all.min.css')?>">
    <!-- END BASE STYLES -->
    <!-- BEGIN PLUGINS STYLES -->
    <!-- <link rel="stylesheet" href="<?= base_url('assets/vendor/flatpickr/flatpickr.min.css')?>"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/select2/css/select2.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/toastr/toastr.min.css')?>">
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/stylesheets/main.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/stylesheets/custom.css')?>">
    <!-- END THEME STYLES -->
    <!-- JS -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
</head>
<body>
    <!-- .app -->
    <div class="app">
      <!-- .app-header -->
      <?php $this->load->view('navbar') ?>
      <!-- /.app-header -->
      <!-- .app-aside -->
      <?php $this->load->view('sidebar') ?>
      <!-- /.app-aside -->
      <!-- .app-main -->
      <main class="app-main">
        <!-- .wrapper -->
        <div class="wrapper">
          <!-- .page -->
          <div class="page">
            <!-- .page-inner -->
            <div class="page-inner">
                <!-- Flash message -->
                <?php $this->load->view('_partial/flash_message') ?>
                <!-- tampilan utama -->
                <?php $this->load->view($main_view) ?>
            </div>
            <!-- /.page-inner -->
          </div>
          <!-- /.page -->
        </div>
        <!-- /.wrapper -->
      </main>
      <!-- /.app-main -->
    </div>
    <!-- /.app -->
    <!-- BEGIN BASE JS -->
    <script src="<?= base_url('assets/vendor/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/ugmpress.js'); ?>"></script>
    <!-- END BASE JS -->
    <!-- BEGIN PLUGINS JS -->
    <script src="<?= base_url('assets/vendor/stacked-menu/stacked-menu.min.js');?>"></script>
    <script src="<?= base_url('assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js')?>"></script>
    <!-- <script src="<?= base_url('assets/vendor/flatpickr/flatpickr.min.js')?>"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?= base_url('assets/vendor/handlebars/handlebars.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/typeahead.js/typeahead.bundle.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/select2/js/select2.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/tribute/tribute.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/Caret/jquery.caret.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/At.js/js/jquery.atwho.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/toastr/toastr.min.js')?>"></script>
    <!-- END PLUGINS JS -->
    <!-- BEGIN THEME JS -->
    <script src="<?= base_url('assets/javascript/main.min.js')?>"></script>
    <!-- END THEME JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="<?= base_url('assets/javascript/pages/flatpickr-demo.js')?>"></script>
    <script src="<?= base_url('assets/javascript/pages/typeahead-demo.js')?>"></script>
    <script src="<?= base_url('assets/javascript/pages/select2-demo.js')?>"></script>
    <script src="<?= base_url('assets/javascript/pages/easypiechart-demo.js')?>"></script>
    <script src="<?= base_url('assets/javascript/pages/table-demo.js')?>"></script>
    <!-- END PAGE LEVEL JS -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116692175-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-116692175-1');
    </script> -->
  </body>
</html>