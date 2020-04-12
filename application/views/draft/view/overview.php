<?php $level = check_level(); ?>
<header class="page-title-bar">
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

    <!-- progress review -->
    <?php $this->load->view('draft/view/review/index'); ?>

    <?php if ($level != 'reviewer') : ?>
        <?php if ($input->is_review == 'y') : ?>
            <?php $this->load->view('draft/view/edit/index'); ?>
        <?php endif; ?>
        <?php if ($input->is_edit == 'y') : ?>
            <?php $this->load->view('draft/view/layout/index'); ?>
        <?php endif; ?>
        <?php if ($input->is_layout == 'y') : ?>
            <?php $this->load->view('draft/view/proofread'); ?>
        <?php endif; ?>
        <?php if ($input->is_proofread == 'y' and $level != 'author' and $level != 'reviewer') : ?>
            <?php $this->load->view('draft/view/print'); ?>
        <?php elseif ($input->is_proofread == 'y' and $input->is_print == 'n' and $level == 'author' or $level == 'reviewer') : ?>
            <div class="alert alert-info">
                <h5 class="alert-heading">Proses Cetak</h5>
                Draft ini sedang dalam proses pencetakan.
            </div>
        <?php elseif ($input->is_print == 'y' and $input->draft_status != 14 and $level == 'author' or $level == 'reviewer') : ?>
            <div class="alert alert-info">
                <h5 class="alert-heading">Proses Final</h5>
                Draft ini sedang dalam proses finalisasi.
            </div>
        <?php endif; ?>
        <?php if ($level == 'superadmin' or $level == 'admin_penerbitan') : ?>
            <div class="el-example mx-3 mx-md-0">
                <?php
                $hidden_date = array(
                    'type'  => 'hidden',
                    'id'    => 'finish_date',
                    'value' => date('Y-m-d H:i:s'),
                );
                echo form_input($hidden_date); ?>
                <?= ($input->is_print == 'y') ? '' : '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> Proses cetak belum disetujui</small></div>'; ?>
                <?= ($input->print_file != '' or $input->print_file_link != '') ? '' : '<div class="m-0"><small class="text-danger"><i class="fa fa-exclamation-triangle"></i> File/Link cetak belum ada</small></div>'; ?>
                <button
                    class="btn btn-primary"
                    data-toggle="modal"
                    data-target="#modalsimpan"
                    <?= ($input->is_print == 'y' and ($input->print_file != '' or $input->print_file_link != '')) ? '' : 'disabled'; ?>
                >Simpan jadi buku</button>
                <button
                    class="btn btn-danger"
                    data-toggle="modal"
                    data-target="#modaltolak"
                    <?= ($input->is_print == 'y' and ($input->print_file != '' or $input->print_file_link != '')) ? '' : 'disabled'; ?>
                >Tolak</button>
            </div>
            <div
                class="modal modal-warning fade"
                id="modalsimpan"
                tabindex="-1"
                role="dialog"
                aria-labelledby="modalsimpan"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog"
                    role="document"
                >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                        <i class="fa fa-bullhorn text-yellow mr-1"></i> Konfirmasi Draft Final
                    </h5>
                        </div>
                        <div class="modal-body">
                            <p>Draft <span class="font-weight-bold">
                            <?= $input->draft_title; ?></span> sudah final dan akan disimpan jadi buku?</p>
                            <div class="alert alert-warning">Tanggal selesai draft akan tercatat ketika klik Submit</div>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-primary"
                                id="draft-setuju"
                                draft-title="<?= $draft->draft_title; ?>"
                                draft-file="<?= $draft->print_file; ?>"
                                value="14"
                            >Submit</button>
                            <button
                                type="button"
                                class="btn btn-light"
                                data-dismiss="modal"
                            >Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="modal modal-alert fade"
                id="modaltolak"
                tabindex="-1"
                role="dialog"
                aria-labelledby="modaltolak"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog"
                    role="document"
                >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                        <i class="fa fa-exclamation-triangle text-red mr-1"></i> Tolak Draft
                    </h5>
                        </div>
                        <div class="modal-body">
                            <p>Draft <span class="font-weight-bold">
                            <?= $input->draft_title; ?></span> ditolak?</p>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-danger"
                                type="submit"
                                id="draft-tolak"
                                value="99"
                            >Tolak</button>
                            <button
                                type="button"
                                class="btn btn-light"
                                data-dismiss="modal"
                            >Close</button>
                        </div>
                    </div>
                </div>
            </div>
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
    function activaTab(tab) {
        $('.nav-tabs.card-header-tabs a[href="#' + tab + '"]').tab('show');
    };
    $('#pil-rev').click(function() {
        $('html, body').animate({
            scrollTop: 1
        }, 400);
        setTimeout(function() {
            activaTab('data-reviewer');
        }, 500);
        return false;
    });

    $("#pilih_editor").select2({
        placeholder: '-- Pilih --',
        dropdownParent: $('#piliheditor'),
        allowClear: true
    });
    $("#pilih_layouter").select2({
        placeholder: '-- Pilih --',
        dropdownParent: $('#pilihlayouter'),
        allowClear: true
    });

    $('#draft-setuju').on('click', function() {
        var $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id = $('[name=draft_id]').val();
        let draft_title = $this.attr('draft-title');
        let draft_file = $this.attr('draft-file');
        let action = $('#draft-setuju').val();
        let finish_date = $('#finish_date').val();
        let cek = '<?php echo base_url("draft/copyToBook/"); ?>' + id;
        console.log(cek);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + id,
            datatype: "JSON",
            data: {
                draft_status: action,
                finish_date: finish_date,
            },
            success: function(data) {
                let datax = JSON.parse(data);
                console.log(datax);
                $this.removeAttr("disabled").html("Submit");
                if (datax.status == true) {
                    show_toast('111');
                    location.href = '<?php echo base_url("draft/copyToBook/"); ?>' + id;
                } else {
                    show_toast('000');
                }
            }
        });

        // $('#draft_aksi').modal('hide');
        // location.reload();
        return false;
    });

    $('#draft-tolak').on('click', function() {
        var $this = $(this);
        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
        let id = $('[name=draft_id]').val();
        let action = $('#draft-tolak').val();
        console.log(action);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + id,
            datatype: "JSON",
            data: {
                draft_status: action,
            },
            success: function(data) {
                let datax = JSON.parse(data);
                console.log(datax);
                $this.removeAttr("disabled").html("Tolak");
                if (datax.status == true) {
                    show_toast('111');
                } else {
                    show_toast('000');
                }
                location.href = '<?php echo base_url("draft/view/"); ?>' + id;
            }
        });

        // $('#draft_aksi').modal('hide');
        // location.reload();
        return false;
    });
});
</script>
