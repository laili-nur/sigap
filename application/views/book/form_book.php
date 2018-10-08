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
          <a href="<?=base_url('book')?>">Buku</a>
        </li>
        <li class="breadcrumb-item">
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
      <?= form_open_multipart($form_action,'class="needs-validation" novalidate="" id="formdraft"') ?>
        <!-- .fieldset -->
        <fieldset>
          <legend>Data Buku</legend>
          <?= isset($input->book_id) ? form_hidden('book_id', $input->book_id) : '' ?>
          <!-- .form-group -->
          <div class="form-group">
            <label for="category">Draft
              <abbr title="Required">*</abbr>
            </label>
            <?= form_dropdown('draft_id', getDropdownList('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft" class="form-control custom-select d-block" required') ?>
            <div class="invalid-feedback">Field is required</div>
            <?= form_error('category_id') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_code">Kode Buku
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('book_code', $input->book_code, 'class="form-control" id="book_code"') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('book_code') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_title">Judul Buku
              <abbr title="Required">*</abbr>
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('book_title', $input->book_title, 'class="form-control" id="book_title" required=""') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('book_title') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_edition">Edisi Buku
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('book_edition', $input->book_edition, 'class="form-control" id="book_edition" ') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('book_edition') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="isbn">ISBN
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('isbn', $input->isbn, 'class="form-control" id="isbn"') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('isbn') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="book_file">File Buku
              <abbr title="Required">*</abbr>
            </label>
            <p><?= isset($input->book_file)? '<a href="'.base_url('draftfile/'.$input->book_file).'">'.$input->book_file.'</a>' : ''  ?></p>
            <div class="custom-file">
              <?= form_upload('book_file','','class="custom-file-input" ') ?> 
              <label class="custom-file-label" for="tf3">Choose file</label>
              <div class="invalid-feedback">Field is required</div>
            </div>
            <small class="form-text text-muted">Hanya menerima file bertype : docx dan doc</small>
            <?= fileFormError('book_file', '<p class="text-danger">', '</p>'); ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="published_date">Tanggal Terbit
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('published_date', $input->published_date, 'class="form-control mydate" id="published_date"') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('published_date') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
            <div class="form-group">
              <label>Tipe Printing</label>
              <div>
                <!-- button radio -->
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary <?=($input->printing_type == 'p') ? 'active' : '' ?>">
                  <?= form_radio('printing_type', 'p',
                  isset($input->printing_type) && ($input->printing_type == 'p') ? true : false,'required class="custom-control-input" id="blocked1"')?> POD</label>
                <label class="btn btn-secondary <?=($input->printing_type == 'o') ? 'active' : '' ?>">
                  <?= form_radio('printing_type', 'o',
                  isset($input->printing_type) && ($input->printing_type == 'o') ? true : false,' class="custom-control-input" id="blocked2"')?> Offset</label>
              </div>
              <!-- /button radio -->
              </div>
               <?= form_error('printing_type') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
          <div class="form-group">
            <label for="serial_num">Serial Number Total
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('serial_num', $input->serial_num, 'class="form-control" id="serial_num" required=""') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('serial_num') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="serial_num_per_year">Serial Number Per Tahun
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('serial_num_per_year', $input->serial_num_per_year, 'class="form-control" id="serial_num_per_year" required=""') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('serial_num_per_year') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <div class="form-group">
            <label for="copies_num">Jumlah Copy
            </label>
            <div class="has-clearable">
              <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">
                  <i class="fa fa-times-circle"></i>
                </span>
              </button>
            <?= form_input('copies_num', $input->copies_num, 'class="form-control" id="copies_num"') ?>
            <div class="invalid-feedback">Field is required</div>
            </div>
            <?= form_error('copies_num') ?>
          </div>
          <!-- /.form-group -->
          <!-- .form-group -->
          <!-- .form-group -->
            <div class="form-group">
              <label for="book_notes">Keterangan Buku</label>
              <div class="has-clearable">
                <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">
                    <i class="fa fa-times-circle"></i>
                  </span>
                </button>
                <?= form_textarea('book_notes', $input->book_notes, 'class="form-control"') ?>
                 </div>
              <div class="invalid-feedback">Field is required</div>
              <?= form_error('book_notes') ?>
            </div>
            <!-- /.form-group -->
            <!-- .form-group -->
            <div class="form-group">
              <label>Status</label>
              <div>
                <!-- button radio -->
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary <?=($input->is_reprint == 'y') ? 'active' : '' ?>">
                  <?= form_radio('is_reprint', 'y',
                  isset($input->is_reprint) && ($input->is_reprint == 'y') ? true : false,'required class="custom-control-input" id="reprint1"')?> Cetak Ulang</label>
                <label class="btn btn-secondary <?=($input->is_reprint == 'n') ? 'active' : '' ?>">
                  <?= form_radio('is_reprint', 'n',
                  isset($input->is_reprint) && ($input->is_reprint == 'n') ? true : false,' class="custom-control-input" id="reprint2"')?> Baru</label>
              </div>
              <!-- /button radio -->
              </div>
              
               <?= form_error('is_reprint') ?>
            </div>
            <!-- /.form-group -->  
        </fieldset>
        <!-- /.fieldset -->
        <hr>
        <!-- .form-actions -->
        <div class="form-actions">
          <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit">Submit data</button>
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
    $("#draft").select2({
      placeholder: '-- Choose --',
      allowClear: true
    });
 });
</script>
