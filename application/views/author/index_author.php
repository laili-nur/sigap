<?php
$per_page = 10;
$keywords = $this->input->get('keywords');

if (isset($keywords)) {
    $page = $this->uri->segment(3);
} else {
    $page = $this->uri->segment(2);
}

// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;
?>

<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a class="text-muted">Penulis</a>
         </li>
      </ol>
   </nav>
   <div class="d-flex justify-content-between align-items-center">
      <div>
         <h1 class="page-title"> Penulis </h1>
         <span class="badge badge-info">Total : <?=$total;?></span>
      </div>
      <a
         href="<?=base_url('author/add');?>"
         class="btn btn-primary btn-sm"
      ><i class="fa fa-plus fa-fw"></i> Tambah</a>
   </div>
   <div
      class="alert alert-info alert-dismissible fade show mt-3"
      role="alert"
   >
      <h5>Info</h5>
      <p class="m-0">Klik tombol <button class="btn btn-sm btn-primary"><i class="fa fa-user-plus"></i></button> untuk
         menyalin data penulis yang terpilih untuk
         dijadikan reviewer. <strong>Pastikan author memiliki akun agar dapat disalin.</strong></p>
      <button
         type="button"
         class="close"
         data-dismiss="alert"
         aria-label="Close"
      >
         <span aria-hidden="true">&times;</span>
      </button>
   </div>
</header>
<div class="page-section">
   <div class="row">
      <div class="col-12">
         <section class="card card-fluid">
            <!-- <header class="card-header ">
               <div class="d-flex align-items-center">
                  <span class="mr-auto">Tabel Penulis <span class="badge badge-info"><?=$total;?></span></span>
                  <div class="card-header-control">
                     <a
                        href="<?=base_url('author/add');?>"
                        class="btn btn-primary btn-sm"
                     >Tambah Penulis</a>
                  </div>
               </div>
            </header> -->
            <div class="card-body p-0">
               <div
                  class="tab-pane fade active show"
                  id="card-tabel1"
               >
                  <div class="p-3">
                     <?=form_open('author', ['method' => 'GET']);?>
                     <div class="input-group input-group-alt">
                        <?=form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Cari berdasarkan Nama Penulis, Username, NIP, Unit Kerja atau Institusi', 'class' => 'form-control']);?>
                        <div class="input-group-append">
                           <button
                              type="button"
                              class="btn btn-secondary"
                              onclick="location.href = '<?=base_url('author');?>'"
                           >Reset</button>
                           <?=form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-primary']);?>
                        </div>
                        <?=form_close();?>
                     </div>
                  </div>
                  <?php if ($authors): ?>
                  <div class="double-scroll">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th
                                 scope="col"
                                 class="pl-4"
                              >No</th>
                              <th
                                 scope="col"
                                 style="min-width:200px;"
                              >Nama</th>
                              <th
                                 scope="col"
                                 style="min-width:100px;"
                              >Username</th>
                              <th
                                 scope="col"
                                 style="min-width:100px;"
                              >NIP</th>
                              <th
                                 scope="col"
                                 style="min-width:100px;"
                              >Unit Kerja</th>
                              <th
                                 scope="col"
                                 style="min-width:100px;"
                              >Institusi</th>
                              <th style="min-width:170px;"> &nbsp; </th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($authors as $author): ?>
                           <tr>
                              <td class="align-middle pl-4"><?=++$i;?></td>
                              <td class="align-middle"><a
                                    href="<?=base_url('author/view/profil/' . $author->author_id);?>"
                                 ><?=$author->author_degree_front;?>
                                    <?=ucwords(highlight_keyword($author->author_name, $keywords));?>
                                    <?=$author->author_degree_back;?></a></td>
                              <td class="align-middle">
                                 <?=highlight_keyword($author->username, $keywords);?>
                              </td>
                              <td class="align-middle"> <?=highlight_keyword($author->author_nip, $keywords);?>></td>
                              <td class="align-middle"> <?=highlight_keyword($author->work_unit_name, $keywords);?></td>
                              <td class="align-middle"> <?=highlight_keyword($author->institute_name, $keywords);?></td>
                              <td class="align-middle text-right">

                                 <button
                                    title="Jadikan Reviewer"
                                    onclick="location.href='<?=base_url('author/copyToReviewer/' . $author->user_id . '/' . $author->author_nip . '/' . $author->author_name);?>'"
                                    class="btn btn-sm btn-primary"
                                    <?=(!$author->user_id || $author->is_author_reviewer) ? 'disabled' : '';?>
                                 >
                                    <i class="fa fa-user-plus"></i>
                                    <span class="sr-only">Jadikan reviewer</span>
                                 </button>
                                 <a
                                    title="Edit"
                                    href="<?=base_url('author/edit/' . $author->author_id . '');?>"
                                    class="btn btn-sm btn-secondary"
                                 >
                                    <i class="fa fa-pencil-alt"></i>
                                    <span class="sr-only">Edit</span>
                                 </a>
                                 <button
                                    title="Delete"
                                    type="button"
                                    class="btn btn-sm btn-danger"
                                    data-toggle="modal"
                                    data-target="#modal-hapus-<?=$author->author_id;?>"
                                 ><i class="fa fa-trash-alt"></i><span class="sr-only">Delete</span></button>
                                 <div class="text-left">
                                    <div
                                       class="modal modal-alert fade"
                                       id="modal-hapus-<?=$author->author_id;?>"
                                       tabindex="-1"
                                       role="dialog"
                                       aria-labelledby="modal-hapus"
                                       aria-hidden="true"
                                    >
                                       <div
                                          class="modal-dialog"
                                          role="document"
                                       >
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <h5 class="modal-title">
                                                   <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi
                                                   Hapus</h5>
                                             </div>
                                             <div class="modal-body">
                                                <p>Apakah anda yakin akan menghapus penulis <span
                                                      class="font-weight-bold"
                                                   ><?=$author->author_name;?></span>?</p>
                                             </div>
                                             <div class="modal-footer">
                                                <button
                                                   type="button"
                                                   class="btn btn-danger"
                                                   onclick="location.href='<?=base_url('author/delete/' . $author->author_id . '');?>'"
                                                   data-dismiss="modal"
                                                >Hapus</button>
                                                <button
                                                   type="button"
                                                   class="btn btn-light"
                                                   data-dismiss="modal"
                                                >Close</button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </td>
                           </tr>
                           <?php endforeach;?>
                        </tbody>
                     </table>
                  </div>
                  <?php else: ?>
                  <p class="text-center">Data tidak tersedia</p>
                  <?php endif;?>
                  <?php if ($pagination): ?>
                  <?=$pagination;?>
                  <?php else: ?>
                  &nbsp;
                  <?php endif;?>
               </div>
            </div>
            <footer class="card-footer ">
               <div class="card-footer-content">
                  <a
                     href="<?=base_url('workunit');?>"
                     class="btn btn-secondary mr-2"
                  >Unit Kerja</a>
                  <a
                     href="<?=base_url('institute');?>"
                     class="btn btn-secondary mr-2"
                  >Institusi</a>
               </div>
            </footer>
         </section>
      </div>
   </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
   doublescroll();
});
</script>