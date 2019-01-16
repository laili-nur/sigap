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
        <a href="<?=base_url('worksheet')?>">Lembar kerja</a>
      </li>
      <li class="breadcrumb-item active">
        <a class="text-muted">Form</a>
      </li>
    </ol>
  </nav>
</header>
<!-- /.page-title-bar -->
<!-- .page-section -->
<div class="page-section">
  <div class="row">
    <div class="col-md-6">
      <!-- .card -->
      <section id="data-author" class="card">
        <!-- .card-body -->
        <div class="card-body">
          <!-- .form -->
          <?= form_open($form_action,'novalidate="" id="formworksheet"') ?>
          <!-- .fieldset -->
          <fieldset>
            <legend>Data Lembar Kerja</legend>
            <?= isset($input->worksheet_id) ? form_hidden('worksheet_id', $input->worksheet_id) : '' ?>
            <div class="alert alert-info">Last edited by : <strong><?= isset($input->worksheet_pic) ?$input->worksheet_pic : '' ?></strong> on <strong><?= isset($input->worksheet_ts) ? $input->worksheet_ts : '' ?></strong></div>
            <!-- .form-group -->
            <div class="form-group">
              <label for="draft_id">Draft
                <abbr title="Required">*</abbr>
              </label>
              <?php if($input->draft_id=='' or $this->uri->segment(2)=='add'): ?>
                <?= form_dropdown('draft_id', getDropdownList('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft_id" class="form-control custom-select d-block "') ?>
                <?= form_error('draft_id') ?>
                <?php else: ?>
                  <p class="font-weight-bold"><a href="<?=base_url('draft/view/'.$input->draft_id) ?>"><?=konversiID('draft','draft_id',$input->draft_id)->draft_title ?></a></p>
                  <?=(!empty($input->draft_file))? '<a data-toggle="tooltip" data-placement="right" title="'.$input->draft_file.'" class="btn btn-success btn-xs m-0" href="'.base_url('draftfile/'.$input->draft_file).'"><i class="fa fa-download"></i> Download</a>' : '' ?>
                  <?=(!empty($input->draft_file_link))? '<a data-toggle="tooltip" data-placement="right" title="'.$input->draft_file_link.'" class="btn btn-success btn-xs m-0" href="'.$input->draft_file_link.'"><i class="fa fa-external-link-alt"></i> External file</a>' : '' ?>
                  <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>
                <?php endif ?>
              </div>
              <!-- /.form-group -->
              <hr class="my-2">
              <!-- .form-group -->
              <div class="form-group">
                <label for="worksheet_num">Nomor Lembar Kerja
                  <abbr title="Required">*</abbr>
                </label>
                <div class="has-clearable">
                  <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">
                      <i class="fa fa-times-circle"></i>
                    </span>
                  </button>
                  <?= form_input('worksheet_num', $input->worksheet_num, 'class="form-control" id="worksheet_num"') ?>
                </div>
                <?= form_error('worksheet_num') ?>
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <label for="worksheet_notes">Catatan Desk Screening
                </label>
                <div class="has-clearable">
                  <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">
                      <i class="fa fa-times-circle"></i>
                    </span>
                  </button>
                  <?= form_textarea('worksheet_notes', $input->worksheet_notes, 'class="form-control summernote-basic" id="worksheet_notes"') ?>
                </div>
                <?= form_error('worksheet_notes') ?>
              </div>
              <!-- /.form-group -->
              <!-- .form-group -->
              <div class="form-group">
                <label>Jenis Naskah
                  <abbr title="Required">*</abbr>
                </label>
                <div class="custom-control custom-radio mb-1">
                  <?= form_radio('is_reprint', 'y',
                  isset($input->is_reprint) && ($input->is_reprint == 'y') ? true : false,' class="custom-control-input" id="cetakulang"')?>
                  <label class="custom-control-label" for="cetakulang">Cetak Ulang</label>
                </div>
                <div class="custom-control custom-radio mb-1">
                  <?= form_radio('is_reprint', 'n',
                  isset($input->is_reprint) && ($input->is_reprint == 'n') ? true : false,' class="custom-control-input" id="naskahbaru"')?>
                  <label class="custom-control-label" for="naskahbaru">Naskah Baru</label>
                </div>
                <?= form_error('is_reprint') ?>
              </div>
              <!-- /.form-group -->
            </fieldset>
            <!-- /.fieldset -->
            <hr>
            <!-- .form-group -->
            <div class="form-group">
              <label>Status
                <abbr title="Required">*</abbr>
              </label>
              <div class="custom-control custom-radio mb-1">
                <?= form_radio('worksheet_status', '0',
                isset($input->worksheet_status) && ($input->worksheet_status == '0') ? true : false,' class="custom-control-input" id="belum"')?>
                <label class="custom-control-label" for="belum">-</label>
              </div>
              <div class="custom-control custom-radio mb-1">
                <?= form_radio('worksheet_status', '1',
                isset($input->worksheet_status) && ($input->worksheet_status == '1') ? true : false,' class="custom-control-input" id="approve"')?>
                <label class="custom-control-label" for="approve">Approve</label>
              </div>
              <div class="custom-control custom-radio mb-1">
                <?= form_radio('worksheet_status', '2',
                isset($input->worksheet_status) && ($input->worksheet_status == '2') ? true : false,' class="custom-control-input" id="reject"')?>
                <label class="custom-control-label" for="reject">Reject</label>
              </div>
              <?= form_error('worksheet_status') ?>
            </div>
            <!-- /.form-group -->
            <hr>
            <!-- .form-actions -->
            <div class="form-actions">
              <button class="btn btn-primary ml-auto" type="submit">Submit data</button>
            </div>
            <!-- /.form-actions -->
          </form>
          <!-- /.form -->
        </div>
        <!-- /.card-body -->
      </section>
      <!-- /.card -->
    </div>
  </div>
</div>
<!-- /.page-section -->

<script>
  $(document).ready(function() {
    setting_validasi();
    $("#formworksheet").validate({
      rules: {
        draft_id : "crequired",
        worksheet_num : "crequired",
        is_reprint : "crequired",
        worksheet_status : "crequired",
      },
      errorElement: "span",
      errorPlacement: function (error, element) {
       error.addClass( "invalid-feedback" );
       if (element.parent('.input-group').length) { 
                error.insertAfter(element.next('span.select2'));      // input group
              } else if (element.hasClass("select2-hidden-accessible")){
                error.insertAfter(element.next('span.select2'));  // select2
              } else if (element.hasClass("custom-file-input")){
                error.insertAfter(element.next('label.custom-file-label'));  // fileinput custom
              } else if (element.hasClass("custom-control-input")){
                error.insertAfter($(".custom-radio").last());  // radio
              }else {                                      
                error.insertAfter(element);               // default
              }
            }
          },
          select2_validasi()
          );

    $("#draft_id").select2({
      placeholder: '-- Choose --',
      allowClear: true
    });
  });
</script>


