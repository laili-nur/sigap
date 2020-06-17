<section
    id="section_final"
    class="card"
>
    <div id="final_progress">
        <header class="card-header"><span class="mr-auto">Final</span></header>
        <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk finalisasi proses percetakan dengan menetapkan nilai stok buku.</div>
        <div class="card-body">            
            <form action="<?= base_url('printing/finalisasi_printing/'.$pData->print_id);?>" method="post">
                <div class="form-group">
                    <label class="font-weight-bold">Judul Buku</label>
                    <input type="text" class="form-control" value="<?= $pData->book_title;?>" disabled/>
                    <input type="hidden" class="form-control" id="book_id" name="book_id" value="<?= $pData->book_id;?>"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_in_warehouse">Stok dalam gudang</label>
                    <input type="number" class="form-control" name="stock_in_warehouse" id="stock_in_warehouse"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_out_warehouse">Stok luar gudang</label>
                    <input type="number" class="form-control" name="stock_out_warehouse" id="stock_out_warehouse"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_pemasaran">Stok pemasaran</label>
                    <input type="number" class="form-control" name="stock_marketing" id="stock_marketing"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_input_notes">Catatan</label>
                    <textarea
                        rows="6"
                        class="form-control summernote-basic"
                        id="stock_input_notes"
                        name="stock_input_notes"
                    ></textarea>
                </div>
                <hr>
                <button class="btn btn-primary" type="submit" >Submit</button>
            </form>
        </div>
    </div>
</section>