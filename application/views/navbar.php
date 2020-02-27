<?php
$username     = ucwords($this->session->userdata('username'));
$ceklevel     = $this->session->userdata('level');
$level        = ucwords(str_replace('_', ' ', $ceklevel));
$ceklevelasli = $this->session->userdata('level_asli');
?>

<header class="app-header app-header-dark">
   <div class="top-bar">
      <div class="top-bar-brand">
         <a href="<?php echo base_url(); ?>">
            <span
               class="badge badge-light"
               style="font-size: 1.3em"
            >SIGAP <small>v2</small></span>
         </a>
      </div>

      <div class="top-bar-list">
         <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
            <button
               class="hamburger hamburger-squeeze"
               type="button"
               data-toggle="aside"
               aria-label="toggle menu"
            ><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>
         </div>
         <div class="top-bar-item top-bar-item-right px-0">
            <ul class="header-nav nav">
               <li class="nav-item dropdown header-nav-dropdown">
                  <a
                     class="nav-link has-badge"
                     href="#"
                     data-toggle="dropdown"
                     aria-haspopup="true"
                     aria-expanded="false"
                  ><span class="badge badge-pill badge-warning">12</span> <span class="oi oi-pulse"></span></a>
                  <div class="dropdown-arrow"></div>
                  <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                     <h6 class="dropdown-header stop-propagation">
                        <span>Activities <span class="badge">(2)</span></span>
                     </h6>
                     <div class="dropdown-scroll perfect-scrollbar">
                        <a
                           href="#"
                           class="dropdown-item unread"
                        >
                           <div class="user-avatar">
                              <img
                                 src="assets/images/avatars/uifaces15.jpg"
                                 alt=""
                              >
                           </div>
                           <div class="dropdown-item-body">
                              <p class="text"> Jeffrey Wells created a schedule </p><span class="date">Just now</span>
                           </div>
                        </a>
                        <a
                           href="#"
                           class="dropdown-item"
                        >
                           <div class="user-avatar">
                              <img
                                 src="assets/images/avatars/uifaces17.jpg"
                                 alt=""
                              >
                           </div>
                           <div class="dropdown-item-body">
                              <p class="text"> Sara Carr invited to Stilearn Admin </p><span class="date">5 hours
                                 ago</span>
                           </div>

                     </div>
                     <a
                        href="user-activities.html"
                        class="dropdown-footer"
                     >All activities <i class="fas fa-fw fa-long-arrow-alt-right"></i></a>
                  </div>
               </li>
               <li class="nav-item dropdown header-nav-dropdown">
                  <a
                     class="nav-link"
                     href="#"
                     data-toggle="dropdown"
                     aria-haspopup="true"
                     aria-expanded="false"
                  ><span class="oi oi-grid-three-up"></span></a>
                  <div class="dropdown-arrow"></div>
                  <div class="dropdown-menu dropdown-menu-rich dropdown-menu-right">
                     <div class="dropdown-sheets">
                        <div class="dropdown-sheet-item">
                           <a
                              href="#"
                              class="tile-wrapper"
                           ><span class="tile tile-lg bg-indigo"><i class="oi oi-people"></i></span> <span
                                 class="tile-peek"
                              >Teams</span></a>
                        </div>
                     </div>
                  </div>
               </li>
            </ul>

            <div class="dropdown d-none d-sm-flex">
               <button
                  class="btn-account"
                  type="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
               >
                  <span class="user-avatar user-avatar-md">
                     <img
                        src="<?=base_url('assets/images/avatars/profile.jpg');?>"
                        alt=""
                     >
                  </span>
                  <span class="account-summary pr-md-4 d-none d-md-block">
                     <span class="account-name"><?=$username;?></span>
                     <span class="account-description"><?=$level;?></span>
                  </span>
               </button>
               <div class="dropdown-arrow dropdown-arrow-left"></div><!-- .dropdown-menu -->
               <div class="dropdown-menu">
                  <h6 class="dropdown-header d-none d-sm-block d-md-none"> <?=$username;?> </h6>

                  <?php if ($ceklevelasli == 'author_reviewer'): ?>
                  <?php if ($ceklevel == 'author'): ?>
                  <a
                     class="dropdown-item"
                     href="<?=base_url('login/multilevel/reviewer');?>"
                  >
                     <span class="dropdown-icon fa fa-sign-in-alt"></span> Masuk sebagai Reviewer</a>
                  <?php else: ?>
                  <a
                     class="dropdown-item"
                     href="<?=base_url('login/multilevel/author');?>"
                  >
                     <span class="dropdown-icon fa fa-sign-in-alt"></span> Masuk sebagai Author</a>
                  <?php endif;?>
                  <div class="dropdown-divider"></div>
                  <?php endif;?>

                  <a
                     class="dropdown-item"
                     href="<?=base_url('user/changepassword/' . $this->session->userdata('user_id'));?>"
                  >
                     <span class="dropdown-icon fa fa-cog"></span> Ganti Password</a>
                  <a
                     class="dropdown-item"
                     href="<?=base_url('login/logout');?>"
                  >
                     <span class="dropdown-icon oi oi-account-logout"></span> Logout</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</header>