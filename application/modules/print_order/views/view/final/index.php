<?php if ($print_order->print_order_status == 'finish') : ?>
    <div>Order cetak sudah selesai diproses. <a
            href="<?= base_url("book/view/{$print_order->book_id}#stock-data") ?>"
            target="_blank"
        > <i class="fa fa-external-link-alt"></i> Link stok buku</a></div>
<?php else : ?>
    <section
        id="final-progress-wrapper"
        class="card"
    >
        <div id="final-progress">
            <header class="card-header"><span class="mr-auto">Final</span></header>
            <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk mengatur stok buku setelah proses produksi/cetak.</div>
            <div class="card-body">
                <form
                    action="<?= base_url('print_order/finish/' . $print_order->print_order_id); ?>"
                    method="post"
                >
                    <input
                        type="hidden"
                        name="book_id"
                        value="<?= $print_order->book_id; ?>"
                    />
                    <div class="form-group">
                        <label class="font-weight-bold">Judul Buku : </label>
                        <?= $print_order->book_title; ?>
                    </div>
                    <div class="form-group">
                        <label
                            class="font-weight-bold"
                            for="stock_in_warehouse"
                        >Stok dalam gudang</label>
                        <input
                            type="number"
                            class="form-control"
                            name="stock_in_warehouse"
                            value="0"
                        />
                    </div>
                    <div class="form-group">
                        <label
                            class="font-weight-bold"
                            for="stock_out_warehouse"
                        >Stok luar gudang</label>
                        <input
                            type="number"
                            class="form-control"
                            name="stock_out_warehouse"
                            value="0"
                        />
                    </div>
                    <div class="form-group">
                        <label
                            class="font-weight-bold"
                            for="stock_pemasaran"
                        >Stok pemasaran</label>
                        <input
                            type="number"
                            class="form-control"
                            name="stock_marketing"
                            value="0"
                        />
                    </div>
                    <div class="form-group">
                        <label
                            class="font-weight-bold"
                            for="stock_input_notes"
                        >Catatan</label>
                        <textarea
                            rows="6"
                            class="form-control summernote"
                            id="stock-input-notes"
                            name="stock_input_notes"
                        ></textarea>
                    </div>
                    <hr>
                    <button
                        class="btn btn-primary"
                        type="submit"
                    >Submit</button>
                </form>
            </div>
        </div>
    </section>
<?php endif ?>

<script>
$(document).ready(function() {
    $('#stock-input-notes').summernote(summernoteConfig)
})
</script>
