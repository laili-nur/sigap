<?php $level = check_level() ?>
<?php
$all_criteria = [
    [
        'number' => 1,
        'title' => 'Substansi naskah (mencerminkan adanya kontribusi dan inovasi pada pengembangan iptek, seni, dan budaya)'
    ],
    [
        'number' => 2,
        'title' => 'Orisinalitas Karya dan bobot ilmiah'
    ],
    [
        'number' => 3,
        'title' => 'Kemutahiran Pustaka'
    ],
    [
        'number' => 4,
        'title' => 'Kelengkapan unsur (sebagai suatu naskah buku dan keterkaitan antarbab, sistematika)'
    ],
]

?>
<div
    class="modal fade"
    id="modal-<?= $progress ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modal-<?= $progress ?>"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-lg modal-dialog-overflow"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Progress <?= $progress == 'review1' ? 'Review #1' : 'Review #2' ?> </h5>
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
                id="<?= $progress ?>-tab-wrapper"
                role="tablist"
            >
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="<?= $progress ?>-file-tab"
                        data-toggle="tab"
                        href="#<?= $progress ?>-file-tab-content"
                        role="tab"
                        aria-controls="<?= $progress ?>-file-tab-content"
                        aria-selected="true"
                    >File</a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="<?= $progress ?>-comment-tab"
                        data-toggle="tab"
                        href="#<?= $progress ?>-comment-tab-content"
                        role="tab"
                        aria-controls="<?= $progress ?>-comment-tab-content"
                        aria-selected="false"
                    >Tanggapan</a>
                </li>
                <?php if ($level != 'author') : ?>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            id="<?= $progress ?>-score-tab"
                            data-toggle="tab"
                            href="#<?= $progress ?>-score-tab-content"
                            role="tab"
                            aria-controls="<?= $progress ?>-score-tab-content"
                            aria-selected="false"
                        >Penilaian</a>
                    </li>
                <?php endif ?>
            </ul>

            <div class="modal-body py-3">
                <div
                    class="tab-content"
                    id="<?= $progress ?>-tab-content-wrapper"
                >
                    <div
                        class="tab-pane fade show active"
                        id="<?= $progress ?>-file-tab-content"
                        role="tabpanel"
                        aria-labelledby="<?= $progress ?>-file-tab"
                    >
                        <!-- $progress review ada dua: review1 dan review2, menggunakan modal review ini  -->
                        <?php $this->load->view('draft/view/common/file_section', ['progress' => $progress]) ?>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="<?= $progress ?>-comment-tab-content"
                        role="tabpanel"
                        aria-labelledby="<?= $progress ?>-comment-tab"
                    >
                        <div id="<?= $progress ?>-comment-section">
                            <fieldset>
                                <!-- CATATAN REVIEWER UNTUK STAFF/ADMIN -->
                                <?php if ($level != 'author') : ?>
                                    <div class="form-group">
                                        <label
                                            for="reviewer-<?= $progress ?>-notes"
                                            class="font-weight-bold"
                                        >Catatan Reviewer untuk Admin</label>
                                        <?php
                                        if (!is_admin() && $level != 'reviewer') {
                                            echo "<div class='font-italic' id='reviewer-{$progress}-notes'>" . $input->{"{$progress}_notes"} . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "reviewer-{$progress}-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "reviewer-{$progress}-notes",
                                                'rows'  => '6',
                                                'value' => $input->{"{$progress}_notes"}
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>


                                <!-- CATATAN ADMIN UNTUK AUTHOR -->
                                <?php if (is_admin() || $level == 'author') : ?>
                                    <hr class="my-3">
                                    <div class="form-group">
                                        <label
                                            for="admin-<?= $progress ?>-notes"
                                            class="font-weight-bold"
                                        >Catatan Admin untuk Penulis</label>
                                        <?php
                                        if (!is_admin() && $level != 'reviewer') {
                                            echo "<div class='font-italic' id='admin-{$progress}-notes'>" . $input->{"{$progress}_notes_admin"} . "</div>";
                                        } else {
                                            echo form_textarea([
                                                'name'  => "admin-{$progress}-notes",
                                                'class' => 'form-control summernote-basic',
                                                'id'    => "admin-{$progress}-notes",
                                                'rows'  => '6',
                                                'value' => $input->{"{$progress}_notes_admin"}
                                            ]);
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>


                                <hr class="my-3">
                                <div class="form-group">
                                    <label
                                        for="author-<?= $progress ?>-notes"
                                        class="font-weight-bold"
                                    >Catatan Penulis</label>
                                    <?php
                                    if (!is_admin() && ($level != 'author' || $author_order != 1)) {
                                        echo "<div class='font-italic' id='author-{$progress}-notes'>" . $input->{"{$progress}_notes_author"} . "</div>";
                                    } else {
                                        echo form_textarea([
                                            'name'  => "author-{$progress}-notes",
                                            'class' => 'form-control summernote-basic',
                                            'id'    => "author-{$progress}-notes",
                                            'rows'  => '6',
                                            'value' => $input->{"{$progress}_notes_author"}

                                        ]);
                                    }
                                    ?>
                                </div>
                            </fieldset>
                            <div class="d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-light ml-auto"
                                    data-dismiss="modal"
                                >Close</button>
                                <button
                                    id="btn-submit-comment-<?= $progress ?>"
                                    class="btn btn-primary"
                                    type="button"
                                >Submit</button>
                            </div>
                        </div>
                    </div>
                    <?php if ($level != 'author') : ?>
                        <div
                            class="tab-pane fade"
                            id="<?= $progress ?>-score-tab-content"
                            role="tabpanel"
                            aria-labelledby="<?= $progress ?>-score-tab"
                        >
                            <div id="<?= $progress ?>-score-section">
                                <p class="font-weight-bold">KONTEN REVIEW</p>
                                <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                                <?php foreach ($all_criteria as $criteria_key => $criteria) : ?>
                                    <div class="alert alert-info">
                                        <label class="font-weight-bold"><?= $criteria['title'] ?></label>
                                        <textarea
                                            type="textarea"
                                            name="<?= "criteria{$criteria['number']}-{$progress}" ?>"
                                            id="<?= "criteria{$criteria['number']}-{$progress}" ?>"
                                            class="form-control summernote-basic"
                                            rows="6"
                                        ><?= $input->{"{$progress}_criteria{$criteria['number']}"} ?></textarea>

                                        <hr class="my-3">

                                        <p class="m-0 p-0">Nilai</p>
                                        <?php for ($j = 1; $j <= 5; $j++) :  ?>
                                            <div class="custom-control custom-control-inline custom-radio">
                                                <input
                                                    id="<?= "score{$j}-criteria{$criteria['number']}-{$progress}" ?>"
                                                    name="<?= "score-criteria{$criteria['number']}-{$progress}" ?>"
                                                    value="<?= $j ?>"
                                                    type="radio"
                                                    class="custom-control-input"
                                                    <?= $input->{"{$progress}_score"} && $input->{"{$progress}_score"}[$criteria_key] == $j ? 'checked' : '' ?>
                                                />
                                                <label
                                                    class="custom-control-label"
                                                    for="<?= "score{$j}-criteria{$criteria['number']}-{$progress}" ?>"
                                                ><?= $j ?></label>
                                            </div>
                                        <?php endfor ?>
                                    </div>
                                <?php endforeach ?>

                                <div id="nilai-wrapper">
                                    <div class="alert <?= $input->{"{$progress}_total_score"} >= 400 ? 'alert-success' : 'alert-danger' ?>">
                                        <p class="badge <?= $input->{"{$progress}_total_score"} >= 400 ? 'badge-success' : 'badge-danger' ?>">Naskah Lolos Review</p>
                                        <p class="mb-0">
                                            <span>Nilai total :</span>
                                            <strong><?= $input->{"{$progress}_total_score"} ?></strong>
                                        </p>
                                        <p class="mb-0">Passing Grade = 400</p>
                                    </div>
                                </div>

                                <?php if (is_admin() || $level == 'reviewer') : ?>
                                    <div class="card-footer-content text-muted p-0 m-0">
                                        <div class="mb-1 font-weight-bold">Rekomendasi</div>
                                        <div class="custom-control custom-control-inline custom-radio">
                                            <input
                                                type="radio"
                                                name="<?= $progress ?>-flag"
                                                id="<?= $progress ?>-flag-accept"
                                                class="custom-control-input"
                                                value="y"
                                                <?= $input->{"{$progress}_flag"} == 'y' ? 'checked' : ''  ?>
                                            />
                                            <label
                                                class="custom-control-label"
                                                for="<?= $progress ?>-flag-accept"
                                            >Setuju</label>
                                        </div>

                                        <div class="custom-control custom-control-inline custom-radio">
                                            <input
                                                type="radio"
                                                name="<?= $progress ?>-flag"
                                                id="<?= $progress ?>-flag-decline"
                                                class="custom-control-input"
                                                value="n"
                                                <?= $input->{"{$progress}_flag"} == 'n' ? 'checked' : ''  ?>
                                            />
                                            <label
                                                class="custom-control-label"
                                                for="<?= $progress ?>-flag-decline"
                                            >Tolak</label>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-end">
                                    <button
                                        type="button"
                                        class="btn btn-light ml-auto"
                                        data-dismiss="modal"
                                    >Close</button>
                                    <button
                                        id="btn-submit-score-<?= $progress ?>"
                                        class="btn btn-primary"
                                        type="button"
                                    >Submit</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // contoh progress = 'review1','review2,'edit','layout','proofread','print'
    const progress = "<?= $progress == 'review1' || $progress == 'review2' ? 'review' : $progress ?>"
    // identifier khusus untuk progress review
    // selain progress review, identifier == progress
    const identifier = '<?= $progress ?>'

    const draftId = $('[name=draft_id]').val();

    // reload segmen ketika modal diclose
    $('#review-progress-wrapper').on('shown.bs.modal', `#modal-${identifier}`, function() {
        // reload ketika modal diclose
        $(`#modal-${identifier}`).off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
            $('#review-progress-wrapper').load(' #review-progress', function() {
                // reinitiate flatpickr modal after load
                init_flatpickr_modal()
            });
        })
    })

    // submit score review
    $('#review-progress-wrapper').on('click', `#btn-submit-score-${identifier}`, function() {
        const $this = $(this);

        // nilai kriteria
        let nilai = [];
        for (let k = 1; k <= 4; k++) {
            nilai.push($(`[name=score-criteria${k}-${identifier}]:checked`).val() || 0)
        }
        nilai = nilai.join()

        const reviewData = {
            [`${identifier}_flag`]: $(`[name=${identifier}-flag]:checked`).val(),
            [`${identifier}_criteria1`]: $(`#criteria1-${identifier}`).val(),
            [`${identifier}_criteria2`]: $(`#criteria2-${identifier}`).val(),
            [`${identifier}_criteria3`]: $(`#criteria3-${identifier}`).val(),
            [`${identifier}_criteria4`]: $(`#criteria4-${identifier}`).val(),
            [`${identifier}_score`]: nilai
        }

        sendData(reviewData, 'score', $this)
    });


    // submit comment review
    $('#review-progress-wrapper').on('click', `#btn-submit-comment-${identifier}`, function() {
        const $this = $(this);

        const reviewData = {
            [`${identifier}_notes`]: $(`#reviewer-${identifier}-notes`).val(),
            [`${identifier}_notes_author`]: $(`#author-${identifier}-notes`).val(),
            [`${identifier}_notes_admin`]: $(`#admin-${identifier}-notes`).val(),
        }

        sendData(reviewData, 'comment', $this)
    });

    function sendData(reviewData, type, self) {
        // type: score || comment
        self.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('draft/api_update_draft/'); ?>" + draftId,
            datatype: "JSON",
            data: reviewData,
            success: function(res) {
                console.log(res);
                show_toast(true, res.data);
                $(`#${identifier}-${type}-tab-content`).load(` #${identifier}-${type}-section`)
            },
            error: function(err) {
                console.log(err);
                show_toast(false, err.responseJSON.message);
                self.removeAttr("disabled").html("Submit");
            },
        });
    }
})
</script>
