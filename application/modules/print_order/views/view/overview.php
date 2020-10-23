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
            <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-toggle="modal"
                data-target="#modal-additional-notes"
            >Catatan Tambahan</button>
            <div
                class="modal fade"
                id="modal-additional-notes"
                tabindex="-1"
                role="dialog"
                aria-labelledby="modal-additional-notes"
                aria-hidden="true"
            >
                <div
                    class="modal-dialog modal-lg modal-dialog-overflow"
                    role="document"
                >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Catatan Tambahan</h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <fieldset>
                                <div class="form-group">
                                    <?= form_open('print_order/add_additional_notes/' . $print_order->print_order_id, ''); ?>
                                    <?php
                                    echo form_textarea([
                                        'name'  => "additional_notes",
                                        'class' => 'form-control',
                                        'id'    => "additional-notes",
                                        'rows'  => '6',
                                        'value' => $print_order->additional_notes
                                    ]);
                                    ?>
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light ml-auto"
                                data-dismiss="modal"
                            >Close</button>
                            <?php if (!$is_final) : ?>
                                <button
                                    class="btn btn-primary"
                                    type="submit"
                                    value="Submit"
                                    id="btn-submit-additional-notes"
                                >Submit</button>
                                <?= form_close(); ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($_SESSION['level'] == 'superadmin') : ?>
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
    if ($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_percetakan') {
        $this->load->view('print_order/view/preprint/index');
        if ($print_order->is_preprint) {
            $this->load->view('print_order/view/print/index');
            if ($print_order->is_print) {
                $this->load->view('print_order/view/postprint/index');
                if ($print_order->is_postprint) {
                    $this->load->view('print_order/view/final/index');
                }
            }
        }
    }
    ?>
</div>
