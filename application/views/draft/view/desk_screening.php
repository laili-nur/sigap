<?php $level = check_level();?>
<hr class="my-5">
<section class="card card-fluid">
    <header class="card-header"><i class="oi oi-pencil"></i> Desk Screening</header>
    <div class="card-body">
        <?php if ($desk->worksheet_status == 1): ?>
        <div class="alert alert-success">
            <strong>Draft Lolos Desk Screening.</strong>
        </div>
        <?php elseif ($desk->worksheet_status == 2): ?>
        <div class="alert alert-danger">
            <strong>Draft Tidak Lolos Desk Screening.</strong>
        </div>
        <?php else: ?>
        <div class="alert alert-warning">
            <strong>Draft Menunggu Desk Screening.</strong>
            <?php if ($level != 'author' and $level != 'reviewer'): ?>
            <p class="m-0 p-0">Untuk melakukan desk screening, silakan menuju link berikut :
                <a
                    href="<?=base_url('worksheet/edit/' . $desk->worksheet_id);?>"
                    target="_blank"
                ><?=$input->draft_title;?></a>
            </p>
            <?php endif;?>
        </div>
        <?php endif;?>
        <form
            class="needs-validation"
            novalidate=""
        >
            <fieldset>
                <div class="form-group">
                    <label><strong>Catatan Editor</strong></label>
                    <div class="font-italic">
                        <?=($desk->worksheet_notes != '') ? nl2br($desk->worksheet_notes) : '<em class="text-muted">Tidak ada catatan</em>';?>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</section>