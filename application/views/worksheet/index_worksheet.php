<?php
$per_page = $this->input->get('per_page') ?? 10;
$keyword  = $this->input->get('keyword');
$status   = $this->input->get('status');
$reprint  = $this->input->get('reprint');
$revise   = $this->input->get('revise');
$page     = $this->uri->segment(2);
// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;

$status_options = [
    ''         => '- Filter Status -',
    'waiting'  => ' Menunggu',
    'approved' => ' Diterima',
    'rejected' => ' Ditolak',
];

$reprint_options = [
    ''  => '- Filter Tipe Naskah -',
    'n' => 'Naskah Baru',
    'y' => 'Naskah Cetak Ulang',
];

$revise_options = [
    ''  => '- Filter Revisi -',
    'n' => 'Tidak Revisi',
    'y' => 'Revisi',
];

$worksheet_status_badge = [
    0 => '<span class="badge badge-warning">Menunggu</span>',
    1 => '<span class="badge badge-success">Diterima</span>',
    2 => '<span class="badge badge-danger">Ditolak</span>',
];

function generate_worksheet_action($worksheet_id)
{
    return html_escape('
    <div class="list-group list-group-bordered" style="margin: -9px -15px;border-radius:0;">
      <a href="' . base_url("worksheet/action/{$worksheet_id}/1") . '" class="list-group-item list-group-item-action p-2">
        <div class="list-group-item-figure">
        <div class="tile bg-success">
        <span class="fa fa-check"></span>
        </div>
        </div>
        <div class="list-group-item-body"> Setuju </div>
      </a>
      <a href="' . base_url("worksheet/action/{$worksheet_id}/2") . '" class="list-group-item list-group-item-action p-2">
        <div class="list-group-item-figure">
        <div class="tile bg-danger">
        <span class="fa fa-ban"></span>
        </div>
        </div>
        <div class="list-group-item-body"> Tolak </div>
      </a>
    </div>
    ');
}
?>

<header class="page-title-bar">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?=base_url();?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item active">
                <a class="text-muted">Lembar Kerja</a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Lembar Kerja </h1>
            <span class="badge badge-info">Total : <?=$total;?></span>
        </div>
    </div>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-12">
            <section class="card card-fluid">
                <div class="card-body p-0">
                    <div class="p-3">
                        <div
                            class="alert alert-info alert-dismissible fade show"
                            role="alert"
                        >
                            <h5>Info</h5>
                            <p class="m-0">Klik tombol <button class="btn btn-sm btn-secondary"><i
                                        class="fa fa-thumbs-up"
                                    ></i>
                                    Aksi</button> untuk menyetujui atau menolak draft sesuai dengan keputusan desk
                                screening</p>
                            <p class="m-0">Klik link di kolom <em>Judul draft</em> untuk menuju draft yang terkait</p>
                            <p class="m-0">Klik link di kolom <em>Nomer lembar kerja</em> untuk memasukkan keterangan
                                desk
                                screening</p>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?=form_open($pages, ['method' => 'GET']);?>
                        <div class="row">
                            <div class="col-12 col-md-2 mb-3">
                                <?=form_dropdown('per_page', get_per_page_options(), $per_page, 'id="per_page" class="form-control custom-select d-block" title="List per page"');?>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <?=form_dropdown('status', $status_options, $status, 'id="status" class="form-control custom-select d-block" title="Status"');?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <?=form_dropdown('reprint', $reprint_options, $reprint, 'id="reprint" class="form-control custom-select d-block" title="Filter Cetak Ulang"');?>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <?=form_dropdown('revise', $revise_options, $revise, 'id="revise" class="form-control custom-select d-block" title="Filter Revisi"');?>
                            </div>
                            <div class="col-12 col-md-9 mb-3">
                                <?=form_input('keyword', $keyword, ['placeholder' => 'Cari berdasarkan Nomer Lembar Kerja atau Judul Draft', 'class' => 'form-control']);?>
                            </div>
                            <div class="col-12 col-md-3">
                                <div
                                    class="btn-group btn-block"
                                    role="group"
                                    aria-label="Filter button"
                                >
                                    <button
                                        class="btn btn-secondary"
                                        type="button"
                                        onclick="location.href = '<?=base_url($pages);?>'"
                                    > Reset</button>
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                        value="Submit"
                                    ><i class="fa fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                        <?=form_close();?>
                    </div>
                    <?php if ($worksheets): ?>
                    <div class="double-scroll">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th
                                        scope="col"
                                        class="pl-4"
                                    >No</th>
                                    <th
                                        scope="col"
                                        style="min-width:120px;"
                                    >Nomor Lembar Kerja</th>
                                    <th
                                        scope="col"
                                        style="min-width:350px;"
                                    >Judul Draft</th>
                                    <th scope="col">Tahun Masuk</th>
                                    <th scope="col">Revisi</th>
                                    <th scope="col">PIC</th>
                                    <th scope="col">Status</th>
                                    <!-- <th scope="col">Deadline</th> -->
                                    <!-- <th scope="col">Tanggal Selesai</th> -->
                                    <th style="min-width:150px;"> &nbsp; </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($worksheets as $worksheet): ?>
                                <tr>
                                    <td class="align-middle pl-4"><?=++$i;?></td>
                                    <td class="align-middle"><a
                                            title="Lihat Desk Screening"
                                            href="<?=base_url('worksheet/edit/' . $worksheet->worksheet_id);?>"
                                        ><?=highlight_keyword($worksheet->worksheet_num, $keyword);?></a></td>
                                    <td class="align-middle">
                                        <a
                                            title="Lihat detail draft"
                                            href="<?=base_url('draft/view/' . $worksheet->draft_id);?>"
                                        >
                                            <?=($worksheet->is_reprint == 'y') ? '<span class="badge badge-warning"><i class="fa fa-redo" data-toggle="tooltip" title="Cetak Ulang"></i></span>' : '';?>
                                            <?=highlight_keyword($worksheet->draft_title, $keyword);?>
                                        </a>
                                    </td>
                                    <td class="align-middle"><?=date('Y', strtotime($worksheet->entry_date));?></td>
                                    <td class="align-middle">
                                        <?=$worksheet->is_revise == 'y' ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';?>
                                    </td>
                                    <td class="align-middle"><?=$worksheet->worksheet_pic;?></td>
                                    <td class="align-middle"><?=$worksheet_status_badge[$worksheet->worksheet_status];?>
                                    </td>
                                    <!-- <td class="align-middle"> <?=format_datetime($worksheet->worksheet_deadline);?></td> -->
                                    <!-- <td class="align-middle"> <?=format_datetime($worksheet->worksheet_end_date);?></td> -->
                                    <td class="align-middle text-right">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-secondary"
                                            data-container="body"
                                            data-toggle="popover"
                                            data-placement="left"
                                            data-html="true"
                                            data-content="<?=generate_worksheet_action($worksheet->worksheet_id);?>"
                                            data-trigger="focus"
                                        >
                                            <i class="fa fa-thumbs-up"></i> Aksi
                                        </button>
                                        <a
                                            title="Edit"
                                            href="<?=base_url('worksheet/edit/' . $worksheet->worksheet_id . '');?>"
                                            class="btn btn-sm btn-secondary"
                                        >
                                            <i class="fa fa-pencil-alt"></i>
                                            <span class="sr-only">Edit</span>
                                        </a>
                                        <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p class="text-center">Data tidak tersedia</p>
                    <?php endif;?>
                    <?=$pagination ?? null;?>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    doublescroll();
});
</script>