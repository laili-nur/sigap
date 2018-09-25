<?php $ceklevel = $this->session->userdata('level'); ?>
<!-- .page-title-bar -->
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>">Penerbitan</a>
        </li>
                <li class="breadcrumb-item">
          <a href="<?=base_url('draft')?>">Draft</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted"><?= $input->draft_title ?></a>
        </li>
      </ol>
    </nav> 
  </header>
  <!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <div class="d-xl-none">
    <button class="btn btn-danger btn-floated" type="button" data-toggle="sidebar">
      <i class="fa fa-th-list"></i>
    </button>
  </div>
  <!-- .card -->
  <section id="data-draft" class="card">
    
    <!-- .card-header -->
    <header class="card-header">
      <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
          <a class="nav-link active show" data-toggle="tab" href="#data-drafts">Data Draft</a>
        </li>
        <!-- if hilangkan data penulis di reviewer -->
        <?php if($ceklevel != 'reviewer'): ?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#data-penulis">Data Penulis</a>
        </li>
        <!-- endif hilangkan data penulis di reviewer -->
        <?php endif ?>
        <!-- if hilangkan tab data reviewer -->
        <?php if($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
          
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#data-reviewer">Data Reviewer <span><?=(!$reviewers)?'<label class="badge badge-warning">Required</label>':'' ?></span></a>
        </li>
        <!-- endif hilangkan tab data reviewer -->
        <?php endif ?>
      </ul>
    </header>
    <!-- /.card-header -->
    <!-- .card-body -->
    <div class="card-body">
    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
    <!-- .tab-content -->
      <div id="myTabCard" class="tab-content">
        <div class="tab-pane fade active show" id="data-drafts">
          <!-- .table-responsive -->
        <div class="table-responsive">
          <!-- .table -->
          <table class="table table-striped table-bordered mb-0">
            <!-- tbody -->
            <tbody>
              <!-- tr -->
              <tr>
                <td width="200px"> Judul Draft </td>
                <td>: <strong><?= $input->draft_title ?></strong> </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Kategori </td>
                <td>: <?= konversiID('category','category_id', $input->category_id)->category_name;?> </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Tema </td>
                <td>: <?= konversiID('theme','theme_id', $input->theme_id)->theme_name;?> </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> File Draft </td>
                <td>: <?=(!empty($input->draft_file))? '<a href="'.base_url('draftfile/'.$input->draft_file).'">'.$input->draft_file.'</a>' : '' ?>
                   </td>
              </tr>
              <!-- /tr -->
              <?php if($ceklevel != 'reviewer'): ?>
              <!-- tr -->
              <tr>
                <td width="200px"> Dana yang diajukan </td>
                <td>: <?= $input->proposed_fund ?>  </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Dana yang disetujui </td>
                <td>: <?= $input->approved_fund ?>  </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Tanggal Masuk </td>
                <td>: <?= konversiTanggal($input->entry_date) ?>  </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Tanggal Selesai </td>
                <td>: <?= konversiTanggal($input->finish_date) ?>  </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Tanggal Cetak </td>
                <td>: <?= konversiTanggal($input->print_date) ?>  </td>
              </tr>
              <!-- /tr -->
              <!-- tr -->
              <tr>
                <td width="200px"> Status Draft </td>
                <td>: <?= $input->draft_status ?>  </td>
              </tr>
              <!-- /tr -->
              <!-- endif data yang dilihat reviewer -->
            <?php endif ?>
            </tbody>
            <!-- /tbody -->
          </table>
          <!-- /.table -->
        </div>
        <!-- /.table-responsive -->
        </div>
        <div class="tab-pane fade" id="data-penulis">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <div class="form-group">
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#pilihauthor">Pilih Penulis</button>
          </div>
          <?php endif ?>
          <div class="alert alert-success" style="display: none" id="penulisberhasil">Sukses Memilih Penulis</div>
          <div id="reload-author">
          <?php if ($authors):?>
          <?php $i=1; ?>
          <!-- .table-responsive -->
            <div class="table-responsive" >
              <!-- .table -->
              <table class="table table-striped table-bordered mb-0">
                <!-- thead -->
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Nama</th>
                      <th scope="col">NIP</th>
                      <th scope="col">Unit Kerja</th>
                      <th scope="col">Institusi</th>
                      <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                      <th style="width:100px; min-width:100px;"> &nbsp; </th>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($authors as $author): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle"><?= $i++ ?></td>
                    <!-- jika admin maka ada linknya ke profil -->
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <td class="align-middle"><a href="<?= base_url('author/profil/'.$author->author_id) ?>"><?= $author->author_name ?></a></td>
                    <?php else: ?>
                    <td class="align-middle"><?= $author->author_name ?></td>
                    <?php endif ?>
                    <td class="align-middle"><?= $author->author_nip ?></td>
                    <td class="align-middle"><?= $author->work_unit_name ?></td>
                    <td class="align-middle"><?= $author->institute_name ?></td>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <td class="align-middle text-right">
                      <button href="javascript" class="btn btn-sm btn-danger delete-author" data="<?= $author->draft_author_id ?>">
                        <i class="fa fa-trash-alt"></i>
                        <span class="sr-only">Delete</span>
                      </button>
                    </td>
                    <?php endif ?>
                  </tr>
                  <!-- /tr -->

                  <?php endforeach ?>
                </tbody>
                <!-- /tbody -->
              </table>
              <!-- /.table -->
            </div>
            <!-- /.table-responsive -->
          <?php else: ?>
              <p>Author data were not available</p>
          <?php endif ?>
          </div>
        </div>
        <div class="tab-pane fade" id="data-reviewer">
          <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
          <div class="form-group">
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#pilihreviewer">Pilih Reviewer</button>
          </div>
          <?php endif ?>
          <div class="alert alert-success" style="display: none" id="reviewerberhasil">Sukses Memilih Reviewer</div>
          <div id="reload-reviewer">
          <?php if ($reviewers):?>
          <?php $ii=1; ?>
          <!-- .table-responsive -->
            <div class="table-responsive">
              <!-- .table -->
              <table class="table table-striped table-bordered mb-0">
                <!-- thead -->
                        <thead>
                          <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Fakultas</th>
                            <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                            <th style="width:100px; min-width:100px;"> &nbsp; </th>
                            <?php endif ?>
                          </tr>
                        </thead>
                        <!-- /thead -->
                <!-- tbody -->
                <tbody>
                  <?php foreach($reviewers as $reviewer): ?>
                  <!-- tr -->
                  <tr>
                    <td class="align-middle"><?= $ii++ ?></td>
                    <td class="align-middle"><?= $reviewer->reviewer_name ?></td>
                    <td class="align-middle"><?= $reviewer->reviewer_nip ?></td>
                    <td class="align-middle"><?= $reviewer->faculty_name ?></td>
                    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
                    <td class="align-middle text-right">
                      <button href="javascript" class="btn btn-sm btn-danger delete-reviewer" data="<?= $reviewer->draft_reviewer_id ?>">
                        <i class="fa fa-trash-alt"></i>
                        <span class="sr-only">Delete</span>
                      </button>
                    </td>
                  <?php endif ?>
                  </tr>
                  <!-- /tr -->

                  <?php endforeach ?>
                </tbody>
                <!-- /tbody -->
              </table>
              <!-- /.table -->
            </div>
            <!-- /.table-responsive -->
          <?php else: ?>
              <p>Reviewer data were not available</p>
          <?php endif ?>
          </div>
        </div>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->

  <!-- modal penulis -->
  <div class="modal fade" id="pilihauthor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
      <!-- .modal-content -->
      <div class="modal-content">
        <!-- .modal-header -->
        <div class="modal-header">
          <h5 class="modal-title"> PENULIS </h5>
        </div>
        <!-- /.modal-header -->
        <!-- .modal-body -->
        <div class="modal-body">
          <!-- .form -->
          <form>
            <!-- .fieldset -->
            <fieldset>
            <!-- .form-group -->
            <div class="form-group" id="form-author">
              <label for="user_id">Nama Penulis
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('author', getDropdownList('author', ['author_id', 'author_name']), '', 'id="pilih_author" class="form-control custom-select d-block" required') ?>
            </div>
            <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
            <!-- .form-actions -->
        </div>
        <!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
          <button class="btn btn-primary" id="btn-pilih-author" type="submit">Pilih</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>
        <!-- /.modal-footer -->
        </form>
          <!-- /.form -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->

<!-- modal reviewer -->
  <div class="modal fade" id="pilihreviewer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog" role="document">
      <!-- .modal-content -->
      <div class="modal-content">
        <!-- .modal-header -->
        <div class="modal-header">
          <h5 class="modal-title"> REVIEWER </h5>
        </div>
        <!-- /.modal-header -->
        <!-- .modal-body -->
        <div class="modal-body">
          <!-- .form -->
          <form>
            <!-- .fieldset -->
            <fieldset>
            <!-- .form-group -->
            <div class="form-group" id="form-reviewer">
              <label for="user_id">Nama Reviewer
                <abbr title="Required">*</abbr>
              </label>
              <?= form_dropdown('reviewer', getDropdownList('reviewer', ['reviewer_id', 'reviewer_name']), '', 'id="pilih_reviewer" class="form-control custom-select d-block" required') ?>
            </div>
            <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
        </div>
        <!-- /.modal-body -->
        <!-- .modal-footer -->
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit" id="btn-pilih-reviewer">Pilih</button>
          <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        </div>
        <!-- /.modal-footer -->
        <form>
          <!-- /.form -->
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->
<?php if($ceklevel != 'reviewer'): ?>
  <?php $this->load->view('draft/view/desk_screening'); ?>
<?php endif ?>
  
<!-- jika desk screening ditolak, maka progress tidak ditampilkan -->
<?php if ($desk->worksheet_status == 1): ?>
  <?php if($ceklevel != 'reviewer'): ?>
    <!-- panel-progress -->
    <?php $this->load->view('draft/view/progress'); ?>
  <?php endif ?>
  <!-- progress-review -->
  <?php $this->load->view('draft/view/review'); ?>
  <?php if($ceklevel != 'reviewer'): ?>
    <!-- progress-edit -->
    <?php $this->load->view('draft/view/edit'); ?>
    <!-- progress-layout -->
    <?php $this->load->view('draft/view/layout'); ?>
    <!-- progress-proofread -->
    <?php $this->load->view('draft/view/proofread'); ?>
    <!-- if tampilan admin -->
    <?php if($ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
     <div class="el-example">
       <a href="" class="btn btn-primary disabled">Simpan jadi buku</a>
       <a href="" class="btn btn-danger">Tolak</a>
       <button class="btn btn-light" type="submit">Kembali</button>
     </div>
    <!-- endif tampilan admin -->
    <?php endif ?>
  <!-- endif tampilan reviewer -->
 <?php endif ?>
 <!-- endif worksheet status -->
<?php endif ?>
</div>
<!-- /.page-section -->

<script>
  $(document).ready(function() {
    $("#pilih_author").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihauthor'),
      allowClear : true
    });
    $("#pilih_reviewer").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihreviewer'),
      allowClear : true
    });
    $("#pilih_editor").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#piliheditor'),
      allowClear : true
    });
    $("#pilih_layouter").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihlayouter'),
      allowClear : true
    });

    //pilih reviewer
    $('#btn-pilih-author').on('click', function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var author = $('#pilih_author').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('draftauthor/add') ?>",
        datatype : "JSON",
        data : {
          draft_id : draft,
          author_id : author
        },
        success :function(data){
          var datapenulis = JSON.parse(data);
          console.log(datapenulis);
          if(!datapenulis.validasi){
            $('#form-author').append('<div class="text-danger help-block">Penulis sudah dipilih</div>');
          }else{
            $('#pilihauthor').modal('hide');
            $('#penulisberhasil').show(0).delay(2000).hide(0);
          }
          $('[name=author]').val("");
          $('#reload-author').load(' #reload-author');
          $this.removeAttr("disabled").html("Pilih");
        }
      });
      return false;
    });

    //pilih reviewer
    $('#btn-pilih-reviewer').on('click', function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var reviewer = $('#pilih_reviewer').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('draftreviewer/add') ?>",
        datatype : "JSON",
        data : {
          draft_id : draft,
          reviewer_id : reviewer
        },
        success :function(data){
          var datareviewer = JSON.parse(data);
          console.log(datareviewer);
          if(!datareviewer.validasi){
            $('#form-reviewer').append('<div class="text-danger help-block">reviewer sudah dipilih</div>');
          }else{
            $('#pilihreviewer').modal('hide');
            $('#reviewerberhasil').show(0).delay(2000).hide(0);
          }
          $('[name=reviewer]').val("");
          $('#reload-reviewer').load(' #reload-reviewer');
          $this.removeAttr("disabled").html("Pilih");
        }
      });
      return false;
    });

    //pilih editor
    $('#btn-pilih-editor').on('click',function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var editor = $('#pilih_editor').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('responsibility/add') ?>",
        datatype : "JSON",
        data : {
          draft_id : draft,
          user_id : editor
        },
        success :function(data){
          var dataeditor = JSON.parse(data);
          console.log(dataeditor);
          if(!dataeditor.validasi){
            $('#form-editor').append('<div class="text-danger help-block">editor sudah dipilih</div>');
          }
          $('[name=editor]').val("");
          $('#reload-editor').load(' #reload-editor');
          //lambat $('#label-editor').load(' #label-editor');
          $this.removeAttr("disabled").html("Pilih");
        }

      });
      return false;

    });

    //pilih layouter
    $('#btn-pilih-layouter').on('click',function(){
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var layouter = $('#pilih_layouter').val();
      $.ajax({
        type : "POST",
        url : "<?php echo base_url('responsibility/add') ?>",
        datatype : "JSON",
        data : {
          draft_id : draft,
          user_id : layouter
        },
        success :function(data){
          var datalayouter = JSON.parse(data);
          console.log(datalayouter);
          if(!datalayouter.validasi){
            $('#form-layouter').append('<div class="text-danger help-block">layouter sudah dipilih</div>');
          }
          $('[name=layouter]').val("");
          $('#reload-layouter').load(' #reload-layouter');
          //lambat $('#label-layouter').load(' #label-layouter');
          $this.removeAttr("disabled").html("Pilih");
        }

      });
      return false;

    });


    //hapus penulis
    $('#data-penulis').on('click','.delete-author',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('draftauthor/delete/') ?>"+id,
          success : function(data){
            $('#reload-author').load(' #reload-author');
          }

        })
    });

    // hapus reviewer
    $('#data-reviewer').on('click','.delete-reviewer',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('draftreviewer/delete/') ?>"+id,
          success : function(data){
            $('#reload-reviewer').load(' #reload-reviewer');
          }

        })
    });

    //hapus editor
    $('#reload-editor').on('click','.delete-editor',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('responsibility/delete/') ?>"+id,
          success : function(data){
            console.log(data);
            $('#reload-editor').load(' #reload-editor');
            //lambat $('#label-editor').load(' #label-editor');
          }

        })
    });

    //hapus layouter
    $('#reload-layouter').on('click','.delete-layouter',function(){
        $(this).attr('disabled','disabled').html("<i class='fa fa-spinner fa-spin '></i>");
        var id=$(this).attr('data');
        console.log(id);
        $.ajax({
          url : "<?php echo base_url('responsibility/delete/') ?>"+id,
          success : function(data){
            console.log(data);
            $('#reload-layouter').load(' #reload-layouter');
            //lambat $('#label-editor').load(' #label-editor');
          }

        })
    });

  
  });
</script>



