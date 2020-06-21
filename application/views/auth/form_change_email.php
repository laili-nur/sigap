<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">Form Ubah Email</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-6">
            <section class="card">
                <div class="card-body">
                    <?= form_open($form_action, 'id="form_change_email" novalidate=""'); ?>
                    <fieldset>
                        <legend>Ubah Email</legend>
                        <?= isset($input->user_id) ? form_hidden('user_id', $input->user_id) : ''; ?>

                        <div class="form-group">
                            <label for="password">Email
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('email', $input->email, 'class="form-control" placeholder="' . $input->email . '" id="email"'); ?>
                            <?= form_error('email'); ?>
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
// $(document).ready(function() {
//     loadValidateSetting();
//     $("#form_change_password").validate({
//             rules: {
//                 username: {
//                     crequired: true,
//                     username: true,
//                 },
//                 password: {
//                     crequired: true,
//                     cminlength: 4
//                 },
//                 new_password: {
//                     crequired: true,
//                     cminlength: 4,
//                     notEqualTo: '#password'
//                 },
//                 confirm_password: {
//                     crequired: true,
//                     minlength: 4,
//                     equalTo: '#new_password'
//                 },
//                 level: "crequired"
//             },
//             messages: {
//                 new_password: {
//                     notEqualTo: 'Password baru tidak boleh sama dengan password lama'
//                 },
//                 confirm_password: {
//                     equalTo: "Kolom konfirmasi harus sama dengan kolom password baru"
//                 }
//             },
//             errorElement: "span",
//             errorPlacement: validateErrorPlacement
//         },
//         validateSelect2()
//     );
// })
</script>
