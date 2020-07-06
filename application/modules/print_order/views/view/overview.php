<header class="page-title-bar mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>"><span class="fa fa-home"></span></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('print_order'); ?>">Order Cetak</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-muted">
                    <?= $print_order->book_title; ?></a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center my-3">
        <div class="page-title mb-0 pb-0 h1"> Order Cetak </div>
    </div>
</header>

<div class="page-section">
    <?php $this->load->view('print_order/view/detail/index'); ?>
    <?php $this->load->view('print_order/view/progress'); ?>
    <?php $this->load->view('print_order/view/preprint/index'); ?>
    <?php $this->load->view('print_order/view/print/index'); ?>
    <?php $this->load->view('print_order/view/postprint/index'); ?>
    <?php $this->load->view('print_order/view/finish/index'); ?>
</div>
