<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Printing</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Order Cetak </h1>
            <span class="badge badge-info">Total : 
            <?php 
                if($_SESSION['level'] == 'admin jilid'){echo $data_jilid->num_rows();}
                elseif($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin cetak'){echo $data_all->num_rows();}
                else{echo 0;}
            ?>
            </span>
        </div>
        <a
            href="<?= base_url("$pages/view_printing_add"); ?>"
            class="btn btn-primary btn-sm <?= !is_admin() ? 'd-none' : ''; ?>"
        ><i class="fa fa-plus fa-fw"></i> Tambah</a>
    </div>
</header>

<div class="page-section">
    <div class="row">
        <div class="col-12">
            <section class="card card-fluid">
                <div class="card-body p-0">
                    <div class="p-3">
                        <?php //if ($progress == 'error') : ?>
                            <!-- <div
                                class="alert alert-danger alert-dismissible fade show"
                                role="alert"
                            >
                                <p class="m-0">Lakukan penyesuaian order cetak berikut agar tidak terjadi error progress, dengan cara
                                    masuk ke menu edit manual lalu sesuaikan progress dan tanggalnya. Selain itu dapat juga direset
                                    dengan mengosongi isian pada <em>halaman edit</em>, lalu memulai progress dengan benar di
                                    <em>halaman view</em>.</p>
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="alert"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div> -->
                        <?php //endif; // filter error
                        ?>

                    </div>
                    <?php if ($data_all || $data_jilid) : ?>
                        <div class="double-scroll">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            scope="col"
                                            class="pl-3"
                                        >No</th>
                                        <th
                                            scope="col"
                                            style="min-width:350px;"
                                        >Judul</th>
                                        <th
                                            scope="col"
                                            style="min-width:50px;"
                                        >Edisi</th>
                                        <th
                                            scope="col"
                                            style="min-width:100px;"
                                        >Tipe cetak</th>
                                        <th
                                            scope="col"
                                            style="min-width:100px;"
                                        >Jumlah cetak</th>
                                        <th
                                            scope="col"
                                            style="min-width:100px;"
                                        >Prioritas</th>
                                        <th
                                            scope="col"
                                            style="min-width:100px;"
                                        >Tanggal masuk</th>
                                        <th
                                            scope="col"
                                            style="max-width:100px;"
                                        >Status</th>
                                        <?php if (is_admin()) : ?>
                                            <th style="min-width:170px;"> &nbsp; </th>
                                        <?php endif; ?>
                                        <!-- <?php //if ($level != 'reviewer') : ?>
                                            <th
                                                scope="col"
                                                style="min-width:150px;"
                                            >Penulis</th>
                                        <?php //endif; ?> -->
                                        <!-- <th
                                            scope="col"
                                            style="max-width:100px;"
                                        >Tanggal Masuk</th>
                                        <th
                                            scope="col"
                                            style="min-width:130px;"
                                        >Status</th> -->
                                        <!-- <?php //if ($level == 'reviewer' or $level == 'editor' or $level == 'layouter') : ?>
                                            <th scope="col">Sisa Waktu</th>
                                        <?php //endif; ?> -->
                                        <!-- <?php //if (is_admin()) : ?>
                                            <th style="min-width:170px;"> &nbsp; </th>
                                        <?php //endif; ?> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin cetak') : ?>
                                    <?php foreach ($data_all->result() as $data) : ?>
                                        <tr>
                                            <td class="align-middle pl-3"><!-- No  -->
                                                <?= ++$i; ?>
                                            </td>
                                            <td class="align-middle"><!-- Judul  -->
                                                <a
                                                    href="<?= base_url('printing/view_printing_view/' . $data->print_id . ''); ?>"
                                                    class="font-weight-bold"
                                                >
                                                    <?= ($data->print_category == 1) ? '<span class="badge badge-warning"><i class="fa fa-redo" data-toggle="tooltip" title="Cetak Ulang"></i></span>' : ''; ?>
                                                    <?= $data->book_title //highlight_keyword($draft->draft_title, $keyword); ?>
                                                </a>
                                            </td>
                                            <td class="align-middle"><!-- Cetakan ke-  -->
                                                <?= $data->print_edition; ?>
                                            </td>
                                            <td class="align-middle"><!-- Tipe cetak  -->
                                                <?php
                                                if($data->print_type == 0){echo 'POD';}
                                                elseif($data->print_type == 1){echo 'Offset';}
                                                else{echo '';}
                                                ?>
                                            </td>
                                            <td class="align-middle"><!-- Jumlah cetak  -->
                                                <?= $data->print_total; ?>
                                            </td>
                                            <td class="align-middle"><!-- Prioritas  -->
                                                <?php
                                                if($data->print_priority == 0){echo 'Rendah';}
                                                elseif($data->print_priority == 1){echo 'Sedang';}
                                                elseif($data->print_priority == 2){echo 'Tinggi';}
                                                else{echo '';}
                                                ?>
                                            </td>
                                            <td class="align-middle"><!-- Tanggal masuk  -->
                                                <?= format_datetime($data->entry_date); ?>
                                            </td>
                                            <td class="align-middle"><!-- Status  -->
                                                <?php
                                                if($data->is_pracetak == 1){echo 'Proses Pracetak';}
                                                elseif($data->is_cetak == 1){echo 'Proses Cetak';}
                                                elseif($data->is_jilid == 1){echo 'Proses Jilid';}
                                                elseif($data->is_final == 1){echo 'Proses Final';}
                                                elseif($data->print_flag == 2){echo 'Selesai';}
                                                elseif($data->print_flag == 1){echo 'Ditolak';}
                                                elseif($data->print_flag == 0){echo 'Belum di Proses';}
                                                else{echo '';}
                                                ?>                                     
                                            </td>

                                            <?php if (is_admin()) : ?>
                                                <td class="align-middle text-right"><!-- Edit  -->
                                                    <a
                                                        title="Edit"
                                                        href="<?= base_url('printing/view_printing_edit/' . $data->print_id . ''); ?>"
                                                        class="btn btn-sm btn-secondary"
                                                    >
                                                        <i class="fa fa-pencil-alt"></i>
                                                        <span class="sr-only">Edit</span>
                                                    </a>
                                                    <button
                                                        title="Delete"
                                                        type="button"
                                                        class="btn btn-sm btn-danger"
                                                        data-toggle="modal"
                                                        data-target="#modal-hapus-<?= $data->print_id; ?>"
                                                    >
                                                        <i class="fa fa-trash-alt"></i>
                                                        <span class="sr-only">Delete</span>
                                                    </button>
                                                    <div class="text-left">
                                                        <div
                                                            class="modal modal-alert fade"
                                                            id="modal-hapus-<?= $data->print_id; ?>"
                                                            tabindex="-1"
                                                            role="dialog"
                                                            aria-labelledby="modal-hapus"
                                                            aria-hidden="true"
                                                        >
                                                            <div
                                                                class="modal-dialog"
                                                                role="document"
                                                            >
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            <i class="fa fa-exclamation-triangle text-red mr-1"></i> Konfirmasi
                                                                            Hapus</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Apakah anda yakin akan menghapus draft <span class="font-weight-bold">
                                                                                <?= $data->book_title; ?></span>?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-danger"
                                                                            onclick="location.href='<?= base_url('printing/delete_printing/' . $data->print_id . ''); ?>'"
                                                                            data-dismiss="modal"
                                                                        >Hapus</button>
                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-light"
                                                                            data-dismiss="modal"
                                                                        >Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <p class="text-center">Data tidak tersedia</p>
                    <?php endif; ?>
                    <?= $pagination ?? null; ?>
                </div>
            </section>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    doublescroll();
    $("#category,#progress,#reprint,#status").select2({
        placeholder: '- Semua -',
        allowClear: true,
        dropdownParent: $('#app-main')
    });
});
</script>
