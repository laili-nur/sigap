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
                    <?= $print_order->book_id ? $print_order->book_title : $print_order->name; ?></a>
            </li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center my-3">
        <div class="page-title mb-0 pb-0 h1"> Order Cetak </div>
        <div>
            <?php if (is_admin()) : ?>
                <a
                    href="<?= base_url('print_order/edit/' . $print_order->print_order_id) ?>"
                    class="btn btn-secondary btn-sm"
                ><i class="fa fa-edit fa-fw"></i> Edit Order Cetak</a>
            <?php endif ?>
        </div>
    </div>

    <!-- FINAL ALERT -->
    <?php if ($is_final) : ?>
        <div
            class="alert alert-warning alert-dismissible fade show"
            role="alert"
        >
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Order cetak telah selesai</strong>, data progress tidak dapat diubah.
            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
</header>

<div class="page-section">
    <?php
    $this->load->view('print_order/view/detail/index');
    $this->load->view('print_order/view/progress');
    $this->load->view('print_order/view/preprint/index');
    if ($print_order->is_preprint) {
        $this->load->view('print_order/view/print/index');
        if ($print_order->is_print) {
            $this->load->view('print_order/view/postprint/index');
            if ($print_order->is_postprint) {
                $this->load->view('print_order/view/stock/index');
                if ($print_order->is_stock) {
                    $this->load->view('print_order/view/final/index');
                }    
            }
        }
    }
    ?>
</div>
