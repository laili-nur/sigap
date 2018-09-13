<div class="row">
    <div class="col-10 no-margin">
        <h2>Draft</h2>
    </div>
</div>
<?= form_open_multipart($form_action) ?>

    <?= isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '' ?>

    <!-- work_unit_id -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Category Name', 'category_name', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_dropdown('category_id', getDropdownList('category', ['category_id', 'category_name']), $input->category_id, 'id="category"') ?>
        </div>
        <div class="col-4">
            <?= form_error('category_id') ?>
        </div>
    </div>
    
        <!-- theme_id -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Theme Name', 'theme_name', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_dropdown('theme_id', getDropdownList('theme', ['theme_id', 'theme_name']), $input->theme_id, 'id="theme"') ?>
        </div>
        <div class="col-4">
            <?= form_error('theme_id') ?>
        </div>
    </div>

        <!-- draft_title -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Draft Title', 'draft_title', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('draft_title', $input->draft_title) ?>
        </div>
        <div class="col-4">
            <?= form_error('draft_title') ?>
        </div>
    </div>
        
    <!-- draft_file -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Draft File', 'draft_file', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_upload('draft_file') ?>
        </div>
        <div class="col-4">
            <?= fileFormError('draft_file', '<p class="form-error">', '</p>'); ?>
        </div>
    </div>

        <!-- proposed_fund -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Proposed Fund (Rp.)', 'proposed_fund', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('proposed_fund', $input->proposed_fund) ?>
        </div>
        <div class="col-4">
            <?= form_error('proposed_fund') ?>
        </div>
    </div>
        
  
        
    <!-- submit button -->
    <div class="row">
        <div class="col-2">&nbsp;</div>
        <div class="col-8"><?= form_button(['type' => 'submit', 'content' => 'Save', 'class' => 'btn-primary']) ?></div>
    </div>
 <?= form_close() ?>
