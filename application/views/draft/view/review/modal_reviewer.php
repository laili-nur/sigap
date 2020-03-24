<div class="modal fade" id="modal-review1" tabindex="-1" role="dialog" aria-labelledby="modal-review1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-overflow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Progress Review 1</h5>
            </div>
            <div class="modal-body">
                <p class="font-weight-bold">NASKAH</p>
                <?php if ($level == 'reviewer' or ($level == 'author' and $author_order == 1) or $level == 'superadmin' or $level == 'admin_penerbitan') : ?>
                    <div class="alert alert-info">Upload file naskah atau sertakan link naskah. Kosongi jika
                        file
                        naskah hard copy.</div>
                    <?= form_open_multipart('draft/upload_progress/' . $input->draft_id . '/review1_file', ' novalidate id="rev1form"'); ?>
                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                    <div class="form-group">
                        <label for="review1_file">File Naskah</label>
                        <div class="custom-file">
                            <?= form_upload('review1_file', '', 'class="custom-file-input naskah" id="review1_file"'); ?>
                            <label class="custom-file-label" for="review1_file">Pilih file</label>
                        </div>
                        <small class="form-text text-muted">Tipe file upload bertype : docx, doc, dan
                            pdf.</small>
                    </div>
                    <div class="form-group">
                        <label for="reviewer1_file_link">Link Naskah</label>
                        <div>
                            <?= form_input('reviewer1_file_link', $input->reviewer1_file_link, 'class="form-control naskah" id="reviewer1_file_link"'); ?>
                        </div>
                        <?= form_error('reviewer1_file_link'); ?>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary " type="submit" value="Submit" id="btn-upload-review1"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                    <?= form_close(); ?>
                <?php endif; ?>
                <div id="modal-review1">
                    <p>Last Upload :
                        <?= format_datetime($input->review1_upload_date); ?>,
                        <br> by :
                        <?= konversi_username_level($input->review1_last_upload); ?>
                        <?php if ($level != 'author' and $level != 'reviewer') : ?>
                            <em>(<?= $input->review1_last_upload; ?>)</em>
                        <?php endif; ?>
                    </p>
                    <?= (!empty($input->review1_file)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->review1_file . '" href="' . base_url('draftfile/' . $input->review1_file) . '" class="btn btn-success"><i class="fa fa-download"></i> Download</a>' : ''; ?>
                    <?= (!empty($input->reviewer1_file_link)) ? '<a data-toggle="tooltip" data-placement="right" title="" data-original-title="' . $input->reviewer1_file_link . '" href="' . $input->reviewer1_file_link . '" class="btn btn-success"><i class="fa fa-external-link-alt"></i> External file</a>' : ''; ?>
                </div>
                <?= form_open('draft/api_update_draft/' . $input->draft_id, 'id="formreview1_krit" novalidate=""'); ?>
                <?php if ($level != 'author') : ?>
                    <hr class="my-3">
                    <p class="font-weight-bold">REVIEW</p>
                    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                    <div class="alert alert-info">
                        <label for="kriteria1_reviewer1" class="font-weight-bold">Substansi naskah (mencerminkan adanya kontribusi dan inovasi pada pengembangan iptek,
                            seni,
                            dan budaya) :</label>
                        <div>
                            <?php
                            $kriteria1_reviewer1 = array(
                                'name'  => 'kriteria1_reviewer1',
                                'class' => 'form-control summernote-basic',
                                'id'    => 'kriteria1_reviewer1',
                                'rows'  => '6',
                                'value' => $input->kriteria1_reviewer1,
                            );
                            if ($level == 'reviewer') {
                                echo form_textarea($kriteria1_reviewer1);
                            } else {
                                echo '<div class="font-italic">' . nl2br($input->kriteria1_reviewer1) . '</div>';
                            }
                            ?>
                        </div>
                        <?php if ($level == 'reviewer') : ?>
                            <p class="m-0 p-0">Nilai</p>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_0', 1, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 1) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_1"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria1_reviewer1_1">1</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_0', 2, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 2) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_2"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria1_reviewer1_2">2</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_0', 3, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 3) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_3"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria1_reviewer1_3">3</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_0', 4, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 4) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_4"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria1_reviewer1_4">4</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_0', 5, isset($input->nilai_reviewer1[0]) && ($input->nilai_reviewer1[0] == 5) ? true : false, 'required="" class="custom-control-input" id="nilai_kriteria1_reviewer1_5"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria1_reviewer1_5">5</label>
                            </div>
                        <?php else : ?>
                            <p class="m-0 p-0">Nilai =
                                <?= isset($input->nilai_reviewer1[0]) ? $input->nilai_reviewer1[0] : ''; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="alert alert-info">
                        <label for="kriteria2_reviewer1" class="font-weight-bold">Orisinalitas Karya dan bobot ilmiah :</label>
                        <div>
                            <?php
                            $kriteria2_reviewer1 = array(
                                'name'  => 'kriteria2_reviewer1',
                                'class' => 'form-control summernote-basic',
                                'id'    => 'kriteria2_reviewer1',
                                'rows'  => '6',
                                'value' => $input->kriteria2_reviewer1,
                            );
                            if ($level == 'reviewer') {
                                echo form_textarea($kriteria2_reviewer1);
                            } else {
                                echo '<div class="font-italic">' . nl2br($input->kriteria2_reviewer1) . '</div>';
                            }
                            ?>
                        </div>
                        <?php if ($level == 'reviewer') : ?>
                            <p class="m-0 p-0">Nilai</p>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_1', 1, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_1"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria2_reviewer1_1">1</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_1', 2, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_2"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria2_reviewer1_2">2</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_1', 3, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_3"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria2_reviewer1_3">3</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_1', 4, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_4"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria2_reviewer1_4">4</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_1', 5, isset($input->nilai_reviewer1[1]) && ($input->nilai_reviewer1[1] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria2_reviewer1_5"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria2_reviewer1_5">5</label>
                            </div>
                        <?php else : ?>
                            <p class="m-0 p-0">Nilai =
                                <?= isset($input->nilai_reviewer1[1]) ? $input->nilai_reviewer1[1] : ''; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="alert alert-info">
                        <label for="kriteria3_reviewer1" class="font-weight-bold">Kemutahiran Pustaka :</label>
                        <div>
                            <?php
                            $kriteria3_reviewer1 = array(
                                'name'  => 'kriteria3_reviewer1',
                                'class' => 'form-control summernote-basic',
                                'id'    => 'kriteria3_reviewer1',
                                'rows'  => '6',
                                'value' => $input->kriteria3_reviewer1,
                            );
                            if ($level == 'reviewer') {
                                echo form_textarea($kriteria3_reviewer1);
                            } else {
                                echo '<div class="font-italic">' . nl2br($input->kriteria3_reviewer1) . '</div>';
                            }
                            ?>
                        </div>
                        <?php if ($level == 'reviewer') : ?>
                            <p class="m-0 p-0">Nilai</p>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_2', 1, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_1"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria3_reviewer1_1">1</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_2', 2, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_2"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria3_reviewer1_2">2</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_2', 3, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_3"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria3_reviewer1_3">3</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_2', 4, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_4"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria3_reviewer1_4">4</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_2', 5, isset($input->nilai_reviewer1[2]) && ($input->nilai_reviewer1[2] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria3_reviewer1_5"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria3_reviewer1_5">5</label>
                            </div>
                        <?php else : ?>
                            <p class="m-0 p-0">Nilai =
                                <?= isset($input->nilai_reviewer1[2]) ? $input->nilai_reviewer1[2] : ''; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class="alert alert-info">
                        <label for="kriteria4_reviewer1" class="font-weight-bold">Kelengkapan unsur (sebagai suatu naskah buku dan keterkaitan antarbab, sistematika)
                            :</label>
                        <div>
                            <?php
                            $kriteria4_reviewer1 = array(
                                'name'  => 'kriteria4_reviewer1',
                                'class' => 'form-control summernote-basic',
                                'id'    => 'kriteria4_reviewer1',
                                'rows'  => '6',
                                'value' => $input->kriteria4_reviewer1,
                            );
                            if ($level == 'reviewer') {
                                echo form_textarea($kriteria4_reviewer1);
                            } else {
                                echo '<div class="font-italic">' . nl2br($input->kriteria4_reviewer1) . '</div>';
                            }
                            ?>
                        </div>
                        <?php if ($level == 'reviewer') : ?>
                            <p class="m-0 p-0">Nilai</p>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_3', 1, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 1) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_1"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria4_reviewer1_1">1</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_3', 2, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 2) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_2"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria4_reviewer1_2">2</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_3', 3, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 3) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_3"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria4_reviewer1_3">3</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_3', 4, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 4) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_4"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria4_reviewer1_4">4</label>
                            </div>
                            <div class="custom-control custom-control-inline custom-radio">
                                <?= form_radio('nilai_reviewer1_3', 5, isset($input->nilai_reviewer1[3]) && ($input->nilai_reviewer1[3] == 5) ? true : false, 'required class="custom-control-input" id="nilai_kriteria4_reviewer1_5"'); ?>
                                <label class="custom-control-label" for="nilai_kriteria4_reviewer1_5">5</label>
                            </div>
                        <?php else : ?>
                            <p class="m-0 p-0">Nilai =
                                <?= isset($input->nilai_reviewer1[3]) ? $input->nilai_reviewer1[3] : ''; ?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <?php if ($level != 'author') : ?>
                        <div id="total_reviewer1">
                            <?php if (!empty($draft->nilai_total_reviewer1)) {
                                if ($draft->nilai_total_reviewer1 >= 400) {
                                    $hasil = '<div class="alert alert-success"><span class="badge badge-success">Naskah Lolos Review</span><br>';
                                    $hasil .= '<strong>Nilai total = ' . $draft->nilai_total_reviewer1 . '</strong><br>';
                                    $hasil .= 'Passing Grade = 400 <br>';
                                    $hasil .= '</div>';
                                } else {
                                    $hasil = '<div class="alert alert-danger"><span class="badge badge-danger">Naskah Tidak Lolos Review</span><br>';
                                    $hasil .= '<strong>Nilai total = ' . $draft->nilai_total_reviewer1 . '</strong><br>';
                                    $hasil .= 'Passing Grade = 400 <br>';
                                    $hasil .= '</div>';
                                }
                                echo $hasil;
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <fieldset>
                    <?php if ($level != 'author') : ?>
                        <hr class="my-3">
                        <div class="form-group">
                            <label for="cr1" class="font-weight-bold">Catatan Reviewer 1</label>
                            <?php
                            $optionscr1 = array(
                                'name'  => 'review1_notes',
                                'class' => 'form-control summernote-basic',
                                'id'    => 'cr1',
                                'rows'  => '6',
                                'value' => $input->review1_notes,
                            );
                            if ($level != 'reviewer') {
                                echo '<div class="font-italic">' . nl2br($input->review1_notes) . '</div>';
                            } else {
                                echo form_textarea($optionscr1);
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($level == 'superadmin' or $level == 'admin_penerbitan' or $level == 'author') : ?>
                        <hr class="my-3">
                        <div class="form-group">
                            <label for="cr1a" class="font-weight-bold">Catatan Admin untuk Penulis</label>
                            <?php
                            $optionscr1a = array(
                                'name'  => 'catatan_review1_admin',
                                'class' => 'form-control summernote-basic',
                                'id'    => 'cr1a',
                                'rows'  => '6',
                                'value' => $input->catatan_review1_admin,
                            );
                            if ($level == 'superadmin' or $level == 'admin_penerbitan') {
                                echo form_textarea($optionscr1a);
                            } elseif ($level == 'author') {
                                echo '<div class="font-italic">' . nl2br($input->catatan_review1_admin) . '</div>';
                            } else {
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <hr class="my-3">
                    <div class="form-group">
                        <label for="crp1" class="font-weight-bold">Catatan Penulis</label>
                        <?php
                        $optionscrp1 = array(
                            'name'  => 'review1_notes_author',
                            'class' => 'form-control summernote-basic',
                            'id'    => 'crp1',
                            'rows'  => '6',
                            'value' => $input->review1_notes_author,
                        );
                        if ($level != 'author' or $author_order != 1) {
                            echo '<div class="font-italic">' . nl2br($input->review1_notes_author) . '</div>';
                        } else {
                            echo form_textarea($optionscrp1);
                        }
                        ?>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <?php if ($level == 'reviewer') : ?>
                    <div class="card-footer-content text-muted p-0 m-0">
                        <div class="mb-1 font-weight-bold">Rekomendasi</div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <?= form_radio('review1_flag', 'y', isset($input->review1_flag) && ($input->review1_flag == 'y') ? true : false, 'required class="custom-control-input" id="review1_flagy"'); ?>
                            <label class="custom-control-label" for="review1_flagy">Setuju</label>
                        </div>
                        <div class="custom-control custom-control-inline custom-radio">
                            <?= form_radio('review1_flag', 'n', isset($input->review1_flag) && ($input->review1_flag == 'n') ? true : false, 'required class="custom-control-input" id="review1_flagn"'); ?>
                            <label class="custom-control-label" for="review1_flagn">Tidak</label>
                        </div>
                    </div>
                    <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-review1-rev">Submit</button>
                <?php else : ?>
                    <button class="btn btn-primary ml-auto" type="submit" value="Submit" id="btn-submit-review1-other">Submit</button>
                <?php endif; ?>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>