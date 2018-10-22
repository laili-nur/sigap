<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- End Required meta tags -->
    <!-- Begin SEO tag -->
    <title> SIGAP LOGIN</title>
    <meta property="og:title" content="Sign In">
    <meta name="author" content="bagaskara">
    <meta property="og:locale" content="en_US">
    <meta name="description" content="Sistem Informasi Penerbitan UGM PRESS">
    <meta property="og:description" content="Sistem Informasi Penerbitan UGM PRESS">
    <link rel="canonical" href="">
    <meta property="og:url" content="//uselooper.com">
    <meta property="og:site_name" content="SIIP UGMPRESS">
    <!-- Favicons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/apple-touch-icon.png">
    <link rel="shortcut icon" href="assets/favicon.ico">
    <meta name="theme-color" content="#3063A0">
    <!-- BEGIN BASE STYLES -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/fontawesome-all.min.css">
    <!-- END BASE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="assets/stylesheets/main.min.css">
    <link rel="stylesheet" href="assets/stylesheets/custom.css">
    <!-- END THEME STYLES -->
  </head>
  <body>
    <!-- .auth -->
    <main class="auth">
      <header id="auth-header" class="auth-header">
        <h1>
          SIGAP
          <span class="sr-only">Sign In</span>
        </h1>
        <p> Tidak punya akun?
          <a href="#">Hubungi Admin</a>
        </p>
      </header>
      <!-- form -->
      <?= form_open('login', 'class="auth-form"'); ?>
            <?php if (!empty($this->session->flashdata('error'))) : ?>
        <p class="alert alert-danger alert-dismissable"><?= $this->session->flashdata('error') ?></p>
    <?php endif ?>
        <!-- .form-group -->
        <div class="form-group">
          <div class="form-label-group">
            <?= form_input('username', $input->username, 'id="inputUser" class="form-control" placeholder="UsBername" required="" autofocus=""') ?>
            <label for="inputUser">Username</label>
            <?= form_error('username', '<p class="text-danger">', '</p>');?>
          </div>
        </div>
        <!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group">
          <div class="form-label-group">
            <?= form_password('password', $input->password, 'id="inputPassword" class="form-control" placeholder="Password" required=""') ?>
            <label for="inputPassword">Password</label>
            <?= form_error('password', '<p class="text-danger">', '</p>');?>
          </div>
        </div>
        <!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
        </div>
        <!-- /.form-group -->
      <?= form_close() ?>
      <!-- /.auth-form -->
      <!-- copyright -->
      <footer class="auth-footer">
        <p><strong>last update : 12 oktober 2018</strong></p>
        <p class="text-center"><a href="#">About</a></p>
      </footer>
    </main>
    <!-- /.auth -->
    <!-- END PLUGINS JS -->
  </body>
</html>