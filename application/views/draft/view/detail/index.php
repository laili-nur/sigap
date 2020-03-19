<?php $level = check_level();?>
<section class="card">
    <header class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a
                    class="nav-link active show"
                    data-toggle="tab"
                    href="#draft_data"
                ><i class="fa fa-info-circle"></i> Detail Draft</a>
            </li>
            <?php if ($level != 'reviewer'): ?>
            <!-- reviewer tidak bisa melihat penulis -->
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="tab"
                    href="#data-penulis"
                ><i class="fa fa-user-tie"></i> Penulis</a>
            </li>
            <?php endif;?>
            <?php if ($level != 'author' and $level != 'reviewer' and $desk->worksheet_status == '1'): ?>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="tab"
                    href="#data-reviewer"
                ><i class="fa fa-user-graduate"></i> Reviewer</a>
            </li>
            <?php endif;?>
            <?php if ($level == 'author'): ?>
            <!-- author bisa melihat data buku -->
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="tab"
                    href="#data-buku"
                ><i class="fa fa-book"></i> Buku</a>
            </li>
            <?php endif;?>
        </ul>
    </header>

    <div class="card-body">
        <?=isset($input->draft_id) ? form_hidden('draft_id', $input->draft_id) : '';?>
        <div class="tab-content">
            <?php $this->load->view('draft/view/detail/draft_data');?>
            <?php $this->load->view('draft/view/detail/author_data');?>
            <?php $this->load->view('draft/view/detail/reviewer_data');?>
            <?php $this->load->view('draft/view/detail/book_data');?>
        </div>
    </div>
</section>