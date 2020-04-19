<?php $level = check_level(); ?>
<header class="page-title-bar mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('draft'); ?>">Draft</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">
                    <?= $input->draft_title; ?></a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"> Draft </h1>
        </div>
    </div>
</header>
<div class="page-section">
    <!-- segment detail draft, penulis, reviewer, buku -->
    <?php $this->load->view('draft/view/detail/index'); ?>

    <!-- desk screening tidak bisa dilihat reviewer -->
    <?php if ($level != 'reviewer') : ?>
        <?php $this->load->view('draft/view/desk_screening_progress'); ?>
    <?php endif; ?>


    <!-- sembunyikan semua progress jika tidak lolos desk screening -->
    <?php if ($desk->worksheet_status != 1) {
        die();
    } ?>

    <!-- progress tidak bisa dilihat reviewer -->
    <?php if ($level != 'reviewer') : ?>
        <?php $this->load->view('draft/view/progress'); ?>
    <?php endif; ?>

    <!-- alert otorisasi penulis -->
    <?php if ($level == 'author') : ?>
        <div class="alert alert-danger"><strong>PERHATIAN! </strong>Penulis pertama dapat memberikan komentar dan
            catatan, penulis kedua hanya dapat melihat progress.</div>
    <?php endif; ?>

    <!-- PROGRESS REVIEW -->
    <?php $this->load->view('draft/view/review/index'); ?>

    <?php if ($level != 'reviewer') : ?>
        <!-- PROGRESS EDIT -->
        <?php if ($input->is_review == 'y') : ?>
            <?php $this->load->view('draft/view/edit/index'); ?>
        <?php endif; ?>

        <!-- PROGRESS LAYOUT -->
        <?php if ($input->is_edit == 'y') : ?>
            <?php $this->load->view('draft/view/layout/index'); ?>
        <?php endif; ?>

        <!-- PROGRESS PROOFREAD -->
        <?php if ($input->is_layout == 'y') : ?>
            <?php $this->load->view('draft/view/proofread/index'); ?>
        <?php endif; ?>

        <!-- PROGRESS CETAK -->
        <?php if ($input->is_proofread == 'y' && is_staff()) : ?>
            <?php $this->load->view('draft/view/print/index'); ?>
        <?php elseif ($input->is_print == 'y' and $input->draft_status != 14 and $level == 'author' or $level == 'reviewer') : ?>
            <div class="alert alert-info">
                <h5 class="alert-heading">Proses</h5>
                Draft sedang dalam proses.
            </div>
        <?php endif; ?>

        <!-- PROGRESS FINAL -->
        <?php if (is_admin()) : ?>
            <?php $this->load->view('draft/view/final/index'); ?>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
$(document).ready(function() {
    loadValidateSetting();

    $('#entry_date').flatpickr({
        disableMobile: true,
        altInput: true,
        altFormat: 'j F Y',
        dateFormat: 'Y-m-d',
        inline: true
    });

    //scroll to top dan ganti tab
    // function activaTab(tab) {
    //     $('.nav-tabs.card-header-tabs a[href="#' + tab + '"]').tab('show');
    // };
    // $('#pil-rev').click(function() {
    //     $('html, body').animate({
    //         scrollTop: 1
    //     }, 400);
    //     setTimeout(function() {
    //         activaTab('data-reviewer');
    //     }, 500);
    //     return false;
    // });

    // $("#pilih_editor").select2({
    //     placeholder: '-- Pilih --',
    //     dropdownParent: $('#piliheditor'),
    //     allowClear: true
    // });
    // $("#pilih_layouter").select2({
    //     placeholder: '-- Pilih --',
    //     dropdownParent: $('#pilihlayouter'),
    //     allowClear: true
    // });
});
</script>
