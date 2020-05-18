<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('institute'); ?>">Institusi</a>
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
                    <?= form_open($form_action, 'id="form_institute" novalidate=""'); ?>
                    <fieldset>
                        <legend>Form Penulis</legend>
                        <?= isset($input->institute_id) ? form_hidden('institute_id', $input->institute_id) : ''; ?>
                        <div class="form-group">
                            <label for="institute_name">
                                <?= $this->lang->line('form_institute_name'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('institute_name', $input->institute_name, 'class="form-control" id="institute_name" autofocus'); ?>
                            <?= form_error('institute_name'); ?>
                        </div>
                    </fieldset>
                    <hr>
                    <div class="form-actions">
                        <button
                            class="btn btn-primary ml-auto"
                            type="submit"
                        >Submit</button>
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
    $("#form_institute").validate({
            rules: {
                institute_name: {
                    crequired: true,
                    alphanum: true,
                }
            },
            errorElement: "span",
            errorPlacement: validateErrorPlacement
        },
        validateSelect2()
    );
})
</script>
