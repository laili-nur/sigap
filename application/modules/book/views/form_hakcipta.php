<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('book'); ?>">Buku</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form Hak Cipta</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-6">
            <section class="card">
                <div class="card-body">
                    <?= form_open_multipart($form_action, 'novalidate id="form_hakcipta"'); ?>
                    <fieldset>
                        <legend>Form Hak Cipta</legend>
                        <?= isset($input->book_id) ? form_hidden('book_id', $input->book_id) : ''; ?>
                        <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                        <?= isset($input->book_title) ? form_hidden('book_title', $input->book_title) : ''; ?>

                        <div class="form-group">
                            <label for="book_title">Judul Buku</label>
                            <p class="font-weight-bold"><?= $input->book_title; ?></p>
                            <?= empty($input->draft_id) ? '<small class="text-danger">Tidak ada Draft yang diasosiasikan ke buku ini. Silakan pilih draft untuk diasosiasikan. <a href="' . base_url('book/edit/' . $input->book_id) . '">Klik di sini</a> </small>' : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="nomor_hak_cipta">Nomor Hak Cipta</label>
                            <?= form_input('nomor_hak_cipta', $input->nomor_hak_cipta, 'class="form-control" id="nomor_hak_cipta" '); ?>
                            <?= form_error('nomor_hak_cipta'); ?>
                        </div>

                        <div class="form-group">
                            <label for="file_hak_cipta">File Hak Cipta</label>
                            <?php if ($input->file_hak_cipta) : ?>
                                <div class="alert alert-info d-flex justify-content-between align-items-center">File buku yang tersimpan
                                    <a
                                        href="<?= base_url("book/download_file/bookfile/$input->file_hak_cipta"); ?>"
                                        class="btn btn-success btn-sm my-2 uploaded-file"
                                    ><i class="fa fa-download"></i> Download</a>
                                </div>
                            <?php endif; ?>
                            <div class="custom-file">
                                <?= form_upload('file_hak_cipta', '', 'class="custom-file-input" id="file_hak_cipta"'); ?>
                                <label
                                    class="custom-file-label"
                                    for="tf3"
                                >Pilih file</label>
                            </div>
                            <small class="form-text text-muted">Hanya menerima file bertype : <?= get_allowed_file_types('hakcipta_file')['to_text']; ?></small>
                            <?= file_form_error('file_hak_cipta', '<p class="text-danger">', '</p>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="file_hak_cipta_link">Link File Hak Cipta</label>
                            <?= form_input('file_hak_cipta_link', $input->file_hak_cipta_link, 'class="form-control" id="file_hak_cipta_link"'); ?>
                            <?= form_error('file_hak_cipta_link'); ?>
                        </div>
                        <div class="form-group">
                            <label>Status Hak Cipta</label>
                            <div>
                                <div
                                    class="btn-group btn-group-toggle"
                                    data-toggle="buttons"
                                >
                                    <label class="btn btn-secondary <?= ($input->status_hak_cipta == '') ? 'active' : ''; ?>">
                                        <?= form_radio(
                                             'status_hak_cipta',
                                             '',
                                             isset($input->is_reprint) && ($input->status_hak_cipta == '') ? true : false,
                                             'required class="custom-control-input" id="status_hak_cipta0"'
                                          ); ?>
                                        -</label>
                                    <label class="btn btn-secondary <?= ($input->status_hak_cipta == '1') ? 'active' : ''; ?>">
                                        <?= form_radio(
                                             'status_hak_cipta',
                                             '1',
                                             isset($input->is_reprint) && ($input->status_hak_cipta == '1') ? true : false,
                                             'required class="custom-control-input" id="status_hak_cipta1"'
                                          ); ?>
                                        Dalam Proses</label>

                                    <label class="btn btn-secondary <?= ($input->status_hak_cipta == '2') ? 'active' : ''; ?>">
                                        <?= form_radio(
                                             'status_hak_cipta',
                                             '2',
                                             isset($input->is_reprint) && ($input->status_hak_cipta == '2') ? true : false,
                                             ' class="custom-control-input" id="status_hak_cipta2"'
                                          ); ?>
                                        Sudah Jadi</label>
                                </div>
                            </div>
                            <?= form_error('status_hak_cipta'); ?>
                        </div>
                    </fieldset>
                    <hr>
                    <div class="form-actions">
                        <button
                            class="btn btn-primary ml-auto"
                            type="submit"
                            value="Submit"
                            id="btn-submit"
                        >Submit data</button>
                    </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    loadValidateSetting();
    $("#form_hakcipta").validate({
            rules: {
                file_hak_cipta_link: "curl",
                file_hak_cipta: {
                    extension: "<?= get_allowed_file_types('hakcipta_file')['types']; ?>",
                }
            },
            errorElement: "span",
            errorClass: "none",
            validClass: "none",
            errorPlacement: validateErrorPlacement,
        },
        validateSelect2()
    );

    $("#draft_id").select2({
        placeholder: '-- Pilih --',
        allowClear: true
    });
});
</script>
