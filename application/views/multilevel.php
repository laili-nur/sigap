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
   <title>Pilih Role</title>
   <!-- file bawaan template -->

   <!-- FAVICONS -->
   <link
      rel="apple-touch-icon-precomposed"
      sizes="144x144"
      href="<?=base_url('assets/apple-touch-icon.png');?>"
   >
   <link
      rel="shortcut icon"
      href="<?=base_url('assets/favicon.ico');?>"
   >
   <meta
      name="theme-color"
      content="#3063A0"
   >
   <!-- End FAVICONS -->
   <!-- BEGIN BASE STYLES -->
   <link
      rel="stylesheet"
      href="<?=base_url('assets/vendor/pace/pace.min.css');?>"
   >
   <link
      rel="stylesheet"
      href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.min.css');?>"
   >
   <link
      rel="stylesheet"
      href="<?=base_url('assets/vendor/open-iconic/css/open-iconic-bootstrap.min.css');?>"
   >
   <link
      rel="stylesheet"
      href="<?=base_url('assets/vendor/font-awesome/css/fontawesome-all.min.css');?>"
   >
   <!-- END BASE STYLES -->
   <!-- BEGIN THEME STYLES -->
   <link
      rel="stylesheet"
      href="<?=base_url('assets/stylesheets/main.css');?>"
   >
   <link
      rel="stylesheet"
      href="<?=base_url('assets/stylesheets/custom.css');?>"
   >
   <!-- END THEME STYLES -->
</head>

<body>
   <!-- .empty-state -->
   <main class="empty-state empty-state-fullpage bg-primary">
      <!-- .empty-state-container -->
      <div class="empty-state-container">
         <section class="card">
            <header class="card-header bg-light text-left">
               <i class="fa fa-fw fa-circle text-red"></i>
               <i class="fa fa-fw fa-circle text-yellow"></i>
               <i class="fa fa-fw fa-circle text-teal"></i>
            </header>
            <div class="card-body">
               <h3> Pilih Role </h3>
               <p class="font-weight-bold">Akun = <?=ucwords($this->session->userdata('username'));?></p>
               <p>Akun anda mempunyai role author dan reviewer.</p>
               <button
                  class="btn btn-success my-2"
                  onclick="location.href='<?=base_url('auth/multilevel/author');?>';"
               >Masuk sebagai Author</button>
               <button
                  class="btn btn-warning my-2"
                  onclick="location.href='<?=base_url('auth/multilevel/reviewer');?>';"
               >Masuk sebagai Reviewer</button>
               <div class="state-action">

                  <a
                     href="<?=base_url('auth/logout');?>"
                     class="btn btn-lg btn-light my-2"
                  >
                     <i class="fa fa-logout"></i> Logout</a>
               </div>
            </div>
         </section>
      </div>
      <!-- /.empty-state-container -->
   </main>
   <!-- /.empty-state -->
</body>

</html>