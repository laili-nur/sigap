<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form Ganti Password</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-6">
            <section class="card">
                <div class="card-body">
                    <?= form_open($form_action, 'id="form_change_password" novalidate=""'); ?>
                    <fieldset>
                        <legend>Ganti Password</legend>

                        <div class="form-group">
                            <label for="password">Password Lama
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_password('password', '', 'class="form-control" id="password"'); ?>
                            <?= form_error('password'); ?>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Password Baru
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_password('new_password', '', 'class="form-control" id="new_password"'); ?>
                            <?= form_error('new_password'); ?>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Konfirmasi Password
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_password('confirm_password', '', 'class="form-control" id="confirm_password"'); ?>
                            <?= form_error('confirm_password'); ?>
                        </div>
                    </fieldset>
                    <hr>
                    <div class="form-actions">
                        <button
                            class="btn btn-primary ml-auto"
                            type="submit"
                        >Update</button>
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
    $("#form_change_password").validate({
            rules: {
                username: {
                    crequired: true,
                    username: true,
                },
                password: {
                    crequired: true,
                    cminlength: 4
                },
                new_password: {
                    crequired: true,
                    cminlength: 4,
                    notEqualTo: '#password'
                },
                confirm_password: {
                    crequired: true,
                    minlength: 4,
                    equalTo: '#new_password'
                },
                level: "crequired"
            },
            messages: {
                new_password: {
                    notEqualTo: 'Password baru tidak boleh sama dengan password lama'
                },
                confirm_password: {
                    equalTo: "Kolom konfirmasi harus sama dengan kolom password baru"
                }
            },
            errorElement: "span",
            errorPlacement: validateErrorPlacement
        },
        validateSelect2()
    );
})
</script>
