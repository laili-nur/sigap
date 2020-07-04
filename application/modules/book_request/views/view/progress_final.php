<?php
$level              = check_level();
?>
<section
    id="section_request"
    class="card"
>
    <div id="request_progress">
        <header class="card-header"><span class="mr-auto">Final</span></header>
        <div class="alert alert-warning"><strong>PERHATIAN!</strong> Fitur ini berfungsi untuk finalisasi proses permintaan buku dengan menetapkan nilai stok buku.</div>
        <div class="card-body">            
            <form action="<?= base_url('book_request/action_final/'.$rData->book_request_id);?>" method="post">
                <div class="form-group">
                    <label class="font-weight-bold">Judul Buku</label>
                    <input type="text" class="form-control" value="<?= $rData->book_title;?>" disabled/>
                    <input type="hidden" class="form-control" id="book_id" name="book_id" value="<?= $rData->book_id;?>"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_in_warehouse">Stok dalam gudang</label>
                    <input type="number" class="form-control" name="stock_in_warehouse" id="stock_in_warehouse" 
                    value="<?php if(empty($stock->stock_in_warehouse) == FALSE){echo $stock->stock_in_warehouse;}else{echo 0;} ?>"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_out_warehouse">Stok luar gudang</label>
                    <input type="number" class="form-control" name="stock_out_warehouse" id="stock_out_warehouse"
                    value="<?php if(empty($stock->stock_out_warehouse) == FALSE){echo $stock->stock_out_warehouse;}else{echo 0;} ?>"/>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold" for="stock_pemasaran">Stok pemasaran</label>
                    <input type="number" class="form-control" name="stock_marketing" id="stock_marketing"
                    value="<?php if(empty($stock->stock_marketing) == FALSE){echo $stock->stock_marketing;}else{echo 0;} ?>"/>
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