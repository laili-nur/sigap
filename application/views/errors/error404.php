<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- End Required meta tags -->
    <title>ERROR - PAGE NOT FOUND</title>
    <!-- file bawaan template -->
    
    <!-- FAVICONS -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url('assets/apple-touch-icon.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico')?>">
    <meta name="theme-color" content="#3063A0">
    <!-- End FAVICONS -->
    <!-- BEGIN BASE STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/pace/pace.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/open-iconic/css/open-iconic-bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/fontawesome-all.min.css')?>">
    <!-- END BASE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/stylesheets/main.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/stylesheets/custom.css')?>">
    <!-- END THEME STYLES -->
</head>
<body>
  <!-- .empty-state -->
  <section class="empty-state">
    <!-- .empty-state-container -->
    <div class="empty-state-container">
      <div class="state-figure">
        <img class="img-fluid" src="assets/images/illustration/img-2.png" alt="" style="max-width: 320px"> </div>
      <h3 class="state-header"> Page Not found! </h3>
      <p class="state-description lead text-muted"> URL point to something that doesn't exist. </p>
      <div class="state-action">
        <a href="<?=base_url() ?>" class="btn btn-lg btn-light">
          <i class="fa fa-angle-right"></i> Go Back</a>
      </div>
    </div>
    <!-- /.empty-state-container -->
  </section>
  <!-- /.empty-state -->

</body>
</html>