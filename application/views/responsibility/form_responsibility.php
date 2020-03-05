<div class="row">
    <div class="col-10 no-margin">
        <h2>Responsibility</h2>
    </div>
</div>

<?=form_open($form_action);?>

    <?=isset($input->responsibility_id) ? form_hidden('responsibility_id', $input->responsibility_id) : '';?>

    <!-- user_id -->
    <div class="row form-group">
        <div class="col-2">
            <?=form_label('User Name', 'user_id', ['class' => 'label']);?>
        </div>
        <div class="col-4">
            <?=form_dropdown('user_id', get_dropdown_listStaff('user', ['user_id', 'username']), $input->user_id, 'id="user"');?>
        </div>
        <div class="col-4">
            <?=form_error('user_id');?>
        </div>
    </div>

        <!-- draft_id -->
    <div class="row form-group">
        <div class="col-2">
            <?=form_label('Draft Title', 'draft_id', ['class' => 'label']);?>
        </div>
        <div class="col-4">
            <?=form_dropdown('draft_id', get_dropdown_list('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft"');?>
        </div>
        <div class="col-4">
            <?=form_error('draft_id');?>
        </div>
    </div>


    <!-- submit button -->
    <div class="row">
        <div class="col-2">&nbsp;</div>
        <div class="col-8"><?=form_button(['type' => 'submit', 'content' => 'Save', 'class' => 'btn-primary']);?></div>
    </div>
 <?=form_close();?>
