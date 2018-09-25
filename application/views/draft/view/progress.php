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
          <?= ($input->is_reviewed == 'y') ? 'success' : '' ?>">
            <button type="button" data-toggle="tooltip" title="Step 1">
              <!-- progress indicator -->
              <span width="300px" class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Review</span>
          </li>
          <li class="<?= ($input->is_edited == 'y') ? 'success' : '' ?>
                    <?= ($input->is_reviewed == 'y') ? 'active' : '' ?>">
            <button type="button" data-toggle="tooltip" title="Step 2">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Edit</span>
          </li>
          <li class="<?= ($input->is_layouted == 'y') ? 'success' : '' ?>
                    <?= ($input->is_edited == 'y') ? 'active' : '' ?>">
            <button type="button" data-toggle="tooltip" title="Step 3">
              <!-- progress indicator -->
              <span class="progress-indicator"></span>
            </button>
            <span class="progress-label d-none d-sm-inline-block">Layout</span>
          </li>
          <li class="<?= ($input->draft_status == '99') ? 'success' : '' ?>
                    <?= ($input->is_layouted == 'y') ? 'success' : '' ?>">
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