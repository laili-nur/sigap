<?php
    $success = $this->session->flashdata('success');
    $error   = $this->session->flashdata('error');
    $warning = $this->session->flashdata('warning');
    if ($error) {
        $message_status = 'alert-danger';
        $message = $error;
    }

    if ($warning) {
        $message_status = 'alert-warning';
        $message = $warning;
    }

    if ($success) {
        $message_status = 'alert-success';
        $message = $success;
    }
?>

<?php if ($success || $warning || $error): ?>
    <!-- <div class="row">
        <div class="col-12">
            <div class="alert <?= $message_status ?>" id="flashmessage">
                <?= $message ?>
            </div>
        </div>
    </div> -->


<?php endif ?>
<script>
    $(document).ready(function(){
        var status = '<?= isset($message_status)?$message_status:'' ?>';
        if(status!=''){

            if(status == 'alert-success') {
                toastr.success('<?= isset($message)?$message:'' ?>');
            }else if(status == 'alert-warning'){
                toastr.warning('<?= isset($message)?$message:'' ?>');
            }else{
                toastr.error('<?= isset($message)?$message:'' ?>');
            }
        }
        
        
        


        $('#flashmessage').delay(2000).hide(0);
    })
</script>