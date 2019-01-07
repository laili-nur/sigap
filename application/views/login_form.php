<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- End Required meta tags -->
    <!-- Begin SEO tag -->
    <title> SIGAP LOGIN</title>
    <meta property="og:title" content="Log In">
    <meta name="author" content="bagaskara luthfi">
    <meta property="og:locale" content="en_US">
    <meta name="description" content="SIGAP - Sistem Informasi Penerbitan UGM PRESS">
    <meta property="og:description" content="Sistem Informasi Penerbitan UGM PRESS">
    <link rel="canonical" href="">
    <meta property="og:url" content="//digitalpress.ac.id/sigap">
    <meta property="og:site_name" content="SIIP UGMPRESS">
    <!-- Favicons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/apple-touch-icon.png">
    <link rel="shortcut icon" href="assets/favicon.ico">
    <meta name="theme-color" content="#3063A0">
    <!-- BEGIN BASE STYLES -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/fontawesome-all.min.css">
    <!-- END BASE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="assets/stylesheets/main.css">
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
        <p class="text-center"><a href="#" data-toggle="modal" data-target="#exampleModalSm">About</a></p>
        <!-- .modal -->
	      <div id="exampleModalSm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	        <!-- .modal-dialog -->
	        <div class="modal-dialog modal-lg" role="document">
	          <!-- .modal-content -->
	          <div class="modal-content">
	            <!-- .modal-header -->
	            <div class="modal-header">
	              <h5 class="modal-title text-center"> About us </h5>
	            </div>
	            <!-- /.modal-header -->
	            <!-- .modal-body -->
	            <div class="modal-body">
                  <!-- metric row -->
                  <div class="metric-row">
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <div class="text-center mb-4">
					          <!-- .user-avatar -->
					          <div class="user-avatar user-avatar-xl mb-2">
					            <img src="assets/images/avatars/profile.jpg" alt="User Avatar"> </div>
					          <!-- /.user-avatar -->
					          <h2 class="card-title"> I Wayan Mustika </h2>
					          <h6 class="card-subtitle text-muted"> Supervisor<br>Administrator </h6>
					        </div>
                        </div>
                      </div>
                      <!-- /.metric -->
                    </div>
                    <!-- /metric column -->
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <div class="text-center mb-4">
					          <!-- .user-avatar -->
					          <div class="user-avatar user-avatar-xl mb-2">
					            <img src="assets/images/avatars/profile.jpg" alt="User Avatar"> </div>
					          <!-- /.user-avatar -->
					          <h2 class="card-title"> Bagaskara LA </h2>
					          <h6 class="card-subtitle text-muted"> Front End and UX Developer </h6>
					        </div>
                        </div>
                      </div>
                      <!-- /.metric -->
                    </div>
                    <!-- /metric column -->
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <div class="text-center mb-4">
					          <!-- .user-avatar -->
					          <div class="user-avatar user-avatar-xl mb-2">
					            <img src="assets/images/avatars/profile.jpg" alt="User Avatar"> </div>
					          <!-- /.user-avatar -->
					          <h2 class="card-title"> Edward </h2>
					          <h6 class="card-subtitle text-muted"> Back End and Database Developer </h6>
					        </div>
                        </div>
                      </div>
                      <!-- /.metric -->
                    </div>
                    <!-- /metric column -->
                    <!-- metric column -->
                    <div class="col-12 col-sm-6 col-lg-3">
                      <!-- .metric -->
                      <div class="card-metric">
                        <div class="metric">
                          <div class="text-center mb-4">
					          <!-- .user-avatar -->
					          <div class="user-avatar user-avatar-xl mb-2">
					            <img src="assets/images/avatars/profile.jpg" alt="User Avatar"> </div>
					          <!-- /.user-avatar -->
					          <h2 class="card-title"> Syuhada Sipayung </h2>
					          <h6 class="card-subtitle text-muted"> Business Reporting and API Developer </h6>
					        </div>
                        </div>
                      </div>
                      <!-- /.metric -->
                    </div>
                    <!-- /metric column -->
                  </div>
                  <!-- /metric row -->

		        
	            </div>
	            <!-- /.modal-body -->
	            <!-- .modal-footer -->
	            <div class="modal-footer">
	              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
	            </div>
	            <!-- /.modal-footer -->
	          </div>
	          <!-- /.modal-content -->
	        </div>
	        <!-- /.modal-dialog -->
	      </div>
	      <!-- /.modal -->
      </footer>
    </main>
    <!-- /.auth -->
    <!-- BEGIN BASE JS -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!-- END BASE JS -->
  </body>
</html>