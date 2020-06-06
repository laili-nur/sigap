<?php
    $username = ucwords($this->session->userdata('username'));
    $ceklevel = $this->session->userdata('level');
    $level = ucwords(str_replace('_', ' ', $ceklevel));
    $ceklevelasli = $this->session->userdata('level_asli');
?>
<!-- .app-aside -->
  <aside class="app-aside">
    <!-- .aside-content -->
    <div class="aside-content">
      <!-- .aside-header -->
      <header class="aside-header d-block d-md-none">
        <!-- .btn-account -->
        <button class="btn-account" type="button" data-toggle="collapse" data-target="#dropdown-aside">
          <span class="user-avatar user-avatar-lg">
            <img src="<?= base_url('assets/images/avatars/profile.jpg') ?>" alt="">
          </span>
          <span class="account-icon">
            <span class="fa fa-caret-down fa-lg"></span>
          </span>
          <span class="account-summary">
            <span class="account-name"><?=$username ?></span>
            <span class="account-description"><?=$level ?></span>
          </span>
        </button>
        <!-- /.btn-account -->
        <!-- .dropdown-aside -->
        <div id="dropdown-aside" class="dropdown-aside collapse">
          <!-- dropdown-items -->
          <div class="pb-3">
            <?php if($ceklevelasli=='author_reviewer'): ?>
                <?php if($ceklevel=='author'): ?>
                  <a class="dropdown-item" href="<?=base_url('login/multilevel/reviewer') ?>">
                    <span class="dropdown-icon fa fa-sign-in-alt"></span> Masuk sebagai Reviewer</a>
                <?php else: ?>
                  <a class="dropdown-item" href="<?=base_url('login/multilevel/author') ?>">
                    <span class="dropdown-icon fa fa-sign-in-alt"></span> Masuk sebagai Author</a>
                <?php endif ?>
                <hr>
              <?php endif ?>
            <a class="dropdown-item" href="<?=base_url('user/changepassword/' . $this->session->userdata('user_id')) ?>">
              <span class="dropdown-icon fa fa-cog"></span> Ganti Password</a>
            <a class="dropdown-item" href="<?=base_url('login/logout') ?>">
              <span class="dropdown-icon oi oi-account-logout"></span> Logout</a>
          </div>
          <!-- /dropdown-items -->
        </div>
        <!-- /.dropdown-aside -->
      </header>
      <!-- /.aside-header -->
      <!-- .aside-menu -->
      <section class="aside-menu has-scrollable">
        <!-- .stacked-menu -->
        <nav id="stacked-menu" class="stacked-menu">
          <!-- .menu -->
          <ul class="menu">
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='home')?'has-active':'' ?>">
              <a href="<?= base_url() ?>" class="menu-link">
                <span class="menu-icon oi oi-dashboard"></span>
                <span class="menu-text">Dashboard</span>
              </a>
            </li>
            <li class="menu-header">Notifikasi </li>
            <li class="menu-item <?=($pages=='notifikasi belum dibaca')?'has-active':'' ?>">
              <a href="<?= base_url('notifikasi/belum_dibaca') ?>" class="menu-link">
                <span class="menu-icon fa fa-lightbulb"></span>
                <span class="menu-text" id="belum-dibaca">Belum Dibaca</span>
              </a>
            </li>
            <li class="menu-item <?=($pages=='notifikasi ditandai')?'has-active':'' ?>">
              <a href="<?= base_url('notifikasi/ditandai') ?>" class="menu-link">
                <span class="menu-icon fa fa-star"></span>
                <span class="menu-text" id="ditandai">Ditandai</span>
              </a>
            </li>
            <li class="menu-item <?=($pages=='notifikasi semua')?'has-active':'' ?>">
              <a href="<?= base_url('notifikasi/semua') ?>" class="menu-link">
                <span class="menu-icon fa fa-bell"></span>
                <span class="menu-text" id="semua-notif">Semua</span>
              </a>
            </li>
            <?php if ($ceklevel == 'editor' || $ceklevel == 'layouter' || $ceklevel == 'reviewer'){ ?>
            <li class="menu-item <?=($pages=='notifikasi deadline')?'has-active':'' ?>">
              <a href="<?= base_url('notifikasi/deadline') ?>" class="menu-link">
                <span class="menu-icon fa fa-clock"></span>
                <span class="menu-text" id="deadline">Deadline</span>
              </a>
            </li>
            <?php } ?>

            <!-- /.menu-item -->
            <!-- .menu-header -->
            <li class="menu-header">Penerbitan </li>
            <!-- /.menu-header -->
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='draft')?'has-active':'' ?>">
              <a href="<?= base_url('draft') ?>" class="menu-link">
                <span class="menu-icon fa fa-paperclip"></span>
                <span class="menu-text">Draft Usulan</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <?php if($ceklevel=='editor' || $ceklevel=='layouter' || $ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='worksheet')?'has-active':'' ?>">
              <a href="<?= base_url('worksheet') ?>" class="menu-link">
                <span class="menu-icon oi oi-pencil"></span>
                <span class="menu-text">Lembar Kerja</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <?php endif ?>
            <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='book')?'has-active':'' ?>">
              <a href="<?= base_url('book') ?>" class="menu-link">
                <span class="menu-icon fa fa-book"></span>
                <span class="menu-text">Buku</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <?php endif ?>
            <!-- jika bukan superadmin / admin penerbitan maka tampil draft sama buku doang -->
            <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='author')?'has-active':'' ?>">
              <a href="<?= base_url('author') ?>" class="menu-link">
                <span class="menu-icon fa fa-user-tie"></span>
                <span class="menu-text">Penulis</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='reviewer')?'has-active':'' ?>">
              <a href="<?= base_url('reviewer') ?>" class="menu-link ">
                <span class="menu-icon fa fa-user-graduate"></span>
                <span class="menu-text">Reviewer</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <?php if($ceklevelasli=='editor'): ?>
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='worksheet')?'has-active':'' ?>">
              <a href="<?= base_url('worksheet') ?>" class="menu-link">
                <span class="menu-icon oi oi-pencil"></span>
                <span class="menu-text">Lembar Kerja</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <?php endif ?>
            <!-- .menu-item -->
            <li class="menu-item has-child <?=($pages=='category' || $pages=='work_unit' || $pages=='theme' || $pages=='faculty' || $pages=='work_unit' || $pages=='institute')?'has-active':'' ?>">
              <a href="#" class="menu-link ">
                <span class="menu-icon oi oi-puzzle-piece"></span>
                <span class="menu-text">Data Pendukung</span>
              </a>
              <!-- child menu -->
              <ul class="menu">
                <li class="menu-item <?=($pages=='category')?'has-active':'' ?>">
                  <a href="<?= base_url('category') ?>" class="menu-link">Data Kategori</a>
                </li>
                <li class="menu-item <?=($pages=='theme')?'has-active':'' ?>">
                  <a href="<?= base_url('theme') ?>" class="menu-link">Data Tema</a>
                </li>
                <li class="menu-item <?=($pages=='faculty')?'has-active':'' ?>">
                  <a href="<?= base_url('faculty') ?>" class="menu-link">Data Fakultas</a>
                </li>
                <li class="menu-item <?=($pages=='work_unit')?'has-active':'' ?>">
                  <a href="<?= base_url('work_unit') ?>" class="menu-link">Data Unit Kerja </a>
                </li>
                <li class="menu-item <?=($pages=='institute')?'has-active':'' ?>">
                  <a href="<?= base_url('institute') ?>" class="menu-link">Data Institusi</a>
                </li>
              </ul>
              <!-- /child menu -->
            </li>
            <!-- /.menu-item -->
            <!-- if superadmin halaman user -->
            <?php if ($ceklevel == 'superadmin'): ?>
            <!-- .menu-header -->
            <li class="menu-header">LAPORAN </li>
            <!-- /.menu-header -->
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='reporting')?'has-active':'' ?>">
              <a href="<?=base_url('reporting') ?>" class="menu-link">
                <span class="menu-icon fa fa-chart-bar"></span>
                <span class="menu-text">Laporan</span>
              </a>
            </li>
            <li class="menu-item <?=($pages=='performance')?'has-active':'' ?>">
              <a href="<?=base_url('performance') ?>" class="menu-link">
                <span class="menu-icon fa fa-walking"></span>
                <span class="menu-text">Performa</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <!-- .menu-header -->
            <li class="menu-header">Pengaturan </li>
            <!-- /.menu-header -->
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='document')?'has-active':'' ?>">
              <a href="<?=base_url('document') ?>" class="menu-link">
                <span class="menu-icon fa fa-file"></span>
                <span class="menu-text">Dokumen</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='user')?'has-active':'' ?>">
              <a href="<?=base_url('user') ?>" class="menu-link">
                <span class="menu-icon fa fa-users"></span>
                <span class="menu-text">Akun User</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <!-- .menu-item -->
            <li class="menu-item <?=($pages=='setting')?'has-active':'' ?>">
              <a href="<?=base_url('setting') ?>" class="menu-link">
                <span class="menu-icon fa fa-cog"></span>
                <span class="menu-text">Setting</span>
              </a>
            </li>
            <!-- /.menu-item -->
            <?php endif ?>
            <!-- endif superadmin halaman user dan setting -->

          <?php endif ?>
          </ul>
          <!-- /.menu -->
        </nav>
        <!-- /.stacked-menu -->
      </section>
      <!-- /.aside-menu -->
    </div>
    <!-- /.aside-content -->
  </aside>
  <!-- /.app-aside -->
<script type="text/javascript">
  display_notifikasi();

  function display_notifikasi(){
      $.ajax({
          url: "<?php echo site_url('home/ajax_notifikasi'); ?>",
          dataType: 'json',
          success: function(result){
              console.log(result);

              let display_belum_dibaca;
              if(result.belum_dibaca>0){
                display_belum_dibaca = 'Belum Dibaca <span class="badge badge-danger">'+result.belum_dibaca+'</span>';
              }else{
                display_belum_dibaca = 'Belum Dibaca';
              }
              $('#belum-dibaca').html(display_belum_dibaca);

              let display_ditandai;
              if(result.ditandai>0){
                display_ditandai = 'Ditandai <span class="badge badge-danger">'+result.ditandai+'</span>';
              }else{
                display_ditandai = 'Ditandai';
              }
              $('#ditandai').html(display_ditandai);

              let display_semua;
              if(result.semua>0){
                display_semua = 'Semua <span class="badge badge-info">'+result.semua+'</span>';
              }else{
                display_semua = 'Semua';
              }
              $('#semua-notif').html(display_semua);
              //setTimeout(function(){display_notifikasi()}, 20000);

              let display_deadline;
              if(result.deadline>0){
                display_deadline = 'Deadline <span class="badge badge-warning">'+result.deadline+'</span>';
              }else{
                display_deadline = 'Deadline';
              }
              $('#deadline').html(display_deadline);
              //setTimeout(function(){display_notifikasi()}, 1000*60*10);
          }
      });
      //setTimeout(display_notifikasi(), 10000);
  }
</script>
<?php
function jml_notif(){
  $CI =& get_instance();
  $query = $CI->db->query("select count(id) jml from notifikasi where user_id='$_SESSION[user_id]' and (is_read='0' || is_mark='1')")->row();
  return $query->jml;

}