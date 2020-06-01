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
    <div class="d-flex justify-content-between align-items-center my-3">
        <div class="page-title mb-0 pb-0 h1"> Draft </div>
        <div>
            <?php if (is_admin()) : ?>
                <?php if ($input->is_reprint == 'n') : ?>
                    <button
                        type="button"
                        class="btn btn-info btn-xs"
                        onClick="location.href='<?= base_url("draft/reprint/$input->draft_id"); ?>'"
                    ><i class="fa fa-redo"></i>&nbsp; Cetak Ulang</button>
                <?php endif; ?>
                <a
                    href="<?= base_url('draft/edit/' . $input->draft_id) ?>"
                    class="btn btn-secondary btn-sm"
                ><i class="fa fa-edit fa-fw"></i> Edit Draft</a>
            <?php endif ?>
        </div>
    </div>
</header>
<div class="page-section">
    <!-- segment detail draft, penulis, reviewer, buku -->
    <?php
    $this->load->view('draft/view/detail/index');

    // desk screening tidak bisa dilihat reviewer
    if ($level != 'reviewer') {
        $this->load->view('draft/view/desk_screening_progress');
    }

    // sembunyikan semua progress jika tidak lolos desk screening
    if ($desk->worksheet_status == 1) {
        //    progress tidak bisa dilihat reviewer
        // if ($level != 'reviewer') {
        //     $this->load->view('draft/view/progress');
        // }

        // alert otorisasi penulis
        if ($level == 'author') {
            echo '<div class="alert alert-danger"><strong>PERHATIAN! </strong>Penulis pertama dapat memberikan komentar dan
        catatan, penulis kedua hanya dapat melihat progress.</div>';
        }

        // PROGRESS REVIEW khusus reviewer
        if ($level == 'reviewer') {
            $this->load->view('draft/view/review/index');
        }

        // PROGRESS REVIEW
        if ($level != 'reviewer') {
            $this->load->view('draft/view/progress');
            $this->load->view('draft/view/review/index');
            // PROGRESS EDIT
            if ($input->is_review == 'y') {
                $this->load->view('draft/view/edit/index');
                // PROGRESS LAYOUT
                if ($input->is_edit == 'y') {
                    $this->load->view('draft/view/layout/index');
                    // PROGRESS PROOFREAD
                    if ($input->is_layout == 'y') {
                        $this->load->view('draft/view/proofread/index');
                        // PROGRESS FINAL
                        if ($input->is_proofread == 'y' && is_staff()) {
                            $this->load->view('draft/view/final/index');
                        }
                    }
                }
            }
        }
    }
    ?>
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
