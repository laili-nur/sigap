<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- End Required meta tags -->
    <!-- Begin SEO tag -->
    <title> SIIP LOGIN</title>
    <meta property="og:title" content="Sign In">
    <meta name="author" content="Beni Arisandi">
    <meta property="og:locale" content="en_US">
    <meta name="description" content="Responsive admin theme build on top of Bootstrap 4">
    <meta property="og:description" content="Responsive admin theme build on top of Bootstrap 4">
    <link rel="canonical" href="//uselooper.com">
    <meta property="og:url" content="//uselooper.com">
    <meta property="og:site_name" content="Looper - Bootstrap 4 Admin Theme">
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
          SIIP UGMPRESS
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
      <footer class="auth-footer"> IT Team
      </footer>
    </main>
    <!-- /.auth -->
    <!-- END PLUGINS JS -->
  </body>
</html>