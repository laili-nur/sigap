<?php
$per_page = 10;
$keywords = $this->input->get('keywords');

if (isset($keywords)) {
    $page = $this->uri->segment(3);
} else {
    $page = $this->uri->segment(2);
}

// data table series number
$i = isset($page) ? $page * $per_page - $per_page : 0;
?>

<!-- Page heading -->
<div class="row">
    <div class="col-10">
        <h2>Draft Author</h2>
    </div>
</div>


<!--Search form -->
<div class="row">
    <div class="col-5">
        &nbsp;
    </div>
    <div class="col-5 align-right">
    <?=form_open('draft_author/search', ['method' => 'GET']);?>
        <?=form_label('Find', 'key_words');?>
        <?=form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Enter Title or NIP or Name', 'class' => 'col-3']);?>
        <?=form_button(['type' => 'submit', 'content' => 'Find', 'class' => 'btn-default']);?>
    <?=form_close();?>
    </div>
</div>

<!-- Table -->
<div class="row">
    <div class="col-10">
        <?php if ($draft_authors): ?>
            <table class="awn-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Draft Title</th>
                        <th scope="col">Author NIP</th>
                        <th scope="col">Author Name</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($draft_authors as $draft_author): ?>
                    <?=($i & 1) ? '<tr class="zebra">' : '<tr>';?>
                        <td><?=++$i;?></td>
                        <td><?=$draft_author->draft_title;?></td>
                        <td><?=$draft_author->author_nip;?></td>
                        <td><?=$draft_author->author_name;?></td>
                        <td><?=anchor("draftauthor/edit/$draft_author->draft_author_id", 'Edit', ['class' => 'btn btn-warning']);?></td>
                        <td>
                            <?=form_open("draftauthor/delete/$draft_author->draft_author_id");?>
                                <?=form_hidden('draft_author_id', $draft_author->draft_author_id);?>
                                <?=form_button(['type' => 'submit', 'content' => 'Delete', 'class' => 'btn-danger']);?>
                            <?=form_close();?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">Total : <?=isset($total) ? $total : '';?></td>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p>Draft Author data were not available</p>
        <?php endif;?>
    </div>
</div>

<div class="row">
    <!-- Button add -->
    <div class="col-2">
        <?=anchor("draftauthor/add", 'Add', ['class' => 'btn btn-primary']);?>
    </div>


    <!-- Pagination -->
    <div class="col-2">
    <?php if ($pagination): ?>
        <div id="pagination"  class="float-right">
            <?=$pagination;?>
        </div>
    <?php else: ?>
        &nbsp;
    <?php endif;?>
    </div>
</div>
