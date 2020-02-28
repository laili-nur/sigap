<?php $ceklevel = $this->session->userdata('level');?>
<!-- .card -->
<section id="progress-print" class="card">
  <!-- .card-header -->
  <header class="card-header">
    <!-- .d-flex -->
    <div class="d-flex align-items-center">
      <span class="mr-auto">Cetak</span>
      <!-- .card-header-control -->
      <div class="card-header-control">
        <?php if ($ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan'): ?>
        <button type="button" class="btn btn-secondary" id="btn-mulai-cetak" <?=($input->print_start_date == null or $input->print_start_date == '0000-00-00 00:00:00') ? '' : 'disabled';?>><i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span></button>
        <?php endif;?>
        <!-- /.tombol add -->
      </div>
      <!-- /.card-header-control -->
    </div>
    <!-- /.d-flex -->
  </header>
  <div class="list-group list-group-flush list-group-bordered" id="list-group-print">
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal masuk</span>
      <strong><?=konversiTanggal($input->print_start_date);?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Tanggal jadi</span>
      <strong><?=konversiTanggal($input->print_end_date);?></strong>
    </div>
    <div class="list-group-item justify-content-between">
      <span class="text-muted">Status</span>
      <?php if ($input->is_print == 'y'): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->print_status;?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Cetak Selesai</a>
      <?php elseif ($input->is_print == 'n' and $input->stts == 99): ?>
      <a href="#" onclick="event.preventDefault()" class="font-weight-bold" data-toggle="popover" data-placement="left" data-container="body" auto="" right="" data-html="true" title="" data-trigger="hover" data-content="<?=$input->print_status;?>" data-original-title="Catatan Admin"><i class="fa fa-info-circle"></i> Draft Ditolak</a>
      <?php else: ?>
      -
      <?php endif;?>
    </div>
    <hr class="m-0">
  </div>
  <!-- .card-body -->
  <div class="card-body">
    <div class="el-example">
      <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
      <button title="Aksi admin" class="btn btn-secondary" data-toggle="modal" data-target="#print_aksi"><i class="fa fa-thumbs-up"></i> Aksi</button>
      <?php endif;?>
      <button type="button" class="btn <?=($input->print_notes != '') ? 'btn-success' : 'btn-outline-success';?>" data-toggle="modal" data-target="#print">Pengaturan Cetak
        <?=($input->print_notes != '') ? '<i class="fa fa-check"></i>' : '';?></button>
      <!-- modal -->
      <div class="modal fade" id="print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- .modal-dialog -->
        <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
          <!-- .modal-content -->
          <div class="modal-content">
            <!-- .modal-header -->
            <div class="modal-header">
              <h5 class="modal-title"> Progress print</h5>
            </div>
            <!-- /.modal-header -->
            <!-- .modal-body -->
            <div class="modal-body">
              <p class="font-weight-bold">NASKAH</p>
              <div class="alert alert-info">Upload file naskah atau sertakan link naskah.</div>
              <?=form_open_multipart('draft/upload_progress/' . $input->draft_id . '/print_file', 'id="printform"');?>
              <?=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '';?>
              <!-- .form-group -->
              <div class="form-group">
                <label for="print_file">File Naskah</label>
                <!-- .input-group -->
                <div class="custom-file">
                  <?=form_upload('print_file', '', 'class="custom-file-input naskah" id="print_file"');?>
                  <label class="custom-file-label" for="print_file">Choose file</label>
                </div>
                <small class="form-text text-muted">Tipe file upload  bertype : docx, doc, dan pdf.</small>
                <!-- /.input-group -->
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <label for="print_file_link">Link Naskah</label>
                <div>
                  <?=form_input('print_file_link', $input->print_file_link, 'class="form-control naskah" id="print_file_link"');?>
                </div>
                <?=form_error('print_file_link');?>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-print"><i class="fa fa-upload"></i> Upload</button>
              </div>
              <?=form_close();?>
              <!-- keterangan last upload dan tombol download -->
              <div id="modal-print">
                <p class="form-text text-muted">Last Upload :
                  <?=konversiTanggal($input->print_upload_date);?>,
                  <br> by :
                  <?=konversi_username_level($input->print_last_upload);?>
                  <?php if ($ceklevel != 'author' and $ceklevel != 'reviewer'): ?>
                  <em>(<?=$input->print_last_upload;?>)</em>
                  <?php endif;?>
                </p>
                <?=(!empty($input->print_file)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->print_file . '" href="' . base_url('draftfile/' . $input->print_file) . '" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : '';?>
                <?=(!empty($input->print_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->print_file_link . '" href="' . $input->print_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : '';?>
              </div>
              <hr class="my-3">
              <!-- .form -->
              <?=form_open('draft/ubahnotes/' . $input->draft_id, 'id="formprint"');?>
              <!-- .fieldset -->
              <fieldset>
                <!-- .form-group -->
                <div class="form-group">
                  <label for="cprint" class="font-weight-bold">Catatan print</label>
                  <?php
$optionscprint = array(
    'name'  => 'print_notes',
    'class' => 'form-control summernote-basic',
    'id'    => 'cprint',
    'rows'  => '6',
    'value' => $input->print_notes,
);
if ($ceklevel == 'author') {
    echo '<div class="font-italic">' . nl2br($input->print_notes) . '</div>';
} else {
    echo form_textarea($optionscprint);
}
?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label>Tipe Printing</label>
                  <div>
                    <!-- button radio -->
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-secondary <?=($input->printing_type == 'p') ? 'active' : '';?>">
                        <?=form_radio('printing_type', 'p',
    isset($input->printing_type) && ($input->printing_type == 'p') ? true : false, 'required class="custom-control-input" id="blocked1"');?> POD</label>
                      <label class="btn btn-secondary <?=($input->printing_type == 'o') ? 'active' : '';?>">
                        <?=form_radio('printing_type', 'o',
    isset($input->printing_type) && ($input->printing_type == 'o') ? true : false, ' class="custom-control-input" id="blocked2"');?> Offset</label>
                    </div>
                    <!-- /button radio -->
                  </div>
                  <?=form_error('printing_type');?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="serial_num">Serial Number Total
                  </label>
                  <?=form_input('serial_num', $input->serial_num, 'class="form-control" id="serial_num"');?>
                  <?=form_error('serial_num');?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="serial_num_per_year">Serial Number Per Tahun</label>
                  <?=form_input('serial_num_per_year', $input->serial_num_per_year, 'class="form-control" id="serial_num_per_year" ');?>
                  <?=form_error('serial_num_per_year');?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="copies_num">Jumlah Copy</label>
                  <?=form_input('copies_num', $input->copies_num, 'class="form-control" id="copies_num"');?>
                  <?=form_error('copies_num');?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="cetakan_ke">Cetakan ke</label>
                  <?=form_input('cetakan_ke', $input->cetakan_ke, 'class="form-control" id="cetakan_ke"');?>
                  <?=form_error('cetakan_ke');?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="kertas_isi">Kertas isi</label>
                  <?=form_input('kertas_isi', $input->kertas_isi, 'class="form-control" id="kertas_isi"');?>
                  <?=form_error('kertas_isi');?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="kertas_cover">Kertas cover</label>
                  <?=form_input('kertas_cover', $input->kertas_cover, 'class="form-control" id="kertas_cover"');?>
                  <?=form_error('kertas_cover');?>
                </div>
                <!-- /.form-group -->
                <!-- .form-group -->
                <div class="form-group">
                  <label for="ukuran">Ukuran</label>
                  <?=form_input('ukuran', $input->ukuran, 'class="form-control" id="ukuran"');?>
                  <?=form_error('ukuran');?>
                </div>
                <!-- /.form-group -->
              </fieldset>
              <!-- /.fieldset -->
            </div>
            <!-- /.modal-body -->
            <!-- .modal-footer -->
            <div class="modal-footer">
              <?php if ($author_order != 0 or $ceklevel != 'author'): ?>
              <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-print">Submit</button>
              <?php endif;?>
              <?=form_close();?>
              <!-- /.form -->
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            <!-- /.modal-footer -->
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- modal deadline -->
      <div class="modal fade" id="print_aksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- .modal-dialog -->
        <div class="modal-dialog" role="document">
          <!-- .modal-content -->
          <div class="modal-content">
            <!-- .modal-header -->
            <div class="modal-header">
              <h5 class="modal-title">Aksi</h5>
            </div>
            <!-- /.modal-header -->
            <!-- .modal-body -->
            <div class="modal-body">
              <!-- .form -->
              <?=form_open('draft/ubahnotes/' . $input->draft_id);?>
              <!-- .fieldset -->
              <fieldset>
                <!-- .form-group -->
                <div class="form-group">
                  <label for="print_status" class="font-weight-bold">Catatan Admin</label>
                  <div class="alert alert-info">
                    Catatan admin dapat dilihat oleh semua user yang terkait dengan draft ini.
                  </div>
                  <?php
$hidden_date = array(
    'type'  => 'hidden',
    'id'    => 'print_end_date',
    'value' => date('Y-m-d H:i:s'),
);
echo form_input($hidden_date);
$print_status = array(
    'name'  => 'print_status',
    'class' => 'form-control summernote-basic',
    'id'    => 'crp2',
    'rows'  => '6',
    'value' => $input->print_status,
);
if ($ceklevel != 'superadmin' and $ceklevel != 'admin_penerbitan') {
    echo '<div class="font-italic">' . nl2br($input->print_status) . '</div>';
} else {
    echo form_textarea($print_status);
}
?>
                  <div class="alert alert-info">
                    Pilih salah satu tombol dibawah ini: <br>
                    Jika <strong class="text-success">Setuju</strong>, maka tahap cetak akan diakhiri dan tanggal selesai cetak akan dicatat <br>
                    Jika <strong class="text-danger">Tolak</strong> maka proses draft akan diakhiri sampai tahap ini.
                  </div>
                </div>
                <!-- /.form-group -->
              </fieldset>
              <!-- /.fieldset -->
            </div>
            <!-- /.modal-body -->
            <!-- .modal-footer -->
            <div class="modal-footer">
              <button class="btn btn-success" type="submit" id="print-setuju" value="16">Setuju</button>
              <button class="btn btn-danger" type="submit" id="print-tolak" value="99">Tolak</button>
              <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            <!-- /.modal-footer -->
            <?=form_close();?>
            <!-- /.form -->
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
  </div>
  <!-- /.card-body -->
</section>
<!-- /.card -->
<script>
$(document).ready(function() {
  //panggil setingan validasi di ugmpress js
  validate_setting();

  //submit dan validasi
  $("#printform").validate({
      rules: {
        print_file: {
          require_from_group: [1, ".naskah"],
          dokumen: "docx|doc|pdf",
          filesize50: 52428200
        },
        print_file_link: {
          curl: true,
          require_from_group: [1, ".naskah"]
        }
      },
      errorElement: "span",
      errorClass: "none",
      validClass: "none",
      errorPlacement: function(error, element) {
        error.addClass("invalid-feedback");
        if (element.parent('.input-group').length) {
          error.insertAfter(element.next('span.select2')); // input group
        } else if (element.hasClass("select2-hidden-accessible")) {
          error.insertAfter(element.next('span.select2')); // select2
        } else if (element.parent().parent().hasClass('input-group')) {
          error.insertAfter(element.closest('.input-group')); // fileinput append
        } else if (element.hasClass("custom-file-input")) {
          error.insertAfter(element.next('label.custom-file-label')); // fileinput custom
        } else if (element.hasClass("custom-control-input")) {
          error.insertAfter($(".custom-radio").last()); // radio
        } else {
          error.insertAfter(element); // default
        }
      },
      submitHandler: function(form) {
        var $this = $('#btn-upload-print');
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Uploading ");
        let id = $('[name=draft_id]').val();
        var formData = new FormData(form);
        $.ajax({
          url: "<?php echo base_url('draft/upload_progress/'); ?>" + id + "/print_file",
          type: "post",
          data: formData,
          processData: false,
          contentType: false,
          cache: false,
          success: function(data) {
            let datax = JSON.parse(data);
            console.log(datax);
            $this.removeAttr("disabled").html("Upload");
            if (datax.status == true) {
              toastr_view('111');
            } else {
              toastr_view('000');
            }
            $('#modal-print').load(' #modal-print');
          }
        });
        $resetform = $('#print_file');
        $resetform.val('');
        $resetform.next('label.custom-file-label').html('');
        return false;
      }
    },
   validate_select2()
  );

  $('#btn-submit-print').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        print_notes: $('#cprint').val(),
        printing_type: $('[name=printing_type]:checked').val(),
        serial_num: $('#serial_num').val(),
        serial_num_per_year: $('#serial_num_per_year').val(),
        copies_num: $('#copies_num').val(),
        cetakan_ke: $('#cetakan_ke').val(),
        kertas_cover: $('#kertas_cover').val(),
        kertas_isi: $('#kertas_isi').val(),
        ukuran: $('#ukuran').val(),
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
        $('#print').modal('toggle');
      }
    });
    return false;
  });

  //tombol mulai proses cetak
  $('#btn-mulai-cetak').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    var draft = $('input[name=draft_id]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('responsibility/mulai_proses/'); ?>",
      datatype: "JSON",
      cache: false,
      data: {
        draft_id: draft,
        col: 'print_start_date'
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
        $('#list-group-print').load(' #list-group-print');
        $this.removeAttr("disabled").html('<i class="fas fa-play"></i><span class="d-none d-lg-inline"> Mulai</span>');
        $this.addClass('disabled');
        $this.attr("disabled", "disabled");
        location.reload();
      }

    });
    return false;
  });

  $('#print-setuju').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let print_status = $('[name=print_status]').val();
    let action = $('#print-setuju').val();
    let end_date = $('#print_end_date').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        print_status: print_status,
        draft_status: action,
        print_end_date: end_date,
        is_print: 'y'
      },
      success: function(data) {
        let datax = JSON.parse(data);
        console.log(datax);
        $this.removeAttr("disabled").html("Setuju");
        if (datax.status == true) {
          toastr_view('111');
        } else {
          toastr_view('000');
        }
        $('#list-group-print').load(' #list-group-print');
        location.reload();
      }
    });

    // $('#print_aksi').modal('hide');
    return false;
  });

  $('#print-tolak').on('click', function() {
    var $this = $(this);
    $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    let id = $('[name=draft_id]').val();
    let print_status = $('[name=print_status]').val();
    let action = $('#print-tolak').val();
    let end_date = $('#print_end_date').val();

    console.log(end_date);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('draft/ubahnotes/'); ?>" + id,
      datatype: "JSON",
      data: {
        print_status: print_status,
        draft_status: action,
        print_end_date: end_date,
        is_print: 'n'
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
        $('#list-group-print').load(' #list-group-print');
        location.reload();
      }
    });

    // $('#print_aksi').modal('hide');
    // location.reload();
    return false;
  });

})
</script>