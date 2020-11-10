<?php
$level = check_level();
if ($level == 'superadmin' || $level == 'admin_percetakan') :
    $progress_text = '';
    if ($progress == 'preprint') {
        $progress_text = 'Pracetak';
    } elseif ($progress == 'print') {
        $progress_text = 'Cetak';
    } elseif ($progress == 'postprint') {
        $progress_text = 'Jilid';
    }
?>
    <button
        title="Set Stok"
        class="btn btn-outline-dark <?= !${"is_" . $progress . "_finished"} ? 'btn-disabled' : ''; ?>"
        data-toggle="modal"
        data-target="#modal-set-stock-<?= $progress; ?>"
        <?= !${"is_" . $progress . "_finished"} ? 'disabled' : ''; ?>
    > <?php if (!$is_final) {
            echo 'Set Stok ' . $progress_text;
        } else {
            echo 'Hasil ' . $progress_text;
        } ?>
    </button>
    <!-- Modal Set Stok -->
    <div
        class="modal fade"
        id="modal-set-stock-<?= $progress; ?>"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modal-set-stock-<?= $progress; ?>"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-dialog-centered"
            role="document"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php if (!$is_final) {
                                                echo 'Set Stok ' . $progress_text;
                                            } else {
                                                echo 'Hasil ' . $progress_text;
                                            } ?></h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-left">
                    <fielsdet>
                        <?php if ($print_order->category == 'nonbook') : ?>
                            <!-- Nama Pesanan utk nonbook -->
                            <div class="form-group">
                                <label for="disabled_name">Nama Pesanan</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="disabled_name"
                                    name="disabled_name"
                                    value="<?= $print_order->name; ?>"
                                    disabled
                                >
                            </div>
                        <?php else : ?>
                            <!-- Nama Buku utk cetak biasa, cetak diluar -->
                            <div class="form-group">
                                <label for="disabled_book_title">Judul Buku</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="disabled_book_title"
                                    name="disabled_book_title"
                                    value="<?= $print_order->book_title; ?>"
                                    disabled
                                >
                            </div>
                        <?php endif; ?>

                        <!-- total permintaan tipe hidden -->
                        <div class="form-group">
                            <label for="disabled_total">Jumlah Pesanan</label>
                            <input
                                type="number"
                                class="form-control"
                                id="disabled_total"
                                name="disabled_total"
                                value="<?= $print_order->total; ?>"
                                disabled
                            >
                        </div>

                        <!-- total sukses dicetak/dijilid -->
                        <div class="form-group">
                            <label for="total_<?= $progress; ?>">Jumlah Di <?= $progress_text; ?><abbr title="Required">*</abbr></label>
                            <?php
                            if ($is_final) {
                                echo "<div>" . $print_order->{"total_{$progress}"} . "</div>";
                            } else {
                                $data = array(
                                    'name' => 'total_' . $progress,
                                    'id'   => 'total_' . $progress,
                                    'class' => 'form-control',
                                    'type' => 'number',
                                    'value' => $print_order->{"total_{$progress}"},
                                    'min'   => '0'
                                );

                                echo form_input($data);
                            }
                            ?>
                        </div>

                        </fieldset>
                        <hr>
                        <div class="form-actions">
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
                                    id="btn-submit-set-stock-<?= $progress; ?>"
                                    data-dismiss="modal"
                                >Submit</button>
                            <?php endif; ?>
                        </div>
                        <p></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Set Stok -->

    <script>
    $(document).ready(function() {
        const printOrderId = '<?= $print_order->print_order_id; ?>';
        const progress = '<?= $progress; ?>';

        // submit progress
        $(`#${progress}-progress-wrapper`).on('click', `#btn-submit-set-stock-${progress}`, function() {
            const $this = $(this);

            $this.attr("disabled", "disabled").html("<i class='fa fa-spinner fa-spin '></i>");
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('print_order/api_set_stock/'); ?>" + printOrderId,
                datatype: "JSON",
                data: {
                    progress,
                    [`total_${progress}`]: Math.abs($(`#total_${progress}`).val()),
                },
                success: function(res) {
                    showToast(true, res.data);
                },
                error: function(err) {
                    showToast(false, err.responseJSON.message);
                },
                complete: function() {
                    $this.removeAttr("disabled").html("Submit");
                    $(`#${progress}-progress-wrapper`).load(` #${progress}-progress`);
                }
            });
        });
    })
    </script>
<?php endif; ?>
