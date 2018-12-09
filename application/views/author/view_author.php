<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>"><span class="fa fa-home"></span></a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url()?>">Penerbitan</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?=base_url('author')?>">Penulis</a>
      </li>
      <li class="breadcrumb-item active">
        <a class="text-muted"><?=$input->author_name; ?></a>
      </li>
    </ol>
  </nav> 
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <!-- grid row -->
  <div class="row">
    <!-- grid column -->
    <div class="col-12">
      <!-- .page-cover -->
      <header class="page-cover">
        <div class="text-center">
          <a href="user-profile.html" class="user-avatar user-avatar-xl">
            <img src="<?=base_url() ?>assets/images/avatars/profile.jpg" alt="User Avatar">
          </a>
          <h2 class="h4 mt-3 mb-0"> <?=$input->author_name; ?> </h2>
          <p class="text-muted mb-0"> <?=isset($input->level)? ucwords(str_replace('_', ' ', $input->level)):'<small class="text-danger">Penulis belum memiliki akun</small>'; ?> </p>
        </div>
      </header>
      <!-- /.page-cover -->
      <!-- .page-navs -->
        <nav class="page-navs mb-4">
          <!-- .nav-scroller -->
          <div class="nav-scroller">
            <!-- .nav -->
            <div class="nav nav-center nav-tabs border-0">
              <a class="nav-link <?=($this->uri->segment(3)=='profil')?'active':''; ?>" href="<?= base_url('author/view/profil/'.$input->author_id) ?>">Profil</a>
              <a class="nav-link <?=($this->uri->segment(3)=='riwayat_draft')?'active':''; ?>" href="<?= base_url('author/view/riwayat_draft/'.$input->author_id) ?>">Riwayat Draft
                <span class="badge badge-primary"><?=$total_draft ?></span>
              </a>
              <a class="nav-link <?=($this->uri->segment(3)=='riwayat_buku')?'active':''; ?>" href="<?= base_url('author/view/riwayat_buku/'.$input->author_id) ?>">Riwayat Buku
                <span class="badge badge-primary"><?=$total_book ?></span>
              </a>
            </div>
            <!-- /.nav -->
          </div>
          <!-- /.nav-scroller -->
        </nav>
        <!-- /.page-navs -->
    </div>
    <!-- /grid column -->
    <div class="col-12">
      <?php
      /*====================================
      =            partial view            =
      ====================================*/
      if($this->uri->segment(3)=='profil') {
        $this->load->view('author/view/profil');
      }
      elseif ($this->uri->segment(3)=='riwayat_draft') {
        $this->load->view('author/view/riwayat_draft');
      }
      elseif ($this->uri->segment(3)=='riwayat_buku') {
        $this->load->view('author/view/riwayat_buku');
      }

      ?>
    </div>
  </div>
</div>
