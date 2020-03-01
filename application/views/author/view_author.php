<?php $third_uri = $this->uri->segment(3);?>

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
         <header class="page-cover pt-5">
            <div class="text-center">
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
                     class="nav-link <?=($third_uri == 'profile') ? 'active' : '';?>"
                     href="<?=base_url('author/view/profile/' . $author->author_id);?>"
                  >Profil</a>
                  <a
                     class="nav-link <?=($third_uri == 'draft_history') ? 'active' : '';?>"
                     href="<?=base_url('author/view/draft_history/' . $author->author_id);?>"
                  >Riwayat Draft
                     <span class="badge badge-primary"><?=$total_draft;?></span>
                  </a>
                  <a
                     class="nav-link <?=($third_uri == 'book_history') ? 'active' : '';?>"
                     href="<?=base_url('author/view/book_history/' . $author->author_id);?>"
                  >Riwayat Buku
                     <span class="badge badge-primary"><?=$total_book;?></span>
                  </a>
               </div>
            </div>
         </nav>
      </div>
      <div class="col-12">
         <?php if ($third_uri == 'profile'): ?>
         <?php $this->load->view('author/view/profile');?>

         <?php elseif ($third_uri == 'draft_history'): ?>
         <?php $this->load->view('author/view/draft_history');?>

         <?php elseif ($third_uri == 'book_history'): ?>
         <?php $this->load->view('author/view/book_history');?>

         <?php endif;?>
      </div>
   </div>
</div>