<?php
    $perPage = 10;
    $keywords = $this->input->get('keywords');

    if (isset($keywords)) {
        $page = $this->uri->segment(3);
    } else {
        $page = $this->uri->segment(2);
    }

    // data table series number
    $i = isset($page) ? $page * $perPage - $perPage : 0;
?>

<!-- Page heading -->
<div class="row">
    <div class="col-10">
        <h2>Book</h2>
    </div>
</div>

<!-- Flash message -->
<?php $this->load->view('_partial/flash_message') ?>

<!--Search form -->
<div class="row">
    <div class="col-5">
        &nbsp;
    </div>
    <div class="col-5 align-right">
    <?= form_open('book/search', ['method' => 'GET']) ?>
        <?= form_label('Find', 'key_words') ?>
        <?= form_input('keywords', $this->input->get('keywords'), ['placeholder' => 'Enter Draft, Book Title, Code, and ISBN', 'class' => 'col-3']) ?>
        <?= form_button(['type' => 'submit', 'content' => 'Find', 'class' => 'btn-default']) ?>
    <?= form_close() ?>
    </div>
</div>

<!-- Table -->
<div class="row">
    <div class="col-10">
        <?php if ($books):?>
            <table class="awn-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Draft Title</th>
                        <th scope="col">Book Code</th>
                        <th scope="col">Book Title</th>
<!--                        <th scope="col">Cover</th>-->
                        <th scope="col">Book Edition</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Book File</th>
                        <th scope="col">Published Date</th>
                        <th scope="col">Printing Type</th>
                        <th scope="col">Serial Number Total</th>
                        <th scope="col">Serial Number this Year</th>
                        <th scope="col">Copies Total</th>
                        <th scope="col">Book Notes</th>
                        <th scope="col">Reprint Status</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($books as $book): ?>
                    <?= ($i & 1) ? '<tr class="zebra">' : '<tr>'; ?>
                        <td><?= ++$i ?></td>
                        <td><?= $book->draft_title ?></td>
                        <td><?= $book->book_code ?></td>
                        <td><?= $book->book_title ?></td>
<!--                        <td><?= $book->cover ?></td>-->
                        <td><?= $book->book_edition ?></td>
                        <td><?= $book->isbn ?></td>
                        <td><?= $book->book_file ?></td>
                        <td><?= $book->published_date ?></td>
                        <td><?= $book->printing_type == 'p' ? 'Print on Demand' : 'Offset'?></td>
                        <td><?= $book->serial_num ?></td>
                        <td><?= $book->serial_num_per_year ?></td>
                        <td><?= $book->copies_num ?></td>
                        <td><?= $book->book_notes ?></td>
                        <td><?= $book->is_reprint == 'y' ? 'Reprint' : 'Not Reprint'?></td>                                           
                        <td><?= anchor("book/edit/$book->book_id", 'Edit', ['class' => 'btn btn-warning']) ?></td>
                        <td>
                            <?= form_open("book/delete/$book->book_id") ?>
                                <?= form_hidden('book_id', $book->book_id) ?>
                                <?= form_button(['type' => 'submit', 'content' => 'Delete', 'class' => 'btn-danger']) ?>
                            <?= form_close() ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">Total : <?= isset($total) ? $total : '' ?></td>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p>Book data were not available</p>
        <?php endif ?>
    </div>
</div>

<div class="row">
    <!-- Button add -->
    <div class="col-2">
        <?= anchor("book/add", 'Add', ['class' => 'btn btn-primary']) ?>
    </div>
  
    <!-- Pagination -->
    <div class="col-2">
    <?php if ($pagination): ?>
        <div id="pagination"  class="float-right">
            <?= $pagination ?>
        </div>
    <?php else: ?>
        &nbsp;
    <?php endif ?>
    </div>
</div>
