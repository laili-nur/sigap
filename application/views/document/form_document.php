<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('document'); ?>">dokument</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-6">
            <section class="card">
                <div class="card-body">
                    <?= form_open_multipart($form_action, 'id="form_document" novalidate=""'); ?>
                    <fieldset>
                        <legend>Form Dokument</legend>
                        <?= isset($input->document_id) ? form_hidden('document_id', $input->document_id) : ''; ?>
                        <div class="form-group">
                            <label for="document_name">Nama Dokumen
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('document_name', $input->document_name, 'class="form-control" id="document_name"'); ?>
                            <?= form_error('document_name'); ?>
                        </div>
                        <div class="form-group">
                            <label for="document_year">Tahun Dokumen</label>
                            <?= form_input('document_year', $input->document_year, 'class="form-control dokumen" id="document_year"'); ?>
                            <?= form_error('document_year'); ?>
                        </div>
                        <div class="form-group">
                            <label for="document_file">File Dokumen</label>
                            <?php if ($input->document_file) : ?>
                                <div class="alert alert-info d-flex justify-content-between align-items-center">File dokumen yang tersimpan
                                    <a
                                        href="<?= base_url("document/download_file/documentfile/$input->document_file"); ?>"
                                        class="btn btn-success btn-sm my-2 uploaded-file"
                                    ><i class="fa fa-download"></i> Download</a>
                                </div>
                            <?php endif; ?>
                            <div class="custom-file">
                                <?= form_upload('document_file', '', 'class="custom-file-input document"'); ?>
                                <label
                                    class="custom-file-label"
                                    for="document_file"
                                >Pilih file</label>
                            </div>
                            <small class="form-text text-muted">Tipe file upload bertype : <?= get_allowed_file_types('document_file')['to_text'] ?></small>
                            <?= file_form_error('document_file', '<p class="text-danger">', '</p>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="document_file_link">Link Dokumen</label>
                            <?= form_input('document_file_link', $input->document_file_link, 'class="form-control document" id="document_file_link"'); ?>
                            <?= form_error('document_file_link'); ?>
                        </div>
                        <div class="form-group">
                            <label for="document_notes">Catatan Dokumen</label>
                            <?= form_textarea('document_notes', $input->document_notes, 'class="form-control summernote-basic" id="document_notes"'); ?>
                            <?= form_error('document_notes'); ?>
                        </div>

                    </fieldset>
                    <hr>
                    <div class="form-actions">
                        <button
                            class="btn btn-primary ml-auto"
                            type="submit"
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
    $("#form_document").validate({
            rules: {
                document_name: "crequired",
                document_file: {
                    require_from_group: [1, ".document"],
                },
                document_file_link: {
                    curl: true,
                    require_from_group: [1, ".document"]
                },
                document_year: {
                    crange: [1900, 2100]
                }
            },
            errorElement: "span",
            errorPlacement: validateErrorPlacement,
        },
        validateSelect2()
    );
})
</script>
