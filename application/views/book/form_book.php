<div class="row">
    <div class="col-10 no-margin">
        <h2>Book</h2>
    </div>
</div>
<?= form_open_multipart($form_action) ?>

    <?= isset($input->book_id) ? form_hidden('book_id', $input->book_id) : '' ?>

    <!-- draft_id -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Draft Title', 'draft_id', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_dropdown('draft_id', getDropdownList('draft', ['draft_id', 'draft_title']), $input->draft_id, 'id="draft"') ?>
        </div>
        <div class="col-4">
            <?= form_error('draft_id') ?>
        </div>
    </div>
    
        <!-- book_code -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Book Code', 'book_code', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('book_code', $input->book_code) ?>
        </div>
        <div class="col-4">
            <?= form_error('book_code') ?>
        </div>
    </div>
        
        <!-- book_title -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Book Title', 'book_title', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('book_title', $input->book_title) ?>
        </div>
        <div class="col-4">
            <?= form_error('book_title') ?>
        </div>
    </div>
        
<!--     cover 
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Cover', 'cover', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_upload('cover') ?>
        </div>
        <div class="col-4">
            <?= fileFormError('cover', '<p class="form-error">', '</p>'); ?>
        </div>
    </div>

     Gambar cover preview 
    <?php if (!empty($input->cover)): ?>
        <div class="row form-group">
            <div class="col-2">&nbsp;</div>
            <div class="col-4">
                <img src="<?= site_url("/cover/$input->cover") ?>" alt="<?= $input->book_title ?>">
            </div>
            <div class="col-4">&nbsp;</div>
        </div>
    <?php endif ?>-->
    

        <!-- book_edition -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Book Edition', 'book_edition', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('book_edition', $input->book_edition) ?>
        </div>
        <div class="col-4">
            <?= form_error('book_edition') ?>
        </div>
    </div>
        
        <!-- isbn -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('ISBN', 'isbn', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('isbn', $input->isbn) ?>
        </div>
        <div class="col-4">
            <?= form_error('isbn') ?>
        </div>
    </div>

        
    <!-- book_file -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Book File', 'book_file', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_upload('book_file') ?>
        </div>
        <div class="col-4">
            <?= fileFormError('book_file', '<p class="form-error">', '</p>'); ?>
        </div>
    </div>

    <!--  book_file preview -->
    <?php if (!empty($input->book_file)): ?>
        <div class="row form-group">
            <div class="col-2">&nbsp;</div>
            <div class="col-4">
                <img src="<?= site_url("/bookfile/$input->book_file") ?>" alt="<?= $input->book_title ?>">
            </div>
            <div class="col-4">&nbsp;</div>
        </div>
    <?php endif ?>
    
    
    <!-- published_date -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Published Date (yyyy-mm-dd)', 'published_date', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('published_date', $input->published_date, ['class' => 'date date-picker']) ?>
        </div>
        <div class="col-4">
            <?= form_error('published_date') ?>
        </div>
    </div>     
        
    <!-- printing_type -->
    <div class="row form-group">
        <div class="col-2">
            <p class="label">Printing Type</p>
        </div>
        <div class="col-4">
            <label class="block-label">
                <?= form_radio('printing_type', 'p',
                    isset($input->printing_type) && ($input->printing_type == 'p') ? true : false)
                ?> Print on Demand
            </label>
            <label class="block-label">
                <?= form_radio('printing_type', 'o',
                    isset($input->printing_type) && ($input->printing_type == 'o') ? true : false)
                ?> Offset
            </label>
        </div>
        <div class="col-4">
            <?= form_error('printing_type') ?>
        </div>
    </div>
        
        <!-- serial_num -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Serial Number Total', 'serial_num', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('serial_num', $input->serial_num) ?>
        </div>
        <div class="col-4">
            <?= form_error('serial_num') ?>
        </div>
    </div>
             
            <!-- serial_num_per_year -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Serial Number this Year', 'serial_num_per_year', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('serial_num_per_year', $input->serial_num_per_year) ?>
        </div>
        <div class="col-4">
            <?= form_error('serial_num_per_year') ?>
        </div>
    </div>
            
        <!-- copies_num -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Copies Total', 'copies_num', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_input('copies_num', $input->copies_num) ?>
        </div>
        <div class="col-4">
            <?= form_error('copies_num') ?>
        </div>
    </div>
        
        <!-- book_notes -->
    <div class="row form-group">
        <div class="col-2">
            <?= form_label('Book Notes', 'book_notes', ['class' => 'label']) ?>
        </div>
        <div class="col-4">
            <?= form_textarea('book_notes', $input->book_notes, ['class' => 'form-input']) ?>
        </div>
        <div class="col-4">
            <?= form_error('book_notes') ?>
        </div>
    </div>           
        
        
    <!-- is_reprint -->
    <div class="row form-group">
        <div class="col-2">
            <p class="label">Reprint Status</p>
        </div>
        <div class="col-4">
            <label class="block-label">
                <?= form_radio('is_reprint', 'y',
                    isset($input->is_reprint) && ($input->is_reprint == 'y') ? true : false)
                ?> Reprint
            </label>
            <label class="block-label">
                <?= form_radio('is_reprint', 'n',
                    isset($input->is_reprint) && ($input->is_reprint == 'n') ? true : false)
                ?> Not Reprint
            </label>
        </div>
        <div class="col-4">
            <?= form_error('is_reprint') ?>
        </div>
    </div>
        
    <!-- submit button -->
    <div class="row">
        <div class="col-2">&nbsp;</div>
        <div class="col-8"><?= form_button(['type' => 'submit', 'content' => 'Save', 'class' => 'btn-primary']) ?></div>
    </div>
 <?= form_close() ?>
