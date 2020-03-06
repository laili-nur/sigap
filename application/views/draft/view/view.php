<?php $level = check_level();?>
<header class="page-title-bar">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item">
            <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
         </li>
         <li class="breadcrumb-item">
            <a href="<?=base_url('draft');?>">Draft</a>
         </li>
         <li class="breadcrumb-item">
            <a class="text-muted">
               <?=$input->draft_title;?></a>
         </li>
      </ol>
   </nav>
</header>
<?php echo '<pre>';
print_r($reviewer_order);
echo '</pre>'; ?>
<div class="page-section">
   <!-- segment detail draft, penulis, reviewer, buku -->
   <?php $this->load->view('draft/view/detail');?>
   <?php if ($level != 'reviewer'): ?>
   <?php $this->load->view('draft/view/desk_screening');?>
   <?php endif;?>

   <?php if ($desk->worksheet_status == 1): ?>

   <?php if ($level != 'reviewer'): ?>
   <?php $this->load->view('draft/view/progress');?>
   <?php endif;?>

   <?php if ($level == 'author' and $author_order != 1): ?>
   <div class="alert alert-danger"><strong>PERHATIAN! </strong>Hanya penulis pertama yang dapat memberikan komentar dan
      catatan, penulis kedua hanya dapat melihat progress.</div>
   <?php endif;?>

   <?php if ($reviewers == null): ?>
   <?php if ($level == 'superadmin'): ?>
   <div class="alert alert-warning">
      <strong>PERHATIAN!</strong> Pilih reviewer terlebih dahulu sebelum lanjut ke tahap selanjutnya. Apabila progress
      belum terbuka maka lakukan reload
      <p class="m-0 p-0 mt-2">
         <button
            class="btn btn-warning btn-xs"
            type="button"
            id="pil-rev"
         ><i class="fa fa-user-graduate"></i> Pilih reviewer</button>
         <button
            class="btn btn-warning btn-xs"
            type="button"
            onClick="window.location.reload()"
         ><i class="fa fa-sync"></i> Reload</button>
      </p>
   </div>
   <?php else: ?>
   <div class="alert alert-info">
      <h5 class="alert-heading">Pencarian Reviewer</h5>
      Mohon ditunggu, Pihak admin sedang melakukan pencarian reviewer yang sesuai dengan draft anda.
   </div>
   <?php endif;?>
   <?php else: ?>
   <?php $this->load->view('draft/view/review');?>
   <?php endif;?>

   <?php if ($level != 'reviewer'): ?>
   <?php if ($input->is_review == 'y'): ?>
   <?php $this->load->view('draft/view/edit');?>
   <?php endif;?>
   <?php if ($input->is_edit == 'y'): ?>
   <?php $this->load->view('draft/view/layout');?>
   <?php endif;?>
   <?php if ($input->is_layout == 'y'): ?>
   <?php $this->load->view('draft/view/proofread');?>
   <?php endif;?>
   <?php if ($input->is_proofread == 'y' and $level != 'author' and $level != 'reviewer'): ?>
   <?php $this->load->view('draft/view/print');?>
   <?php elseif ($input->is_proofread == 'y' and $input->is_print == 'n' and $level == 'author' or $level == 'reviewer'): ?>
   <div class="alert alert-info">
      <h5 class="alert-heading">Proses Cetak</h5>
      Draft ini sedang dalam proses pencetakan.
   </div>
   <?php elseif ($input->is_print == 'y' and $input->draft_status != 14 and $level == 'author' or $level == 'reviewer'): ?>
   <div class="alert alert-info">
      <h5 class="alert-heading">Proses Final</h5>
      Draft ini sedang dalam proses finalisasi.
   </div>
   <?php endif;?>
   <?php if ($level == 'superadmin' or $level == 'admin_penerbitan'): ?>
   <div class="el-example mx-3 mx-md-0">
      <?php
$hidden_date = array(
    'type'  => 'hidden',
    'id'    => 'finish_date',
    'value' => date('Y-m-d H:i:s'),
);
echo form_input($hidden_date);?>
      <?=($input->is_print == 'y') ? '' : '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Proses cetak belum disetujui</small></div>';?>
      <?=($input->print_file != '' or $input->print_file_link != '') ? '' : '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> File/Link cetak belum ada</small></div>';?>
      <button
         class="btn btn-primary"
         data-toggle="modal"
         data-target="#modalsimpan"
         <?=($input->is_print == 'y' and ($input->print_file != '' or $input->print_file_link != '')) ? '' : 'disabled';?>
      >Simpan jadi buku</button>
      <button
         class="btn btn-danger"
         data-toggle="modal"
         data-target="#modaltolak"
         <?=($input->is_print == 'y' and ($input->print_file != '' or $input->print_file_link != '')) ? '' : 'disabled';?>
      >Tolak</button>
   </div>
   <div
      class="modal modal-warning fade"
      id="modalsimpan"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modalsimpan"
      aria-hidden="true"
   >
      <div
         class="modal-dialog"
         role="document"
      >
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <i class="fa fa-bullhorn text-yellow mr-1"></i> Konfirmasi Draft Final
               </h5>
            </div>
            <div class="modal-body">
               <p>Draft <span class="font-weight-bold">
                     <?=$input->draft_title;?></span> sudah final dan akan disimpan jadi buku?</p>
               <div class="alert alert-warning">Tanggal selesai draft akan tercatat ketika klik Submit</div>
            </div>
            <div class="modal-footer">
               <button
                  class="btn btn-primary"
                  id="draft-setuju"
                  draft-title="<?=$draft->draft_title;?>"
                  draft-file="<?=$draft->print_file;?>"
                  value="14"
               >Submit</button>
               <button
                  type="button"
                  class="btn btn-light"
                  data-dismiss="modal"
               >Close</button>
            </div>
         </div>
      </div>
   </div>
   <div
      class="modal modal-alert fade"
      id="modaltolak"
      tabindex="-1"
      role="dialog"
      aria-labelledby="modaltolak"
      aria-hidden="true"
   >
      <div
         class="modal-dialog"
         role="document"
      >
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <i class="fa fa-exclamation-triangle text-red mr-1"></i> Tolak Draft
               </h5>
            </div>
            <div class="modal-body">
               <p>Draft <span class="font-weight-bold">
                     <?=$input->draft_title;?></span> ditolak?</p>
            </div>
            <div class="modal-footer">
               <button
                  class="btn btn-danger"
                  type="submit"
                  id="draft-tolak"
                  value="99"
               >Tolak</button>
               <button
                  type="button"
                  class="btn btn-light"
                  data-dismiss="modal"
               >Close</button>
            </div>
         </div>
      </div>
   </div>
   <?php endif;?>
   <?php endif;?>

   <?php endif;?>
</div>
<script>
$(document).ready(function() {
   $('#entry_date').flatpickr({
      disableMobile: true,
      altInput: true,
      altFormat: 'j F Y',
      dateFormat: 'Y-m-d',
      inline: true
   });

   //scroll to top dan ganti tab
   function activaTab(tab) {
      $('.nav-tabs.card-header-tabs a[href="#' + tab + '"]').tab('show');
   };
   $('#pil-rev').click(function() {
      $('html, body').animate({
         scrollTop: 1
      }, 400);
      setTimeout(function() {
         activaTab('data-reviewer');
      }, 500);
      return false;
   });


   $("#pilih_author").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihauthor'),
      allowClear: true
   });
   $("#pilih_reviewer").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihreviewer'),
      allowClear: true
   });
   $("#pilih_editor").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#piliheditor'),
      allowClear: true
   });
   $("#pilih_layouter").select2({
      placeholder: '-- Pilih --',
      dropdownParent: $('#pilihlayouter'),
      allowClear: true
   });

   //pilih reviewer
   $('#btn-pilih-author').on('click', function() {
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var author = $('#pilih_author').val();
      $.ajax({
         type: "POST",
         url: "<?php echo base_url('draftauthor/add'); ?>",
         datatype: "JSON",
         data: {
            draft_id: draft,
            author_id: author
         },
         success: function(data) {
            var datapenulis = JSON.parse(data);
            console.log(datapenulis);
            if (!datapenulis.validasi) {
               $('#form-author').append(
                  '<div class="text-danger help-block">Penulis sudah dipilih</div>');
               toastr_view('11');
            } else {
               $('#pilihauthor').modal('hide');
               toastr_view('1');
            }
            $('[name=author]').val("");
            $('#reload-author').load(' #reload-author');
            $this.removeAttr("disabled").html("Pilih");
         }
      });
      return false;
   });

   //pilih reviewer
   $('#btn-pilih-reviewer').on('click', function() {
      $('.help-block').remove();
      var $this = $(this);
      $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      var draft = $('input[name=draft_id]').val();
      var reviewer = $('#pilih_reviewer').val();
      $.ajax({
         type: "POST",
         url: "<?php echo base_url('draftreviewer/add'); ?>",
         datatype: "JSON",
         data: {
            draft_id: draft,
            reviewer_id: reviewer
         },
         success: function(data) {
            var datareviewer = JSON.parse(data);
            console.log(datareviewer);
            if (!datareviewer.validasi) {
               $('#form-reviewer').append(
                  '<div class="text-danger help-block">reviewer sudah dipilih</div>');
               toastr_view('22');
            } else if (datareviewer.validasi == 'max') {
               toastr_view('99');
            } else {
               $('#pilihreviewer').modal('hide');
               toastr_view('3');
            }
            $('[name=reviewer]').val("");
            $('#reload-reviewer').load(' #reload-reviewer');
            //$('#list-group-review').load(' #list-group-review');
            $this.removeAttr("disabled").html("Pilih");
         }
      });
      return false;
   });


   //hapus penulis
   $('#data-penulis').on('click', '.delete-author', function() {
      $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
      var id = $(this).attr('data');
      console.log(id);
      $.ajax({
         url: "<?php echo base_url('draftauthor/delete/'); ?>" + id,
         success: function(data) {
            $('#reload-author').load(' #reload-author');

            toastr_view('2');
         }

      })
   });

   // hapus reviewer
   $('#data-reviewer').on('click', '.delete-reviewer', function() {
      $(this).attr('disabled', 'disabled').html("<i class='fa fa-spinner fa-spin '></i>");
      var id = $(this).attr('data');
      console.log(id);
      $.ajax({
         url: "<?php echo base_url('draftreviewer/delete/'); ?>" + id,
         success: function(data) {
            $('#reload-reviewer').load(' #reload-reviewer');
            toastr_view('4');
         }

      })
   });


   //ubah entry date
   $('#btn-ubah_entry_date').on('click', function() {
      var $this = $(this);
      $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      let id = $('[name=draft_id]').val();
      let entry_date = $('[name=entry_date]').val();
      console.log(entry_date)
      $.ajax({
         type: "POST",
         url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
         datatype: "JSON",
         data: {
            entry_date: entry_date,
         },
         success: function(data) {
            let datax = JSON.parse(data);
            console.log(datax)
            $this.removeAttr("disabled").html("Submit");
            if (datax.status == true) {
               toastr_view('111');
            } else {
               toastr_view('000');
            }
            $('#data-drafts').load(' #data-drafts');
            $('#ubah_entry_date').modal('toggle');
         }

      });
      return false;
   });

   //ubah entry date
   $('#btn-ubah_draft_notes').on('click', function() {
      var $this = $(this);
      $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      let id = $('[name=draft_id]').val();
      let draft_notes = $('[name=draft_notes]').val();
      console.log(draft_notes)
      $.ajax({
         type: "POST",
         url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
         datatype: "JSON",
         data: {
            draft_notes: draft_notes,
         },
         success: function(data) {
            let datax = JSON.parse(data);
            console.log(datax)
            $this.removeAttr("disabled").html("Submit");
            if (datax.status == true) {
               toastr_view('111');
            } else {
               toastr_view('000');
            }
            $('#data-drafts').load(' #data-drafts');
            $('#ubah_draft_notes').modal('toggle');
         }

      });
      return false;
   });

   $('#draft-setuju').on('click', function() {
      var $this = $(this);
      $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      let id = $('[name=draft_id]').val();
      let draft_title = $this.attr('draft-title');
      let draft_file = $this.attr('draft-file');
      let action = $('#draft-setuju').val();
      let finish_date = $('#finish_date').val();
      let cek = '<?php echo base_url("draft/copyToBook/"); ?>' + id;
      console.log(cek);
      $.ajax({
         type: "POST",
         url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
         datatype: "JSON",
         data: {
            draft_status: action,
            finish_date: finish_date,
         },
         success: function(data) {
            let datax = JSON.parse(data);
            console.log(datax);
            $this.removeAttr("disabled").html("Submit");
            if (datax.status == true) {
               toastr_view('111');
               location.href = '<?php echo base_url("draft/copyToBook/"); ?>' + id;
            } else {
               toastr_view('000');
            }
         }
      });

      // $('#draft_aksi').modal('hide');
      // location.reload();
      return false;
   });

   $('#draft-tolak').on('click', function() {
      var $this = $(this);
      $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
      let id = $('[name=draft_id]').val();
      let action = $('#draft-tolak').val();
      console.log(action);
      $.ajax({
         type: "POST",
         url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
         datatype: "JSON",
         data: {
            draft_status: action,
         },
         success: function(data) {
            let datax = JSON.parse(data);
            console.log(datax);
            $this.removeAttr("disabled").html("Tolak");
            if (datax.status == true) {
               toastr_view('111');
            } else {
               toastr_view('000');
            }
            location.href = '<?php echo base_url("draft/view/"); ?>' + id;
         }
      });

      // $('#draft_aksi').modal('hide');
      // location.reload();
      return false;
   });
});
</script>