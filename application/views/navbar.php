<?php 
    $username = ucwords($this->session->userdata('username'));
    $ceklevel = $this->session->userdata('level');
    $level = ucwords(str_replace('_', ' ', $ceklevel));
    $ceklevelasli = $this->session->userdata('level_asli');
?>
<header class="app-header">
  <!-- .top-bar -->
  <div class="top-bar">
    <!-- .top-bar-brand -->
    <div class="top-bar-brand">
      <a href="<?php echo base_url(); ?>">
        <img src="<?= base_url('') ?>" height="32" alt=""> 
        <span class="badge badge-light" style="font-size: 1.3em">SIGAP</span>
      </a>
    </div>
    <!-- /.top-bar-brand -->
    <!-- .top-bar-list -->
    <div class="top-bar-list">
      <!-- .top-bar-item -->
      <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
        <!-- toggle menu -->
        <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="Menu" aria-controls="navigation">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
        <!-- /toggle menu -->
      </div>
      <!-- /.top-bar-item -->
      <!-- .top-bar-item -->
      <div class="top-bar-item top-bar-item-full">
        <!-- .top-bar-search -->
        <!-- <div class="top-bar-search">
          <div class="input-group input-group-search">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <span class="oi oi-magnifying-glass"></span>
              </span>
            </div>
            <input type="text" class="form-control" aria-label="Search" placeholder="Search"> </div>
        </div> -->
        <!-- /.top-bar-search -->
      </div>
      <!-- /.top-bar-item -->
      <!-- .top-bar-item -->
      <div class="top-bar-item top-bar-item-right px-0 d-none d-sm-flex">
        <!-- .nav -->
        <ul class="header-nav nav">
        
          <!-- .nav-item -->
          <li class="nav-item dropdown header-nav-dropdown">
            <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="oi oi-grid-three-up"></span>
            </a>
            <div class="dropdown-arrow"></div>
            <!-- .dropdown-menu -->
            <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
              <!-- .dropdown-sheets -->
              <div class="dropdown-sheets">
                <!-- .dropdown-sheet-item -->
                <div class="dropdown-sheet-item">
                  <a href="#" class="tile-wrapper">
                    <span class="tile tile-lg bg-indigo">
                      <i class="oi oi-people"></i>
                    </span>
                    <span class="tile-peek">Teams</span>
                  </a>
                </div>
                <!-- /.dropdown-sheet-item -->
              </div>
              <!-- .dropdown-sheets -->
            </div>
            <!-- .dropdown-menu -->
          </li>
          <!-- /.nav-item -->
        </ul>
        <!-- /.nav -->
        <!-- .btn-account -->
        <div class="dropdown">
          <button class="btn-account d-none d-md-flex" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="user-avatar">
              <img src="<?= base_url('assets/images/avatars/profile.jpg') ?>" alt="">
            </span>
            <span class="account-summary pr-lg-4 d-none d-lg-block">
              <span class="account-name"><?=$username ?></span>
              <span class="account-description"><?=$level ?></span>
            </span>
          </button>
          <div class="dropdown-arrow dropdown-arrow-left"></div>
          <!-- .dropdown-menu -->
          <div class="dropdown-menu">
            <h6 class="dropdown-header d-none d-md-block d-lg-none"><?=$username ?></h6>

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
          <!-- /.dropdown-menu -->
        </div>
        <!-- /.btn-account -->
      </div>
      <!-- /.top-bar-item -->
    </div>
    <!-- /.top-bar-list -->
  </div>
  <!-- /.top-bar -->
</header>