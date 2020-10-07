<?php if ($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_percetakan') : ?>
    <!-- all -->
    <?php if ($print_order->{"is_{$progress}"} == 1) : ?>
        <div
            class="alert alert-success alert-dismissible fade show mb-1"
            role="alert"
        >Progress telah selesai.<button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button></div>
    <?php endif; ?>
    <?php if ($_SESSION['level'] == 'superadmin' && $print_order->{"is_{$progress}"} == 0) : ?>
        <!-- superadmin -->
        <?php if (!$admin_percetakan) : ?>
            <div
                class="alert alert-warning alert-dismissible fade show mb-1"
                role="alert"
            ><strong>PERHATIAN!</strong> Belum ada admin percetakan yang dipilih.<button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button></div>
        <?php endif; ?>
        <?php if (!$print_order->{"{$progress}_deadline"}) : ?>
            <div
                class="alert alert-warning alert-dismissible fade show mb-1"
                role="alert"
            ><strong>PERHATIAN!</strong> Belum menetapkan deadline progress.<button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button></div>
        <?php endif; ?>
        <?php if ($print_order->{"{$progress}_end_date"}) : ?>
            <div
                class="alert alert-warning alert-dismissible fade show mb-1"
                role="alert"
            ><strong>PERHATIAN!</strong> Progress telah selesai. Mohon untuk melakukan aksi.<button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button></div>
        <?php endif; ?>
    <?php elseif ($_SESSION['level'] == 'admin_percetakan' && $print_order->{"is_{$progress}"} == 0) : ?>
        <!-- admin -->
        <?php if (${"is_{$progress}_started"}) : ?>
            <div
                class="alert alert-warning alert-dismissible fade show mb-1"
                role="alert"
            ><strong>PERHATIAN!</strong> Pastikan mengisi catatan dan data lainnya sebelum menyelesaikan progress.<button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button></div>
        <?php endif; ?>
        <?php if (${"is_{$progress}_finished"}) : ?>
            <div
                class="alert alert-warning alert-dismissible fade show mb-1"
                role="alert"
            ><strong>PERHATIAN!</strong> Progress telah selesai. Mohon tunggu superadmin memproses aksi<button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button></div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
