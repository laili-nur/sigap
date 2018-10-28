<hr class="my-5">
  <!-- .card -->
  <section id="progress" class="card">
    <!-- .card-header -->
    <header class="card-header">Progress Step</header>
    <!-- .card-body -->
    <div class="card-body">
      <!-- .progress-list -->
        <ol class="progress-list mb-0 mb-sm-4">
        	<!-- REVIEW -->
          <li class="
          <?= ($input->is_review == 'n' and $input->stts == 99)? 'error':'' ?>
          <?= ($input->is_review == 'y') ? 'success' : '' ?>
          <?= ($reviewers) ? 'active' : '' ?>
          ">
            <button type="button" data-toggle="tooltip"  title="
            <?php if($input->is_review == 'n' and $input->stts == 99){
            	echo 'Ditolak';
            }elseif($input->is_review == 'y'){
            	echo 'Selesai';
            }else{
            	echo 'Progress';
            }?>">
              <!-- progress indicator -->
              <span width="300px" class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Review</span>
          </li>
          <!-- EDIT -->
          <li class="
          <?= ($input->is_review == 'y' and $input->is_edit == 'n' and $input->stts == 99)? 'error':'' ?>
          <?= ($input->is_edit == 'y') ? 'success' : '' ?>
          <?= ($input->is_review == 'y') ? 'active' : '' ?>
          ">
            <button type="button" data-toggle="tooltip" title="
            <?php if($input->is_edit == 'n' and $input->stts == 99){
            	echo 'Ditolak';
            }elseif($input->is_edit == 'y'){
            	echo 'Selesai';
            }else{
            	echo 'Progress';
            }?>">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Edit</span>
          </li>
          <!-- LAYOUT -->
          <li class="
          <?= ($input->is_edit == 'y' and $input->is_layout == 'n' and $input->stts == 99)? 'error':'' ?>
          <?= ($input->is_layout == 'y') ? 'success' : '' ?>
          <?= ($input->is_edit == 'y') ? 'active' : '' ?>
          ">
            <button type="button" data-toggle="tooltip" title="
            <?php if($input->is_layout == 'n' and $input->stts == 99){
            	echo 'Ditolak';
            }elseif($input->is_layout == 'y'){
            	echo 'Selesai';
            }else{
            	echo 'Progress';
            }?>">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Layout</span>
          </li>
          <li class="
          <?= ($input->is_layout == 'y' and $input->is_proofread == 'n' and $input->stts == 99)? 'error':'' ?>
          <?= ($input->is_proofread == 'y') ? 'success' : '' ?>
          <?= ($input->is_layout == 'y') ? 'active' : '' ?>
          ">
            <button type="button" data-toggle="tooltip" title="
            <?php if($input->is_proofread == 'n' and $input->stts == 99){
            	echo 'Ditolak';
            }elseif($input->is_proofread == 'y'){
            	echo 'Selesai';
            }else{
            	echo 'Progress';
            }?>">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Proofread</span>
          </li>
          <li class="
          <?= ($input->is_review == 'y' and $input->is_edit == 'y' and $input->is_layout == 'y' and $input->is_proofread == 'y' and $input->stts == 99)? 'error':'' ?>
          <?= ($input->stts == 14) ? 'success' : '' ?>
          <?= ($input->is_proofread == 'y') ? 'active' : '' ?>
          ">
            <button type="button" data-toggle="tooltip" title="
            <?php if($input->is_review == 'y' and $input->is_edit == 'y' and $input->is_layout == 'y' and $input->is_proofread == 'y' and $input->stts == 99){
            	echo 'Ditolak';
            }elseif($input->stts == 14){
            	echo 'Selesai';
            }else{
            	echo 'Progress';
            }?>">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Final</span>
          </li>
        </ol>
        <!-- /.progress-list -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->