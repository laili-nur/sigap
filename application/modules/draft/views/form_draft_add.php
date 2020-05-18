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
                <a class="text-muted">Form</a>
            </li>
        </ol>
    </nav>
</header>
<div class="page-section">
    <div class="row">
        <div class="col-md-8">
            <section class="card">
                <div class="card-body">
                    <?= form_open_multipart($form_action, 'novalidate="" id="form_draft"'); ?>
                    <fielsdet>
                        <legend>Form Draft</legend>
                        <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : ''; ?>
                        <div class="form-group">
                            <label for="category">
                                <?= $this->lang->line('form_category_name'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?php $atribut = (!empty($this->uri->segment(3)) and $this->uri->segment(2) != 'reprint') ? 'disabled' : ''; ?>
                            <?= form_dropdown('category_id', get_dropdown_list_category(false), $input->category_id, 'id="category" class="form-control custom-select d-block ' . $atribut . '" ' . $atribut . ''); ?>
                            <small class="form-text text-muted">Kategori yang tampil adalah kategori yang statusnya
                                aktif</small>
                            <?= form_error('category_id'); ?>
                        </div>
                        <?= (!empty($this->uri->segment(3)) && isset($input->category_id)) ? form_hidden('category_id', $input->category_id) : ''; ?>
                        <hr class="my-2">
                        <div class="form-group">
                            <label for="theme">
                                <?= $this->lang->line('form_theme_name'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_dropdown('theme_id', get_dropdown_list('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme" class="form-control custom-select d-block"'); ?>
                            <?= form_error('theme_id'); ?>
                        </div>
                        <div class="form-group">
                            <label for="draft_title">
                                <?= $this->lang->line('form_draft_title'); ?>
                                <abbr title="Required">*</abbr>
                            </label>
                            <?= form_input('draft_title', $input->draft_title, 'class="form-control customer" id="draft_title"'); ?>
                            <?= form_error('draft_title'); ?>
                        </div>
                        <!-- <?php if (check_level() == 'author') : ?>
                            <div class="form-group d-none">
                                <label for="draft_title">
                                    <?= $this->lang->line('form_author_name'); ?>
                                </label>
                                <?= form_dropdown('author_id[]', get_dropdown_list('author', ['author_id', 'author_name']), check_role(), 'id="author" class="form-control custom-select" multiple="multiple"'); ?>
                                <?= form_error('author_id[]'); ?>
                            </div>
                        <?php else : ?> -->
                        <!-- <div class="form-group">
                            <label for="author_id"><?= $this->lang->line('form_author_name'); ?></label>
                            <?= form_dropdown('author_id[]', get_dropdown_list('author', ['author_id', 'author_name']), $input->author_id, 'id="author" class="form-control custom-select d-block" multiple="multiple"'); ?>
                            <?= form_error('author_id[]'); ?>
                        </div> -->
                        <!-- <div class="p-0 m-0">
                                <small class="form-text text-muted">Jika Penulis belum ada di list, tambahkan penulis di menu <a
                                        target="_blank"
                                        href="<?= base_url('author/add'); ?>"
                                    >PENULIS</a>
                                </small>
                            </div> -->
                        <!-- <div class="p-0 m-0">
                        <button
                           id="callback"
                           type="button"
                           class="btn btn-secondary btn-xs mt-2"
                        ><i
                              class="fa fa-sync"
                              id="ajax-reload-author"
                           ></i> Reload Penulis</button>
                     </div> -->

                        <!-- <?php endif; ?> -->
                        <!-- <div class="form-group">
                     <label for="draft_pages">Jumlah Halaman</label>
                     <?= form_input('draft_pages', $input->draft_pages, 'class="form-control" id="draft_pages"'); ?>
                     <?= form_error('draft_pages'); ?>
                  </div> -->

                        <div class="form-group">
                            <label for="draft_file">File Draft</label>
                            <div class="custom-file">
                                <?= form_upload('draft_file', '', 'class="custom-file-input"'); ?>
                                <label
                                    class="custom-file-label"
                                    for="draft_file"
                                >Pilih file</label>
                            </div>
                            <small class="form-text text-muted">Menerima tipe file :
                                <?= get_allowed_file_types('draft_file')['to_text']; ?></small>
                            <small class="text-danger"><?= $this->session->flashdata('draft_file_no_data'); ?></small>
                            <?= file_form_error('draft_file', '<p class="small text-danger">', '</p>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="draft_file_link">Link File Draft</label>
                            <?= form_input('draft_file_link', $input->draft_file_link, 'class="form-control" id="draft_file_link"'); ?>
                            <small class="form-text text-muted">Isikan link external file draft</small>
                            <?= form_error('draft_file_link'); ?>
                        </div>
                        </fieldset>
                        <hr>
                        <div class="form-actions">
                            <button
                                class="btn btn-primary ml-auto"
                                type="submit"
                                value="Submit"
                                id="btn-submit"
                            >Submit</button>
                        </div>
                        <?= form_close(); ?>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    loadValidateSetting();
    $("#form_draft").validate({
            rules: {
                category_id: "crequired",
                theme_id: "crequired",
                draft_title: {
                    crequired: true,
                    cminlength: 5,
                },
                "author_id[]": {
                    crequired: true,
                },
                draft_file: {
                    extension: "<?= get_allowed_file_types('draft_file')['types']; ?>",
                },
                draft_file_link: "curl"
            },
            errorElement: "span",
            errorPlacement: validateErrorPlacement,
        },
        validateSelect2()
    );

    // $("#callback").on("click",function(){
    //   console.log("cekk bro");
    //     $("#cek").load("#cek", function(){
    //       $('#author option[value=""]').detach();
    //       $("#author").select2();
    //       document.getElementById("callback").onclick = null;
    //     });
    // });

    //reload author yang baru ditambahkan
    // $("#callback").on("click", function() {
    //    $("#ajax-reload-author").addClass("fa-spin");
    //    $.get("<?php echo base_url('draft/ajax_reload_author/'); ?>",
    //       function(data) {
    //          var datax = JSON.parse(data);
    //          // var tampil = [];
    //          // for(i=0; i<datax.length; i++){
    //          //   tampil[datax[i].author_id]=datax[i].author_name;
    //          // }

    //          $('#author').find('option').remove().end();
    //          $.each(datax, (key, value) => {
    //             $("<option/>", {
    //                "value": key,
    //                "text": value
    //             }).appendTo($("#author"));
    //          });
    //          showToast("update_author");
    //          $("#ajax-reload-author").removeClass("fa-spin");
    //       });
    // });

    $.fn.select2.defaults.set('dropdownParent', '#app-main');
    $.fn.select2.defaults.set('placeholder', '-- Pilih --');

    $("#category").select2();
    $("#theme").select2();
    $('#author option[value=""]').detach();
    $("#author").select2({
        multiple: true
    });

    // urut sesuai pilihan input
    $("#author").on("select2:select", function(evt) {
        var element = evt.params.data.element;
        var $element = $(element);

        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

    // $("#form_draft").submit(function(){
    //   $('#btn-submit').attr("disabled","disabled").html("<i class='fa fa-spinner fa-spin '></i> Processing ");
    // });
});
</script>
