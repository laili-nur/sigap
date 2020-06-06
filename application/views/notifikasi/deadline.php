<style type="text/css">
  .belum-dibaca a{
    color: red;
  }
  .highlight a{
    color: #346CB0;
  }
</style>
<?php $ceklevel = $this->session->userdata('level'); ?>
<?php
$perPage = $this->input->get('per_page');
if (empty($perPage)) {
  $perPage = 10;
}
$keywords = $this->input->get('keywords');
$filter = $this->input->get('filter');
if (isset($keywords) or isset($filter)) {
  $page = $this->uri->segment(4);
} else {
  $page = $this->uri->segment(3);
}
  // data table series number
$i = isset($page) ? $page * $perPage - $perPage : 0;
?>
<!-- .page-title-bar -->
<header class="page-title-bar">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a class="text-muted"><span class="fa fa-bell"></span> Notifikasi</a>
      </li>
    </ol>
  </nav>
  <h1 class="page-title"> Deadline</h1>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <!-- grid row -->
  <div class="row">
    <!-- grid column -->
    <div class="col-12">
      <!-- .card -->
      <section class="card card-fluid">
        <!-- .card-header -->
        <header class="card-header">
          <!-- .d-flex -->
          <div class="d-flex">
            <?php if($total>0){ ?>
              <span>Total <span class="badge badge-danger">
                <?= $total ?></span></span>
            <?php } ?>
            <!-- /.card-header-control -->
          </div>
          <!-- /.d-flex -->
        </header>
        <!-- /.card-header -->
        <?php
        /*==================================================
        =            Pilihan dropdown per level            =
        ==================================================*/
        $filter_status = [
            ' ' => '- Filter Notifikasi -',
            'belum dibaca' => ' Belum Dibaca',
            'highlight' => ' Di Highlight',
        ];

        $per_page = [
          '10' => '10',
          '25' => '25',
          '50' => '50',
          '100' => '100',
        ];
        ?>
        <!-- .card-body -->
        <div class="card-body p-0">
          <div class="p-3">
            <?php if($this->input->get('filter') == 'error'): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <p class="m-0">note <em>halaman view</em>.</p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <?php endif ?>
            <div class="row">
              <div class="col-12">
                <?= form_open('notifikasi/searchs_deadline', ['method' => 'GET']) ?>
                <?php $placeholder = 'placeholder="Cari Notifikasi" class="form-control"'; ?>
                <div class="input-group input-group-alt">
                  <?= form_input('keywords', $this->input->get('keywords'), $placeholder) ?>
                  <div class="input-group-append">
                    <?= form_button(['type' => 'submit', 'content' => 'Search', 'class' => 'btn btn-secondary']) ?>
                  </div>
                  <?= form_close() ?>
                </div>
              </div>
            </div>
          </div>
          <!-- .table-responsive -->
          <?php if ($notifikasi):?>
          <div class="double-scroll">
            <!-- .table -->
            <table class="table table-striped">
              <!-- thead -->
              <thead>
                <tr>
                  <th scope="col" class="pl-3">No</th>
                  <th scope="col">Draft Title</th>
                  <th scope="col">Deadline</th>
                  <th scope="col">Remaining</th>                  
                </tr>
              </thead>
              <!-- /thead -->
              <!-- tbody -->
              <tbody>
                <?php foreach($notifikasi as $notif): ?>
                  <?php //mark_read($notif->id); ?>
                <!-- tr -->
                <tr>
                  <td class="align-middle pl-3">
                    <?= ++$i ?>
                  </td>
                  <td class="align-middle">
                    <a href="<?php echo site_url('draft/view/'.$notif->draft_id); ?>"><?php echo $notif->draft_title; ?></a>
                  </td>
                  
                    <?php 
                    if($ceklevel=='reviewer'){
                      $posisi = cek_posisi_reviewer($notif->draft_id);
                      if($posisi==1){
                          echo '<td class="align-middle">'.date('d/m/Y H:i', strtotime($notif->deadline)).'</td>'; 
                          echo '<td class="align-middle">';
                          if($notif->remaining<0){
                              echo '<span class="badge badge-danger">terlambat '.($notif->remaining*-1).' hari</span>';
                          }else if($notif->remaining>0){
                              echo '<span class="badge badge-warning">sisa '.$notif->remaining.' hari</span>' ;
                          }else{
                              echo '<span class="badge badge-warning">hari ini</span>' ;
                          }
                          echo '</td>';
                      }else{
                          echo '<td class="align-middle">'.date('d/m/Y H:i', strtotime($notif->deadline2)).'</td>'; 
                          echo '<td class="align-middle">';
                          if($notif->remaining2<0){
                              echo '<span class="badge badge-danger">terlambat '.($notif->remaining2*-1).' hari</span>';
                          }else if($notif->remaining2>0){
                              echo '<span class="badge badge-warning">sisa '.$notif->remaining2.' hari</span>' ;
                          }else{
                              echo '<span class="badge badge-warning">hari ini</span>' ;
                          }
                          echo '</td>';
                      }
                    }else if($ceklevel=='layouter'){
                      $posisi = cek_posisi_layouter($notif->draft_id);
                      if($posisi==1){
                          echo '<td class="align-middle">'.date('d/m/Y H:i', strtotime($notif->deadline)).'</td>'; 
                          echo '<td class="align-middle">';
                          if($notif->remaining<0){
                              echo '<span class="badge badge-danger">terlambat '.($notif->remaining*-1).' hari</span>';
                          }else if($notif->remaining>0){
                              echo '<span class="badge badge-warning">sisa '.$notif->remaining.' hari</span>' ;
                          }else{
                              echo '<span class="badge badge-warning">hari ini</span>' ;
                          }
                          echo '</td>';
                      }else{
                          echo '<td class="align-middle">'.date('d/m/Y H:i', strtotime($notif->deadline2)).'</td>'; 
                          echo '<td class="align-middle">';
                          if($notif->remaining2<0){
                              echo '<span class="badge badge-danger">terlambat '.($notif->remaining2*-1).' hari</span>';
                          }else if($notif->remaining2>0){
                              echo '<span class="badge badge-warning">sisa '.$notif->remaining2.' hari</span>' ;
                          }else{
                              echo '<span class="badge badge-warning">hari ini</span>' ;
                          }
                          echo '</td>';
                      }
                    }else{
                          echo '<td class="align-middle">'.date('d/m/Y H:i', strtotime($notif->deadline)).'</td>'; 
                          echo '<td class="align-middle">';
                          if($notif->remaining<0){
                              echo '<span class="badge badge-danger">terlambat '.($notif->remaining*-1).' hari</span>';
                          }else if($notif->remaining>0){
                              echo '<span class="badge badge-warning">sisa '.$notif->remaining.' hari</span>' ;
                          }else{
                              echo '<span class="badge badge-warning">hari ini</span>' ;
                          }
                          echo '</td>';
                    }
                    ?>
                  
                </tr>
                <?php endforeach ?>

                <!-- /tr -->
              </tbody>
              <!-- /tbody -->
            </table>
            <!-- /.table -->
          </div>
          <?php else: ?>
          <p class="text-center">Data tidak tersedia</p>
          <?php endif ?>

          
          <!-- /.table-responsive -->
          <!-- Pagination -->
          <?php if ($pagination) : ?>
          <?= $pagination ?>
          <?php else : ?>
          &nbsp;
          <?php endif ?>
          <!-- .pagination -->
        </div>
      </section>
      <!-- /.card -->
    </div>
    <!-- /grid column -->
  </div>
  <!-- /grid row -->
</div>
<!-- /.page-section -->


<script type="text/javascript">
  $(document).ready(function () {
    doublescroll();
    $("#category").select2({
      placeholder: '-- Semua --',
      allowClear: true
    });
    $("#filter").select2({
      placeholder: '-- Filter Progress --',
      allowClear: true
    });
    $("#reprint").select2({
      placeholder: '-- Filter Naskah --',
      allowClear: true
    });
  });
</script>

<?php
function cek_posisi_reviewer($draft_id){
  $CI =& get_instance();
  $query = $CI->db->query("select user_id from draft_reviewer d join reviewer r on d.reviewer_id=r.reviewer_id where draft_id='$draft_id' order by draft_reviewer_id asc");
  $posisi = 1;
  foreach($query->result() as $key => $row){
      if($row->user_id == $_SESSION['user_id']){
        $posisi = $key+1;
      }
  }
  return $posisi;
}
function cek_posisi_layouter($draft_id){
  $CI =& get_instance();
  $query = $CI->db->query("select r.user_id from responsibility r join user u on r.user_id=u.user_id where draft_id='$draft_id' and level='layouter' order by responsibility_id asc");
  $posisi = 1;
  foreach($query->result() as $key => $row){
      if($row->user_id == $_SESSION['user_id']){
        $posisi = $key+1;
      }
  }
  return $posisi;
}
?>