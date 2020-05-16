<?php
$level = check_level();

$per_page = $this->input->get('per_page') ?? 10;
$keyword  = $this->input->get('keyword');
$reprint  = $this->input->get('reprint');
$progress = $this->input->get('progress');
$category = $this->input->get('category');
$status   = $this->input->get('status');
$page     = $this->uri->segment(2);
// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;

$progress_options = [
    ''               => '- Filter Progress -',
    'desk_screening' => 'Tahap Desk Screening',
    'review'         => 'Tahap Review',
    'edit'           => 'Tahap Editorial',
    'layout'         => 'Tahap Layout',
    'proofread'      => 'Tahap Proofread',
    'print'          => 'Tahap Cetak',
    'final'          => 'Final',
    'reject'         => 'Ditolak',
    'error'          => 'Draft Error',
];
// }

$reprint_options = [
    ''  => '- Filter Tipe Naskah -',
    'n' => ' Naskah Baru',
    'y' => ' Naskah Cetak Ulang',
];

$status_options = [
    ''  => '- Filter Status -',
    'n' => ' Belum Dikerjakan',
    'y' => ' Sudah Dikerjakan',
    'approve' => ' Disetujui Admin',
    'reject' => ' Ditolak Admin',
];

    // $authors = '';
    // foreach ($draft->authors as $key => $value) {
    //     $authors .= $value->author_name;
    //     $authors .= '<br>';
    // }
; //  $authors = substr($authors, 0, -2);

function expand($authors)
{
    $authors_list = '<ul class="p-0 m-0" style="padding: 0;list-style-type: none;">';
    foreach ($authors as $a) {
        $authors_list .= '<li>';
        $authors_list .= '<i class="fa fa-user fa-fw"></i> ';
        $authors_list .= $a->author_name;
        $authors_list .= '</li>';
    }
    $authors_list .= '</ul>';
    return $authors_list;
}
?>
<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Draft</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Draft Usulan </h1>
            <span class="badge badge-info">Total : <?= $total; ?></span>
        </div>
        <a
            href="<?= base_url("$pages/add"); ?>"
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
                        <?php if ($progress == 'error') : ?>
                            <div
                                class="alert alert-danger alert-dismissible fade show"
                                role="alert"
                            >
                                <p class="m-0">Lakukan penyesuaian draft berikut agar tidak terjadi error progress, dengan cara
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
                            </div>
                        <?php endif; // filter error
                        ?>

                        <?= form_open($pages, ['method' => 'GET']); ?>
                        <div class="row">
                            <div class="col-12 col-md-2 mb-3">
                                <label for="per_page">Data per halaman</label>
                                <?= form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"'); ?>
                            </div>
                            <div class="col-12 mb-3 <?= is_staff() ? 'col-md-4' : 'col-md-7'; ?>">
                                <label for="progress">Progress</label>
                                <?= form_dropdown('progress', $progress_options, $progress, 'id="progress" class="form-control custom-select d-block" title="Filter Progress"'); ?>
                            </div>
                            <?php if (is_staff()) : ?>
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="reprint">Tipe naskah</label>
                                    <?= form_dropdown('reprint', $reprint_options, $reprint, 'id="reprint" class="form-control custom-select d-block" title="Filter Naskah"'); ?>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="category">Kategori</label>
                                    <?= form_dropdown('category', get_dropdown_list_category(), $category, 'id="category" class="form-control custom-select d-block" title="Filter Kategori"'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($level == 'editor' || $level == 'layouter') : ?>
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="status">Status Pengerjaan</label>
                                    <?= form_dropdown('status', $status_options, $status, 'id="status" class="form-control custom-select d-block" title="Filter Status Progress"'); ?>
                                </div>
                            <?php endif ?>
                            <div class="col-12 <?= is_admin() ? 'col-md-9' : 'col-md-6'; ?> mb-3">
                                <label for="status">Pencarian</label>
                                <?= form_input('keyword', $keyword, 'placeholder="Cari berdasarkan Judul, Kategori, Tema, atau Penulis" class="form-control"'); ?>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label>&nbsp;</label>
                                <div
                                    class="btn-group btn-block"
                                    role="group"
                                    aria-label="Filter button"
                                >
                                    <button
                                        class="btn btn-secondary"
                                        type="button"
                                        onclick="location.href = '<?= base_url($pages); ?>'"
                                    > Reset</button>
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                        value="Submit"
                                    ><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <?php if ($drafts) : ?>
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
                                            style="min-width:220px;"
                                        >Kategori</th>
                                        <th
                                            scope="col"
                                            style="min-width:50px;"
                                        >Tahun</th>
                                        <?php if ($level != 'reviewer') : ?>
                                            <th
                                                scope="col"
                                                style="min-width:150px;"
                                            >Penulis</th>
                                        <?php endif; ?>
                                        <th
                                            scope="col"
                                            style="max-width:100px;"
                                        >Tanggal Masuk</th>
                                        <th
                                            scope="col"
                                            style="min-width:130px;"
                                        >Status</th>
                                        <!-- <?php if ($level == 'reviewer' or $level == 'editor' or $level == 'layouter') : ?>
                                            <th scope="col">Sisa Waktu</th>
                                        <?php endif; ?> -->
                                        <?php if (is_admin()) : ?>
                                            <th style="min-width:170px;"> &nbsp; </th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($drafts as $draft) : ?>
                                        <tr>
                                            <td class="align-middle pl-3">
                                                <?= ++$i; ?>
                                            </td>
                                            <td class="align-middle">
                                                <a
                                                    href="<?= base_url('draft/view/' . $draft->draft_id . ''); ?>"
                                                    class="font-weight-bold"
                                                >
                                                    <?= ($draft->is_reprint == 'y') ? '<span class="badge badge-warning"><i class="fa fa-redo" data-toggle="tooltip" title="Cetak Ulang"></i></span>' : ''; ?>
                                                    <?= highlight_keyword($draft->draft_title, $keyword); ?>
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                <?= $draft->category_name; ?>
                                            </td>
                                            <td class="align-middle">
                                                <?= $draft->category_year; ?>
                                            </td>
                                            <?php if ($level != 'reviewer') : ?>
                                                <td class="align-middle">
                                                    <?= isset($draft->author_name) ? highlight_keyword($draft->author_name, $keyword) : '-'; ?>
                                                    <button
                                                        type="button"
                                                        class="btn btn-link btn-sm m-0 p-0 <?= count($draft->authors) == 1 ? 'd-none' : ''; ?>"
                                                        data-container="body"
                                                        data-toggle="popover"
                                                        data-placement="right"
                                                        data-html="true"
                                                        data-trigger="hover"
                                                        data-content='<?= expand($draft->authors); ?>'
                                                    >
                                                        <i class="fa fa-users"></i>
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                            <td class="align-middle">
                                                <?= format_datetime($draft->entry_date); ?>
                                            </td>
                                            <td class="align-middle">
                                                <?php if ($level == 'reviewer') : ?>
                                                    <?= $draft->review_flag ? '<span class="badge badge-success">Sudah direview</span>' : '<span class="badge badge-danger">Belum direview</span>'; ?>
                                                <?php else : ?>
                                                    <?= draft_status_to_text($draft->draft_status); ?>
                                                <?php endif; ?>
                                            </td>
                                            <?php if ($level == 'reviewer') : ?>
                                                <td class="align-middle">
                                                    <?php if ($draft->sisa_waktu <= 0 and $draft->review_flag == '') : ?>
                                                        <?= '<span class="font-weight-bold text-danger"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>'; ?>
                                                    <?php elseif ($draft->sisa_waktu <= 0 and $draft->review_flag != '') : ?>
                                                        <?= null; ?>
                                                    <?php else : ?>
                                                        <?= $draft->sisa_waktu . ' hari'; ?>
                                                    <?php endif; ?>
                                                </td>
                                            <?php elseif ($level == 'editor') : ?>
                                                <td class="align-middle">
                                                    <!-- <?php if (!format_datetime($draft->edit_start_date)) : ?>
                                                        <span>Belum mulai</span>
                                                    <?php elseif (format_datetime($draft->edit_end_date)) : ?>
                                                        <span>Selesai</span>
                                                    <?php else : ?>
                                                        <?php if ($draft->sisa_waktu <= 0 and $draft->edit_notes == '') : ?>
                                                            <?= '<span class="font-weight-bold text-danger"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>'; ?>
                                                        <?php elseif ($draft->sisa_waktu <= 0 and $draft->edit_notes != '') : ?>
                                                            <?= null; ?>
                                                        <?php else : ?>
                                                            <?= $draft->sisa_waktu . ' hari'; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?> -->
                                                </td>
                                            <?php elseif ($level == 'layouter') : ?>
                                                <td class="align-middle">
                                                    <!-- <?php if (!format_datetime($draft->layout_start_date)) : ?>
                                                        <span>Belum mulai</span>
                                                    <?php elseif (format_datetime($draft->layout_end_date)) : ?>
                                                        <span>Selesai</span>
                                                    <?php else : ?>
                                                        <?php if ($draft->sisa_waktu <= 0 and $draft->layout_notes == '') : ?>
                                                            <?= '<span class="font-weight-bold text-danger"><i class="fa fa-info-circle"></i> Melebihi Deadline!</span>'; ?>
                                                        <?php elseif ($draft->sisa_waktu <= 0 and $draft->layout_notes != '') : ?>
                                                            <?= null; ?>
                                                        <?php else : ?>
                                                            <?= $draft->sisa_waktu . ' hari'; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?> -->
                                                </td>
                                            <?php endif; ?>

                                            <?php if (is_admin()) : ?>
                                                <td class="align-middle text-right">
                                                    <a
                                                        title="Edit"
                                                        href="<?= base_url('draft/edit/' . $draft->draft_id . ''); ?>"
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
                                                        data-target="#modal-hapus-<?= $draft->draft_id; ?>"
                                                    >
                                                        <i class="fa fa-trash-alt"></i>
                                                        <span class="sr-only">Delete</span>
                                                    </button>
                                                    <div class="text-left">
                                                        <div
                                                            class="modal modal-alert fade"
                                                            id="modal-hapus-<?= $draft->draft_id; ?>"
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
                                                                                <?= $draft->draft_title; ?></span>?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button
                                                                            type="button"
                                                                            class="btn btn-danger"
                                                                            onclick="location.href='<?= base_url('draft/delete/' . $draft->draft_id . ''); ?>'"
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
    // $("#progress").select2({
    //     placeholder: '-- Filter Progress --',
    //     allowClear: true,
    //     dropdownParent: $('#app-main')
    // });
    // $("#reprint").select2({
    //     placeholder: '-- Filter Naskah --',
    //     allowClear: true,
    //     dropdownParent: $('#app-main')
    // });
    // $("#status").select2({
    //     placeholder: '-- Filter Naskah --',
    //     allowClear: true,
    //     dropdownParent: $('#app-main')
    // });
});
</script>
