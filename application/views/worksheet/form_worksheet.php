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
          <a href="<?=base_url('worksheet')?>">Lembar kerja</a>
        </li>
        <li class="breadcrumb-item active">
          <a class="text-muted">Tambah</a>
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
        <?= form_open($form_action,'class="needs-validation" novalidate=""') ?>
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
              <?= form_dropdown('draft_id', getDropdownList('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft_id" class="form-control custom-select d-block"') ?>
              <div class="invalid-feedback">Field is required</div>
              <?= form_error('draft_id') ?>
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
              <div class="invalid-feedback">Field is required</div>
              <?= form_error('worksheet_num') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label for="worksheet_notes">Catatan Desk Screening
                <abbr title="Required">*</abbr>
              </label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
              <?= form_textarea('worksheet_notes', $input->worksheet_notes, 'class="form-control" id="worksheet_notes"') ?>
              </div>
              <div class="invalid-feedback">Field is required</div>
              <?= form_error('worksheet_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label>Jenis Naskah</label>
                <div class="custom-control custom-radio mb-1">
                  <?= form_radio('is_reprint', 'y',
                    isset($input->is_reprint) && ($input->is_reprint == 'y') ? true : false,'required class="custom-control-input" id="cetakulang"')?>
                  <label class="custom-control-label" for="cetakulang">Cetak Ulang</label>
                </div>
                <div class="custom-control custom-radio mb-1">
                  <?= form_radio('is_reprint', 'n',
                    isset($input->is_reprint) && ($input->is_reprint == 'n') ? true : false,'required class="custom-control-input" id="naskahbaru"')?>
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
              <label>Status</label>
                <div class="custom-control custom-radio mb-1">
                  <?= form_radio('worksheet_status', '0',
                    isset($input->worksheet_status) && ($input->worksheet_status == '0') ? true : false,'required class="custom-control-input" id="belum"')?>
                  <label class="custom-control-label" for="belum">-</label>
                </div>
                <div class="custom-control custom-radio mb-1">
                  <?= form_radio('worksheet_status', '1',
                    isset($input->worksheet_status) && ($input->worksheet_status == '1') ? true : false,'required class="custom-control-input" id="approve"')?>
                  <label class="custom-control-label" for="approve">Approve</label>
                </div>
                <div class="custom-control custom-radio mb-1">
                  <?= form_radio('worksheet_status', '2',
                    isset($input->worksheet_status) && ($input->worksheet_status == '2') ? true : false,'required class="custom-control-input" id="reject"')?>
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
    $("#draft_id").select2({
      placeholder: '-- Choose --',
      allowClear: true
    });

    // });
    

 });
</script>


