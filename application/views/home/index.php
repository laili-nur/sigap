<?php
$username = $this->session->userdata('username');
$is_login = $this->session->userdata('is_login');
$ceklevel = $this->session->userdata('level');
$cekrole  = $this->session->userdata('role_id');
$semua    = $this->session->userdata();
?>
<!-- .page-title-bar -->
<header class="page-title-bar">
   <!-- <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item active"><a class="text-muted"><span class="fa fa-home"></span> Admin Panel</a></li></ol></nav> -->
   <h1 class="page-title"> Dashboard </h1>
   <p class="lead">
      <span class="font-weight-bold">Halo, <?=$username;?></span>
      <span class="d-block text-muted">
         <?=(!empty($tulisan_dashboard->dashboard_head)) ? $tulisan_dashboard->dashboard_head : '';?>
      </span>
      <?php
if ($ceklevel == 'author') {
    if (!empty($tulisan_dashboard->dashboard_content_author) or $tulisan_dashboard->dashboard_content_author == '<p><br></p>') {
        echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_author . '</div>';
    }
} elseif ($ceklevel == 'reviewer') {
    if (!empty($tulisan_dashboard->dashboard_content_reviewer) or $tulisan_dashboard->dashboard_content_reviewer == '<p><br></p>') {
        echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_reviewer . '</div>';
    }
} elseif ($ceklevel == 'layouter') {
    if (!empty($tulisan_dashboard->dashboard_content_layouter) or $tulisan_dashboard->dashboard_content_layouter == '<p><br></p>') {
        echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_layouter . '</div>';
    }
} elseif ($ceklevel == 'editor') {
    if (!empty($tulisan_dashboard->dashboard_content_editor) or $tulisan_dashboard->dashboard_content_editor == '<p><br></p>') {
        echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_editor . '</div>';
    }
}
?>
   </p>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
   <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
   <div class="section-block">
      <!-- metric row -->
      <div class="metric-row">
         <div class="col-12">
            <div class="metric-row metric-flush">
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
              <?=base_url('category');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label"> Total Kategori </h2>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-list-alt"></i>
                        </sub>
                        <span class="value">
                           <?=$count['tot_category'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
              <?=base_url('draft');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label"> Total Draft Masuk </h2>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-paperclip"></i>
                        </sub>
                        <span class="value">
                           <?=$count['tot_draft'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
              <?=base_url('book');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label"> Total Buku </h2>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-book"></i>
                        </sub>
                        <span class="value">
                           <?=$count['tot_book'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
              <?=base_url('author');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label"> Total Penulis </h2>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-users"></i>
                        </sub>
                        <span class="value">
                           <?=$count['tot_author'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
              <?=base_url('reviewer');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label"> Total Reviewer </h2>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-university"></i>
                        </sub>
                        <span class="value">
                           <?=$count['tot_reviewer'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
            </div>
         </div>
      </div>
      <!-- /metric row -->
   </div>
   <!-- .section-block -->
   <div class="section-block card px-4 pt-3">
      <h4 class="card-title m-0 p-0"> Ringkasan Draft </h4>
      <hr>
      <small class="text-muted">Data dibawah ini merupakan jumlah keseluruhan draft sampai saat ini.</small>
      <!-- metric row -->
      <div class="metric-row">
         <div class="col-12">
            <div class="metric-row metric-flush">
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="<?=base_url('draft/filter?filter=desk-screening');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <div class="metric-badge">
                        <span class="badge badge-lg badge-secondary">
                           <span class="oi oi-media-record pulse mr-1"></span> DESK SCREENING
                        </span>
                     </div>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-tasks"></i>
                        </sub>
                        <span class="value">
                           <?=$count['draft_desk'];?>
                        </span>
                        <!-- <span href="#" onclick="event.preventDefault()" class="font-weight-bold info-home" data-toggle="tooltip" data-html="true"  data-placement="left" title="Sedang Desk Screening = <?=$count['draft_desk'];?><br>Lolos Desk Screening = <?=$count['draft_desk_lolos'];?>" ><i class="fa fa-info-circle"></i></span> -->
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
                <?=base_url('draft/filter?filter=review');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <div class="metric-badge">
                        <span class="badge badge-lg badge-success">
                           <span class="oi oi-media-record pulse mr-1"></span> REVIEW
                        </span>
                     </div>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-tasks"></i>
                        </sub>
                        <span class="value">
                           <?=$count['draft_review'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
                <?=base_url('draft/filter?filter=edit');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <div class="metric-badge">
                        <span class="badge badge-lg badge-danger">
                           <span class="oi oi-media-record pulse mr-1"></span> EDITORIAL
                        </span>
                     </div>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-tasks"></i>
                        </sub>
                        <span class="value">
                           <?=$count['draft_edit'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
                <?=base_url('draft/filter?filter=layout');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <div class="metric-badge">
                        <span class="badge badge-lg badge-warning">
                           <span class="oi oi-media-record pulse mr-1"></span> LAYOUT
                        </span>
                     </div>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-tasks"></i>
                        </sub>
                        <span class="value">
                           <?=$count['draft_layout'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
                <?=base_url('draft/filter?filter=proofread');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <div class="metric-badge">
                        <span class="badge badge-lg badge-info">
                           <span class="oi oi-media-record pulse mr-1"></span> PROOFREAD
                        </span>
                     </div>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-tasks"></i>
                        </sub>
                        <span class="value">
                           <?=$count['draft_proofread'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
                <?=base_url('draft/filter?filter=cetak');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <div class="metric-badge">
                        <span class="badge badge-lg badge-dark">
                           <span class="oi oi-media-record pulse mr-1"></span> CETAK
                        </span>
                     </div>
                     <p class="metric-value h3">
                        <sub>
                           <i class="fa fa-tasks"></i>
                        </sub>
                        <span class="value">
                           <?=$count['draft_cetak'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
            </div>
         </div>
      </div>
      <!-- /metric row -->
      <!-- metric row -->
      <div class="metric-row">
         <div class="col-12">
            <div class="metric-row metric-flush">
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <div class="metric metric-bordered align-items-center">
                     <a
                        href="<?=base_url('draft/filter?filter=final');?>"
                        class="metric-label"
                     >
                        <i class="fa fa-check"></i> Draft final
                     </a>
                     <p class="metric-value h3">
                        <span class="value">
                           <?=$count['draft_final'];?>
                        </span>
                        <a
                           href="#"
                           onclick="event.preventDefault()"
                           class="font-weight-bold info-home"
                           data-toggle="tooltip"
                           data-html="true"
                           data-placement="left"
                           title="Draft yang sudah selesai proses"
                        ><i class="fa fa-info-circle"></i></a>
                     </p>
                  </div>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <div class="metric metric-bordered align-items-center">
                     <a
                        href="<?=base_url('draft/filter?filter=cetak-ulang');?>"
                        class="metric-label"
                     >
                        <i class="fa fa-redo"></i> Draft Cetak Ulang
                     </a>
                     <p class="metric-value h3">
                        <span class="value">
                           <?=$count['draft_cetak_ulang'];?>
                        </span>
                        <a
                           href="#"
                           onclick="event.preventDefault()"
                           class="font-weight-bold info-home"
                           data-toggle="tooltip"
                           data-html="true"
                           data-placement="left"
                           title="Draft final yang di cetak ulang"
                        ><i class="fa fa-info-circle"></i></a>
                     </p>
                  </div>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <div class="metric metric-bordered align-items-center">
                     <a
                        href="<?=base_url('draft/filter?filter=reject');?>"
                        class="metric-label"
                     >
                        <i class="fa fa-times"></i> Draft ditolak
                     </a>
                     <p class="metric-value">
                        <span class="value h3">
                           <?=$count['draft_rejected_total'];?>
                        </span>
                        <a
                           href="#"
                           onclick="event.preventDefault()"
                           class="font-weight-bold info-home"
                           data-toggle="tooltip"
                           data-placement="left"
                           title="Draft yang ditolak pada tahap desk screening dan tahap selanjutnya"
                        ><i class="fa fa-info-circle"></i></a>
                     </p>
                  </div>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
            </div>
         </div>
      </div>
      <!-- /metric row -->
   </div>
   <!-- /.section-block -->
   <?php endif;?>
   <!-- untuk level reviewer -->
   <?php if ($ceklevel == 'reviewer'): ?>
   <!-- .section-block -->
   <div class="section-block">
      <!-- .section-card -->
      <div class="card">
         <!-- metric row -->
         <div class="metric-row px-4 pt-3">
            <div class="col-12">
               <div class="metric-row metric-flush">
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-info">
                              <span class="oi oi-media-record pulse mr-1"></span> TOTAL REVIEW
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['count_total'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=sudah');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-success">
                              <span class="oi oi-media-record pulse mr-1"></span> SUDAH DIREVIEW
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['count_sudah'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=belum');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-danger">
                              <span class="oi oi-media-record pulse mr-1"></span> BELUM DIREVIEW
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['count_belum'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
               </div>
            </div>
         </div>
         <!-- /metric row -->
      </div>
      <!-- /.section-card -->
      <!-- grid row -->
      <div class="row">
         <!-- grid column -->
         <div class="col-12">
            <!-- .card -->
            <section class="card card-fluid">
               <!-- .card-header -->
               <header class="card-header">
                  <!-- .d-flex -->
                  <div class="d-flex align-items-center">
                     <span class="mr-auto">Draft Terbaru Untuk Direview</span>
                  </div>
                  <!-- /.d-flex -->
               </header>
               <!-- /.card-header -->
               <!-- .table-responsive -->
               <?php if ($drafts_newest): ?>
               <div class="table-responsive table-striped">
                  <!-- .table -->
                  <table class="table nowrap">
                     <!-- thead -->
                     <thead>
                        <tr>
                           <th scope="col">Judul</th>
                           <th scope="col">Tanggal masuk</th>
                           <th scope="col">Deadline Review</th>
                           <th scope="col">Sisa Waktu</th>
                           <th scope="col">Aksi</th>
                        </tr>
                     </thead>
                     <!-- /thead -->
                     <!-- tbody -->
                     <tbody>
                        <?php foreach ($drafts_newest as $draft): ?>
                        <?php if ($draft->flag == ''): ?>
                        <!-- tr -->
                        <tr>
                           <td class="align-middle">
                              <?=$draft->draft_title;?>
                           </td>
                           <td class="align-middle">
                              <?=$draft->entry_date;?>
                           </td>
                           <td class="align-middle">
                              <?=$draft->deadline;?>
                           </td>
                           <td class="align-middle">
                              <?php
$sisa_waktu = round((strtotime($draft->deadline) - strtotime(date('Y-m-d H:i:s'))) / 86400);
if ($sisa_waktu <= 0) {
    echo '
                      <span class="font-weight-bold" style="color:red">Melebihi Deadline!</span>';
} else {
    echo $sisa_waktu . ' hari';
}
?>
                           </td>
                           <td class="align-middle">
                              <a
                                 href="
                        <?=base_url('draft/view/' . $draft->draft_id . '');?>"
                                 class="btn btn-sm btn-secondary"
                              >
                                 <i class="fa fa-eye"></i> View

                                 <span class="sr-only">View</span>
                              </a>
                           </td>
                        </tr>
                        <!-- /tr -->
                        <?php endif;?>
                        <?php endforeach;?>
                     </tbody>
                     <!-- /tbody -->
                  </table>
                  <!-- /.table -->
               </div>
               <?php else: ?>
               <p class="text-center my-4">Data tidak tersedia</p>
               <?php endif;?>
               <!-- /.table-responsive -->
               <!-- .card-footer -->
               <footer class="card-footer">
                  <a
                     href="
                <?=base_url('draft');?>"
                     class="card-footer-item"
                  >Lihat selengkapnya

                     <i class="fa fa-fw fa-angle-right"></i>
                  </a>
               </footer>
               <!-- /.card-footer -->
            </section>
            <!-- /.card -->
         </div>
         <!-- /grid column -->
      </div>
      <!-- /grid row -->
   </div>
   <!-- /.section-block -->
   <?php endif;?>
   <!-- untuk level author -->
   <?php if ($ceklevel == 'author'): ?>
   <!-- .section-block -->
   <div class="section-block">
      <!-- metric row -->
      <div class="metric-row">
         <div class="col-12">
            <div class="metric-row metric-flush">
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="
                <?=base_url('category');?>"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label">
                        <i class="fa fa-paperclip"></i> Total Draft
                     </h2>
                     <p class="metric-value h3">
                        <span class="value">
                           <?=$count['draft_total'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="#"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label">
                        <i class="fa fa-check"></i> Draft disetujui
                     </h2>
                     <p class="metric-value h3">
                        <span class="value">
                           <?=$count['draft_approved'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="#"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label">
                        <i class="fa fa-times"></i> Draft ditolak
                     </h2>
                     <p class="metric-value h3">
                        <span class="value">
                           <?=$count['draft_rejected'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
               <!-- metric column -->
               <div class="col">
                  <!-- .metric -->
                  <a
                     href="#"
                     class="metric metric-bordered align-items-center"
                  >
                     <h2 class="metric-label">
                        <i class="fa fa-book"></i> Total Buku
                     </h2>
                     <p class="metric-value h3">
                        <span class="value">
                           <?=$count['draft_book'];?>
                        </span>
                     </p>
                  </a>
                  <!-- /.metric -->
               </div>
               <!-- /metric column -->
            </div>
         </div>
      </div>
      <!-- /metric row -->
      <!-- .section-card -->
      <div class="card">
         <!-- .card-header -->
         <header class="card-header">
            <!-- .d-flex -->
            <div class="d-flex align-items-center">
               <span class="mr-auto">Progress Draft</span>
            </div>
            <!-- /.d-flex -->
         </header>
         <!-- /.card-header -->
         <!-- metric row -->
         <div class="metric-row px-4 pt-3">
            <div class="col-12">
               <div class="metric-row metric-flush">
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=desk-screening');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-secondary">
                              <span class="oi oi-media-record pulse mr-1"></span> DESK SCREENING
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_desk'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=review');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-success">
                              <span class="oi oi-media-record pulse mr-1"></span> REVIEW
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_review'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=edit');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-danger">
                              <span class="oi oi-media-record pulse mr-1"></span> EDITORIAL
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_edit'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=layout');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-warning">
                              <span class="oi oi-media-record pulse mr-1"></span> LAYOUT
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_layout'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=proofread');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-info">
                              <span class="oi oi-media-record pulse mr-1"></span> PROOFREAD
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_proofread'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
               </div>
            </div>
         </div>
         <!-- /metric row -->
      </div>
      <!-- /.section-card -->
      <!-- grid row -->
      <div class="row">
         <!-- grid column -->
         <div class="col-12">
            <!-- .card -->
            <section class="card card-fluid">
               <!-- .card-header -->
               <header class="card-header">
                  <!-- .d-flex -->
                  <div class="d-flex align-items-center">
                     <span class="mr-auto">Kategori Hibah Baru</span>
                  </div>
                  <!-- /.d-flex -->
               </header>
               <!-- /.card-header -->
               <?php if ($cekrole == 0): ?>
               <div class="alert alert-warning m-3">
                  <strong>Penulis belum didaftarkan</strong><br>
                  Untuk mengusulkan kategori, penulis perlu didaftarkan oleh admin
               </div>
               <?php else: ?>
               <?php if ($categories): ?>
               <!-- .table-responsive -->
               <div class="table-responsive table-striped">
                  <!-- .table -->
                  <table class="table">
                     <!-- thead -->
                     <thead>
                        <tr>
                           <th
                              scope="col"
                              style="min-width: 150px;max-width: 150px"
                           >Kategori</th>
                           <th
                              scope="col"
                              style="min-width: 250px;max-width: 400px"
                           >Keterangan</th>
                           <th
                              scope="col"
                              style="min-width: 120px;max-width: 150px"
                           >Tanggal Buka</th>
                           <th
                              scope="col"
                              style="min-width: 100px;max-width: 100px"
                           >Sisa Waktu Buka</th>
                           <th
                              scope="col"
                              style="min-width: 120px;max-width: 150px"
                           >Tanggal Tutup</th>
                           <th
                              scope="col"
                              style="min-width: 100px;max-width: 100px"
                           >Sisa Waktu Tutup</th>
                           <th scope="col">Aksi</th>
                        </tr>
                     </thead>
                     <!-- /thead -->
                     <!-- tbody -->
                     <tbody>
                        <?php foreach ($categories as $category): ?>
                        <!-- tr -->
                        <tr>
                           <td class="align-middle">
                              <?=$category->category_name;?>
                           </td>
                           <td class="align-middle">
                              <?=$category->category_note;?>
                           </td>
                           <td class="align-middle">
                              <?=konversiTanggal($category->date_open, 'dateonly');?>
                           </td>
                           <td class="align-middle">
                              <?php
$sisa_waktu_buka = ceil((strtotime($category->date_open) - strtotime(date('Y-m-d H:i:s'))) / 86400);
if ($sisa_waktu_buka >= 1) {
    echo $sisa_waktu_buka . ' hari';
} else {
    echo '<span style="color:green">Sudah dibuka</span>';
}
?>
                           </td>

                           <td class="align-middle">
                              <?=konversiTanggal($category->date_close, 'dateonly');?>
                           </td>
                           <td class="align-middle">

                              <?php $range_open_now = ceil((strtotime($category->date_open) - strtotime(date('Y-m-d H:i:s'))) / 86400);?>

                              <?php
$sisa_waktu = ceil((strtotime($category->date_close) - strtotime(date('Y-m-d H:i:s'))) / 86400);
if ($range_open_now <= 0) {
    if ($sisa_waktu <= 0) {
        echo '<span style="color:red">Berakhir</span>';
    } else {
        echo $sisa_waktu . ' hari';
    }
} else {
    echo '<span style="color:#F7C46C">Belum dibuka</span>';
}
?>
                           </td>
                           <td class="align-middle">

                              <?php if ($category->category_status == 'y' and $range_open_now <= 0): ?>
                              <button
                                 class="btn btn-success btn-xs"
                                 onclick="location.href='<?=base_url('draft/add/' . $category->category_id);?>'"
                              >Daftar</button>
                              <?php else: ?>
                              <button
                                 type="button"
                                 class="btn btn-success btn-xs disabled"
                                 disabled=""
                                 style="cursor:not-allowed"
                              >Daftar</button>
                              <?php endif;?>
                           </td>
                        </tr>
                        <!-- /tr -->
                        <?php endforeach;?>
                     </tbody>
                     <!-- /tbody -->
                  </table>
                  <!-- /.table -->
               </div>
               <?php else: ?>
               <p class="text-center my-4">Data tidak tersedia</p>
               <?php endif;?>
               <!-- /.table-responsive -->
               <?php endif;?>
            </section>
            <!-- /.card -->
         </div>
         <!-- /grid column -->
      </div>
      <!-- /grid row -->
   </div>
   <!-- /.section-block -->
   <?php endif;?>
   <!-- untuk level editor -->
   <?php if ($ceklevel == 'editor'): ?>
   <!-- .section-block -->
   <div class="section-block">
      <!-- .section-card -->
      <div class="card">
         <!-- metric row -->
         <div class="metric-row px-4 pt-3">
            <div class="col-12">
               <div class="metric-row metric-flush">
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-info">
                              <span class="oi oi-media-record pulse mr-1"></span> TOTAL DRAFT
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_total'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('worksheet/filter?filter=waiting');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-secondary">
                              <span class="oi oi-media-record pulse mr-1"></span> MENUNGGU DESK SCREENING
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_desk'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=sudah');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-success">
                              <span class="oi oi-media-record pulse mr-1"></span> SUDAH DIPROSES
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_sudah'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=belum');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-danger">
                              <span class="oi oi-media-record pulse mr-1"></span> BELUM DIPROSES
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_belum'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
               </div>
            </div>
         </div>
         <!-- /metric row -->
         <!-- metric row -->
         <div class="metric-row px-4">
            <div class="col-12">
               <div class="metric-row metric-flush">
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                <?=base_url('draft/filter?filter=approve');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <h2 class="metric-label">
                           <i class="fa fa-check"></i> Edit Disetujui
                        </h2>
                        <p class="metric-value h3">
                           <span class="value">
                              <?=$count['draft_approved'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                <?=base_url('draft/filter?filter=reject');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <h2 class="metric-label">
                           <i class="fa fa-times"></i> Edit Ditolak
                        </h2>
                        <p class="metric-value h3">
                           <span class="value">
                              <?=$count['draft_rejected'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
               </div>
            </div>
         </div>
         <!-- /metric row -->
      </div>
      <!-- /.section-card -->
   </div>
   <!-- /.section-block -->
   <?php endif;?>
   <!-- untuk level layouter -->
   <?php if ($ceklevel == 'layouter'): ?>
   <!-- .section-block -->
   <div class="section-block">
      <!-- .section-card -->
      <div class="card">
         <!-- metric row -->
         <div class="metric-row px-4 pt-3">
            <div class="col-12">
               <div class="metric-row metric-flush">
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-info">
                              <span class="oi oi-media-record pulse mr-1"></span> TOTAL DRAFT
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_total'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('worksheet');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-secondary">
                              <span class="oi oi-media-record pulse mr-1"></span> MENUNGGU DESK SCREENING
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_desk'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=sudah');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-success">
                              <span class="oi oi-media-record pulse mr-1"></span> SUDAH DIPROSES
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_sudah'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                    <?=base_url('draft/filter?filter=belum');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <div class="metric-badge">
                           <span class="badge badge-lg badge-danger">
                              <span class="oi oi-media-record pulse mr-1"></span> BELUM DIPROSES
                           </span>
                        </div>
                        <p class="metric-value h3">
                           <sub>
                              <i class="fa fa-tasks"></i>
                           </sub>
                           <span class="value">
                              <?=$count['draft_belum'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
               </div>
            </div>
         </div>
         <!-- /metric row -->
         <!-- metric row -->
         <div class="metric-row px-4">
            <div class="col-12">
               <div class="metric-row metric-flush">
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                <?=base_url('draft/filter?filter=approve');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <h2 class="metric-label">
                           <i class="fa fa-check"></i> Layout Disetujui
                        </h2>
                        <p class="metric-value h3">
                           <span class="value">
                              <?=$count['draft_approved'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
                  <!-- metric column -->
                  <div class="col">
                     <!-- .metric -->
                     <a
                        href="
                <?=base_url('draft/filter?filter=reject');?>"
                        class="metric metric-bordered align-items-center"
                     >
                        <h2 class="metric-label">
                           <i class="fa fa-times"></i> Layout Ditolak
                        </h2>
                        <p class="metric-value h3">
                           <span class="value">
                              <?=$count['draft_rejected'];?>
                           </span>
                        </p>
                     </a>
                     <!-- /.metric -->
                  </div>
                  <!-- /metric column -->
               </div>
            </div>
         </div>
         <!-- /metric row -->
      </div>
      <!-- /.section-card -->
   </div>
   <!-- /.section-block -->
   <?php endif;?>
</div>
<!-- /.page-section -->