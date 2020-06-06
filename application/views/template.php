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
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/open-iconic/css/open-iconic-bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/font-awesome/css/fontawesome-all.min.css')?>">
    <!-- END BASE STYLES -->
    <!-- BEGIN PLUGINS STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/flatpickr/flatpickr_new.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/select2/css/select2.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/toastr/toastr.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/summernote/summernote-bs4.css')?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="<?= base_url('assets/stylesheets/main.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/stylesheets/custom.css')?>">
    <!-- END THEME STYLES -->
    <!-- JS -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-validation/additional-methods.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/DoubleScroll/jquery.doubleScroll.js'); ?>"></script>

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
    <script src="<?= base_url('assets/vendor/flatpickr/flatpickr_new.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/handlebars/handlebars.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/select2/js/select2.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/tribute/tribute.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/Caret/jquery.caret.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/At.js/js/jquery.atwho.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/toastr/toastr.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/summernote/summernote-bs4.js')?>"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <!-- END PLUGINS JS -->
    <!-- BEGIN THEME JS -->
    <script src="<?= base_url('assets/javascript/main.min.js')?>"></script>
    <!-- END THEME JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="<?= base_url('assets/javascript/pages/flatpickr-demo.js')?>"></script>
    <script src="<?= base_url('assets/javascript/pages/select2-demo.js')?>"></script>
    <script src="<?= base_url('assets/javascript/pages/easypiechart-demo.js')?>"></script>
    <script src="<?= base_url('assets/javascript/pages/summernote-demo.js')?>"></script>
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
    <?php
        $username = ucwords($this->session->userdata('username'));
        $ceklevel = $this->session->userdata('level');
        $level = ucwords(str_replace('_', ' ', $ceklevel));
        $ceklevelasli = $this->session->userdata('level_asli');
    ?>
    <script src="https://www.gstatic.com/firebasejs/7.6.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.6.2/firebase-messaging.js"></script>  
    <script src="<?php echo base_url(); ?>assets/init.js"></script>
    <script type="text/javascript">
        window.addEventListener('load', () => {
          if (!Notification) {
            alert('Desktop notifications not available in your browser. Try Chromium.');
            return;
          }else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
            // If the user accepts, let's create a notification
              if (permission === "granted") {
                  if ('serviceWorker' in navigator) {
                      navigator.serviceWorker.register('<?php echo base_url('assets/service-worker.js'); ?>')
                          .then(registration => {
                              messaging.useServiceWorker(registration);
                              initFirebase();
                          })
                          .catch(err => console.log('Service Worker Error', err))

                  } else {
                      alert('servis notifikasi tidak support di browser anda');
                      console.log('push notif not suppport');
                  }
              }
            });
          }
        });

        const messaging = firebase.messaging();

        function initFirebase(){
          messaging.requestPermission()
          .then(function() {
            console.log('Notification firebase permission granted.');
            return messaging.getToken();
          })
          .then(function(token) {
          //send this token to server
            //console.log(token); // Display user token
            var levelLogin = "<?php echo $level; ?>";

            subscribeTokenToTopic(token, "sigap_<?php echo $ceklevel; ?>");
            changeTokenUser(token);
            
          })
          .catch(function(err) { // Happen if user deney permission
            console.log('Unable to get permission to notify.', err);
          });
        }
        messaging.onMessage((payload) => {
            if (Notification.permission !== 'granted'){
              Notification.requestPermission();
             }else {
              var notification = new Notification(payload.notification.title, {
               icon: '<?php echo base_url(); ?>assets/favicon.ico',
               body: payload.notification.body,
              });
              notification.onclick = function() {
               window.open('<?php echo site_url('draft/view/'); ?>'+encodeURI(payload.data.draft_id));
              };
             }
            //console.log('Message received. ', payload);
        });
        
        function subscribeTokenToTopic(token, topic) {
          fetch('https://iid.googleapis.com/iid/v1/'+token+'/rel/topics/'+topic, {
            method: 'POST',
            headers: new Headers({
              'Authorization': 'key=AAAAynUFPBA:APA91bE6RmWSRL4AblfZhilkkwAhofDE7paQKDGenK__xRRDSeEDAggJyUvCyyEUxFnPB01DDII-n0II0VZ6fVkqkcdTRyoEWWmMgevYhgwiygalwTER331AtbyKyyXVXYZHIEZYLzc3',
              'Content-Type': 'application/json'
            })
          }).then(response => {
            if (response.status < 200 || response.status >= 400) {
              throw 'Error subscribing to topic: '+response.status + ' - ' + response.text();
            }
            console.log('Subscribed to "'+topic+'"');
          }).catch(error => {
            console.error(error);
          })
        }

        function changeTokenUser(firebaseToken){
            $.ajax({
                url: '<?php echo site_url('login/changeTokenFirebase'); ?>',
                type: 'post',
                data: {token: firebaseToken},
                success: function(result){
                    console.log(result);
                },
                error: function(xhr){
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
  </body>
</html>
