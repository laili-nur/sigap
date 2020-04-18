<?php $level = check_level() ?>
<div
    class="modal fade"
    id="modal-print"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-print"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-overflow">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Progress Cetak</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <ul
                class="nav nav-tabs"
                id="print-tab-wrapper"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="print-file-tab"
                        data-toggle="tab"
                        href="#print-file-tab-content"
                        role="tab"
                        aria-controls="print-file-tab-content"
                        aria-selected="true"
                    >File</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="print-comment-tab"
                        data-toggle="tab"
                        href="#print-comment-tab-content"
                        role="tab"
                        aria-controls="print-comment-tab-content"
                        aria-selected="false"
                    >Tanggapan</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="print-configuration-tab"
                        data-toggle="tab"
                        href="#print-configuration-tab-content"
                        role="tab"
                        aria-controls="print-configuration-tab-content"
                        aria-selected="false"
                    >Pengaturan</a>
                </li>
            </ul>

            <div class="modal-body py-3">
                <div
                    class="tab-content"
                    id="print-tab-content-wrapper"
                >
                    <div
                        class="tab-pane fade show active"
                        id="print-file-tab-content"
                        role="tabpanel"
                        aria-labelledby="print-file-tab"
                    >
                        <?php $this->load->view('draft/view/common/file_section', ['progress' => 'print']) ?>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="print-comment-tab-content"
                        role="tabpanel"
                        aria-labelledby="print-comment-tab"
                    >
                        <div id="print-comment-info">
                            <fieldset>
                                <?php if ($level != 'author') : ?>
                                    <div class="form-group">
                                        <label
                                            for="printer-print-notes"
                                            class="font-weight-bold"
                                        >Catatan Staff</label>
                                        <?php
                                        if (!is_staff()) {
                                            echo "<div class='font-italic' id='printer-print-notes'>" . $input->print_notes . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "printer-print-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "printer-print-notes",
                                                'rows'  => '6',
                                                'value' => $input->print_notes
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </fieldset>

                            <div class="d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-light ml-auto"
                                    data-dismiss="modal"
                                >Close</button>
                                <button
                                    id="btn-submit-print"
                                    class="btn btn-primary"
                                    type="button"
                                >Submit</button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="print-configuration-tab-content"
                        role="tabpanel"
                        aria-labelledby="print-configuration-tab"
                    >
                        <div id="print-configuration-section">
                            <fieldset>
                                <div class="form-group">
                                    <label>Tipe Printing</label>
                                    <div>
                                        <div
                                            class="btn-group btn-group-toggle"
                                            data-toggle="buttons"
                                        >
                                            <label class="btn btn-secondary <?= ($input->printing_type == 'p') ? 'active' : ''; ?>">
                                                <?= form_radio(
                                                    'printing_type',
                                                    'p',
                                                    isset($input->printing_type) && ($input->printing_type == 'p') ? true : false,
                                                    'class="custom-control-input"'
                                                ); ?> POD</label>
                                            <label class="btn btn-secondary <?= ($input->printing_type == 'o') ? 'active' : ''; ?>">
                                                <?= form_radio(
                                                    'printing_type',
                                                    'o',
                                                    isset($input->printing_type) && ($input->printing_type == 'o') ? true : false,
                                                    'class="custom-control-input"'
                                                ); ?> Offset</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="serial_num">Serial Number Total</label>
                                    <?php
                                    $data = array(
                                        'name' => 'serial_num',
                                        'value' => $input->serial_num,
                                        'class' => 'form-control',
                                        'type' => 'number'
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="serial_num_per_year">Serial Number Per Tahun</label>
                                    <?php
                                    $data = array(
                                        'name' => 'serial_num_per_year',
                                        'value' => $input->serial_num_per_year,
                                        'class' => 'form-control',
                                        'type' => 'number'
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="copies_num">Jumlah Copy</label>
                                    <?php
                                    $data = array(
                                        'name' => 'copies_num',
                                        'value' => $input->copies_num,
                                        'class' => 'form-control',
                                        'type' => 'number'
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="cetakan_ke">Cetakan ke</label>
                                    <?php
                                    $data = array(
                                        'name' => 'cetakan_ke',
                                        'value' => $input->cetakan_ke,
                                        'class' => 'form-control',
                                        'type' => 'number'
                                    );
                                    echo form_input($data);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="kertas_isi">Kertas isi</label>
                                    <?= form_input('kertas_isi', $input->kertas_isi, 'class="form-control"'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="kertas_cover">Kertas cover</label>
                                    <?= form_input('kertas_cover', $input->kertas_cover, 'class="form-control"'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="ukuran">Ukuran</label>
                                    <?= form_input('ukuran', $input->ukuran, 'class="form-control"'); ?>
                                </div>
                            </fieldset>

                            <div class="d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-light ml-auto"
                                    data-dismiss="modal"
                                >Close</button>
                                <button
                                    id="btn-submit-print-configuration"
                                    class="btn btn-primary"
                                    type="button"
                                >Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const draftId = $('[name=draft_id]').val();

    // reload segmen ketika modal diclose
    $('#print-progress-wrapper').on('shown.bs.modal', `#modal-print`, function() {
        // reload ketika modal diclose
        $(`#modal-print`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#print-progress-wrapper').load(' #print-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })
    })

    // submit progress print
    $('#print-progress-wrapper').on('click', `#btn-submit-print`, function() {
        const $this = $(this);

        const printData = {
            [`print_notes`]: $(`#printer-print-notes`).val(),
            [`print_notes_author`]: $(`#author-print-notes`).val(),
        }

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draftId,
            datatype: "JSON",
            data: printData,
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#print-configutarion-tab-content`).load(` #print-configutarion-info`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
        });
    });


    // submit print configuration
    $('#print-progress-wrapper').on('click', `#btn-submit-print-configuration`, function() {
        const $this = $(this);

        const printConfigData = {
            ['printing_type']: $('[name=printing_type]:checked').val(),
            ['serial_num']: $('[name=serial_num]').val(),
            ['serial_num_per_year']: $('[name=serial_num_per_year]').val(),
            ['copies_num']: $('[name=copies_num]').val(),
            ['cetakan_ke']: $('[name=cetakan_ke]').val(),
            ['kertas_isi']: $('[name=kertas_isi]').val(),
            ['kertas_cover']: $('[name=kertas_cover]').val(),
            ['ukuran']: $('[name=ukuran]').val(),
        }

        $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draftId,
            datatype: "JSON",
            data: printConfigData,
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#print-configuration-tab-content`).load(` #print-configuration-section`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
            },
        });
    });
})
</script>
