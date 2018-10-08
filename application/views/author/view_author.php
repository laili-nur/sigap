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
    <div class="col-lg-4">
      <!-- .card -->
      <div class="card card-fluid">
        <h6 class="card-header"> Detail </h6>
        <!-- .nav -->
        <nav class="nav nav-tabs flex-column">
          <a href="<?= base_url('author/profil/'.$input->author_id) ?>" class="nav-link <?=($this->uri->segment(2)=='profil')? 'active' : '' ?>">Profil</a>
          <a href="<?= base_url('author/riwayat_draft/'.$input->author_id) ?>" class="nav-link <?=($this->uri->segment(2)=='riwayat_draft')? 'active' : '' ?>">Riwayat Draft</a>
        </nav>
        <!-- /.nav -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /grid column -->
    <!-- grid column -->
    <div class="col-lg-8">
      <?php 
      if($this->uri->segment(2)=='profil') {
        $this->load->view('author/view/profil');
      }
      elseif ($this->uri->segment(2)=='riwayat_draft') {
        $this->load->view('author/view/riwayat_draft');
      }

      ?>
    </div>
     