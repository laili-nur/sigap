<hr class="my-5">
  <!-- .card -->
  <section id="progress" class="card">
    <!-- .card-header -->
    <header class="card-header">Progress Step</header>
    <!-- .card-body -->
    <div class="card-body">
      <!-- .progress-list -->
        <ol class="progress-list mb-0 mb-sm-4">
          <li class="<?= ($reviewers) ? 'active' : '' ?>
          <?= ($input->is_review == 'y') ? 'success' : '' ?>">
            <button type="button" data-toggle="tooltip" title="Step 1">
              <!-- progress indicator -->
              <span width="300px" class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Review</span>
          </li>
          <li class="<?= ($input->is_edit == 'y') ? 'success' : '' ?>
                    <?= ($input->is_review == 'y') ? 'active' : '' ?>">
            <button type="button" data-toggle="tooltip" title="Step 2">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Edit</span>
          </li>
          <li class="<?= ($input->is_layout == 'y') ? 'success' : '' ?>
                    <?= ($input->is_edit == 'y') ? 'active' : '' ?>">
            <button type="button" data-toggle="tooltip" title="Step 3">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Layout</span>
          </li>
          <li class="<?= ($input->is_proofread == 'y') ? 'success' : '' ?>
                    <?= ($input->is_layout == 'y') ? 'active' : '' ?>">
            <button type="button" data-toggle="tooltip" title="Step 4">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Proofread</span>
          </li>
        </ol>
        <!-- /.progress-list -->
    </div>
    <!-- /.card-body -->
  </section>
  <!-- /.card -->