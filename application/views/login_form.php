<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >

    <title> SIGAP LOGIN</title>
    <meta
        property="og:title"
        content="Log In SIGAP"
    >
    <meta
        name="author"
        content="Bagaskara LA"
    >
    <meta
        property="og:locale"
        content="id_ID"
    >
    <meta
        name="description"
        content="SIGAP - Sistem Informasi GAMA PRESS"
    >
    <meta
        property="og:description"
        content="Sistem Informasi GAMA PRESS"
    >
    <link
        rel="canonical"
        href=""
    >
    <meta
        property="og:url"
        content="https://digitalpress.ugm.ac.id/sigap"
    >
    <meta
        property="og:site_name"
        content="SIGAP UGMPRESS"
    >

    <!-- Favicons -->
    <link
        rel="apple-touch-icon-precomposed"
        sizes="144x144"
        href="<?= base_url('assets/apple-touch-icon.png'); ?>"
    >
    <link
        rel="shortcut icon"
        href="<?= base_url('assets/favicon.ico'); ?>"
    >
    <meta
        name="theme-color"
        content="#3063A0"
    >

    <!-- BEGIN THEME STYLES -->
    <link
        rel="stylesheet"
        href="<?= base_url('assets/stylesheets/theme.min.css'); ?>"
        data-skin="default"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/stylesheets/theme-dark.min.css'); ?>"
        data-skin="dark"
    >
    <link
        rel="stylesheet"
        href="<?= base_url('assets/stylesheets/custom.css'); ?>"
    >
    <!-- Disable unused skin immediately -->

    <script>
    var skin = localStorage.getItem('skin') || 'default';
    var unusedLink = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');

    unusedLink.setAttribute('rel', '');
    unusedLink.setAttribute('disabled', true);
    </script>
    <!-- END THEME STYLES -->
</head>

<body>
    <main class="auth">
        <header
            id="auth-header"
            class="auth-header"
        >
            <h1 class="text-warning">
                SIGAP
                <span class="sr-only">Log In</span>
            </h1>
            <h5 class="mb-5">Sistem Informasi GAMA PRESS</h5>
            <!-- <p> Tidak punya akun?
            <a href="#">Hubungi Admin</a>
         </p> -->
        </header>
        <?= form_open('auth', 'class="auth-form"'); ?>
        <?php if (!empty($this->session->flashdata('error'))) : ?>
            <p class="alert alert-danger alert-dismissable"><?= $this->session->flashdata('error'); ?></p>
        <?php endif; ?>
        <div class="form-group">
            <div class="form-label-group">
                <?= form_input('username', $input->username, 'id="inputUser" class="form-control" placeholder="Username" required="" autofocus=""'); ?>
                <label for="inputUser">Username</label>
                <?= form_error('username', '<p class="text-danger">', '</p>'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label-group">
                <?= form_password('password', $input->password, 'id="inputPassword" class="form-control" placeholder="Password" required=""'); ?>
                <label for="inputPassword">Password</label>
                <?= form_error('password', '<p class="text-danger">', '</p>'); ?>
            </div>
        </div>
        <div class="form-group">
            <button
                class="btn btn-lg btn-primary btn-block"
                type="submit"
            >Log In</button>
        </div>
        <?= form_close(); ?>
        <footer class="auth-footer">
            <p class="text-center">
                <a
                    href="#"
                    data-toggle="modal"
                    data-target="#modal-about"
                >About</a>
            </p>
            <div
                id="modal-about"
                class="modal fade"
                tabindex="-1"
                role="dialog"
                aria-labelledby="modal-about"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog modal-lg"
                    role="document"
                >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center"> About us </h5>
                        </div>
                        <div class="modal-body">
                            <div class="metric-row">
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="card-metric">
                                        <div class="metric">
                                            <div class="text-center mb-4">
                                                <div class="user-avatar user-avatar-xl mb-2">
                                                    <img
                                                        src="assets/images/avatars/profile.jpg"
                                                        alt="User Avatar"
                                                    > </div>
                                                <h2 class="card-title"> I Wayan Mustika </h2>
                                                <h6 class="card-subtitle text-muted"> Supervisor<br>Administrator </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="card-metric">
                                        <div class="metric">
                                            <div class="text-center mb-4">
                                                <div class="user-avatar user-avatar-xl mb-2">
                                                    <img
                                                        src="assets/images/avatars/profile.jpg"
                                                        alt="User Avatar"
                                                    > </div>
                                                <h2 class="card-title"> Bagaskara LA </h2>
                                                <h6 class="card-subtitle text-muted"> Fullstack Developer and UX Researcher </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="card-metric">
                                        <div class="metric">
                                            <div class="text-center mb-4">
                                                <div class="user-avatar user-avatar-xl mb-2">
                                                    <img
                                                        src="assets/images/avatars/profile.jpg"
                                                        alt="User Avatar"
                                                    > </div>
                                                <h2 class="card-title"> Edward </h2>
                                                <h6 class="card-subtitle text-muted"> Back End and Database Developer </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3">
                                    <div class="card-metric">
                                        <div class="metric">
                                            <div class="text-center mb-4">
                                                <div class="user-avatar user-avatar-xl mb-2">
                                                    <img
                                                        src="assets/images/avatars/profile.jpg"
                                                        alt="User Avatar"
                                                    > </div>
                                                <h2 class="card-title"> Syuhada Sipayung </h2>
                                                <h6 class="card-subtitle text-muted"> Business Reporting and API Developer </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light"
                                data-dismiss="modal"
                            >Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <!-- BEGIN BASE JS -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/popper.js/umd/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!-- END BASE JS -->
</body>

</html>
