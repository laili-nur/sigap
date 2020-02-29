<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('author');?>">Penulis</a>
         </li>
         <li class="breadcrumb-item active">
            <a class="text-muted"><?=$author->author_name;?></a>
         </li>
      </ol>
   </nav>
</header>
<div class="page-section">
   <div class="row">
      <div class="col-12">
         <header class="page-cover">
            <div class="text-center mt-4">
               <a
                  href="#"
                  class="user-avatar user-avatar-xl"
               >
                  <img
                     src="<?=base_url();?>assets/images/avatars/profile.jpg"
                     alt="User Avatar"
                  >
               </a>
               <h2 class="h4 mt-3 mb-0"> <?=$author->author_name;?> </h2>
               <p class="text-muted mb-0">
                  <?=isset($author->level) ? ucwords(str_replace('_', ' ', $author->level)) : '<small class="text-danger">Penulis belum memiliki akun</small>';?>
               </p>
            </div>
         </header>
         <nav class="page-navs mb-4">
            <div class="nav-scroller">
               <div class="nav nav-center nav-tabs border-0">
                  <a
                     class="nav-link <?=($this->uri->segment(3) == 'profil') ? 'active' : '';?>"
                     href="<?=base_url('author/view/profil/' . $author->author_id);?>"
                  >Profil</a>
                  <a
                     class="nav-link <?=($this->uri->segment(3) == 'riwayat_draft') ? 'active' : '';?>"
                     href="<?=base_url('author/view/riwayat_draft/' . $author->author_id);?>"
                  >Riwayat Draft
                     <span class="badge badge-primary"><?=$total_draft;?></span>
                  </a>
                  <a
                     class="nav-link <?=($this->uri->segment(3) == 'riwayat_buku') ? 'active' : '';?>"
                     href="<?=base_url('author/view/riwayat_buku/' . $author->author_id);?>"
                  >Riwayat Buku
                     <span class="badge badge-primary"><?=$total_book;?></span>
                  </a>
               </div>
            </div>
         </nav>
      </div>
      <div class="col-12">
         <?php if ($this->uri->segment(3) == 'profil'): ?>
         <?php $this->load->view('author/view/profil');?>

         <?php elseif ($this->uri->segment(3) == 'riwayat_draft'): ?>
         <?php $this->load->view('author/view/riwayat_draft');?>

         <?php elseif ($this->uri->segment(3) == 'riwayat_buku'): ?>
         <?php $this->load->view('author/view/riwayat_buku');?>

         <?php endif;?>
      </div>
   </div>
</div>