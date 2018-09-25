<?php
    $username = $this->session->userdata('username');
    $is_login = $this->session->userdata('is_login');
    $ceklevel    = $this->session->userdata('level');
?>
<!-- .page-title-bar -->
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">
          <a class="text-muted"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Dashboard </h1>
    <p class="lead">
      <span class="font-weight-bold">Hi, <?=$username ?>.</span>
      <span class="d-block text-muted">Selamat bekerja dan semoga harimu menyenangkan.</span>
    </p>
  </header>
  <!-- /.page-title-bar -->
  
  <!-- .page-section -->
  <div class="page-section">
    <?php if ($ceklevel == 'superadmin' || $ceklevel == 'admin_penerbitan'): ?>
    <!-- .section-block -->
    <div class="section-block">
      <!-- metric row -->
      <div class="metric-row">
        <div class="col-lg-9">
          <div class="metric-row metric-flush">
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('category') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Kategori </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="oi oi-people"></i>
                  </sub>
                  <span class="value">8</span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('draft') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Draft </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="oi oi-fork"></i>
                  </sub>
                  <span class="value">12</span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
            <!-- metric column -->
            <div class="col">
              <!-- .metric -->
              <a href="<?=base_url('author') ?>" class="metric metric-bordered align-items-center">
                <h2 class="metric-label"> Penulis </h2>
                <p class="metric-value h3">
                  <sub>
                    <i class="fa fa-tasks"></i>
                  </sub>
                  <span class="value">64</span>
                </p>
              </a>
              <!-- /.metric -->
            </div>
            <!-- /metric column -->
          </div>
        </div>
        <!-- metric column -->
        <div class="col-lg-3">
          <!-- .metric -->
          <a href="user-tasks.html" class="metric metric-bordered">
            <div class="metric-badge">
              <span class="badge badge-lg badge-success">
                <span class="oi oi-media-record pulse mr-1"></span> DALAM PROSES</span>
            </div>
            <p class="metric-value h3">
              <sub>
                <i class="oi oi-timer"></i>
              </sub>
              <span class="value">8</span>
            </p>
          </a>
          <!-- /.metric -->
        </div>
        <!-- /metric column -->
      </div>
      <!-- /metric row -->
    </div>
    <!-- /.section-block -->
    <!-- grid row -->
    <div class="row">
      <!-- grid column -->
      <div class="col-12 col-lg-12 col-xl-4">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <!-- .d-flex -->
            <div class="d-flex align-items-center mb-3">
              <h3 class="card-title mr-auto"> Data 1 </h3>
            </div>
            <!-- /.d-flex -->
            <div class="chartjs" style="height: 283px">
              <canvas id="completion-tasks"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </section>
        <!-- /.card -->
      </div>
      <!-- /grid column -->
      <!-- grid column -->
      <div class="col-12 col-lg-6 col-xl-4">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body">
            <h3 class="card-title"> Performa </h3>
            <!-- easy-pie-chart -->
            <div class="text-center pt-3">
              <div class="chart-inline-group" style="height:214px">
                <div class="easyPieChart" data-percent="60" data-size="214" data-barcolor="#346CB0" data-trackcolor="false" data-scalecolor="false" data-rotate="225"></div>
                <div class="easyPieChart" data-percent="50" data-size="174" data-barcolor="#00A28A" data-trackcolor="false" data-scalecolor="false" data-rotate="225"></div>
                <div class="easyPieChart" data-percent="75" data-size="134" data-barcolor="#5F4B8B" data-trackcolor="false" data-scalecolor="false" data-rotate="225"></div>
              </div>
            </div>
            <!-- /easy-pie-chart -->
          </div>
          <!-- /.card-body -->
          <!-- .card-footer -->
          <div class="card-footer">
            <div class="card-footer-item">
              <i class="fa fa-fw fa-circle text-indigo"></i> 100%
              <div class="text-muted small"> Assigned </div>
            </div>
            <div class="card-footer-item">
              <i class="fa fa-fw fa-circle text-purple"></i> 75%
              <div class="text-muted small"> Completed </div>
            </div>
            <div class="card-footer-item">
              <i class="fa fa-fw fa-circle text-teal"></i> 60%
              <div class="text-muted small"> Active </div>
            </div>
          </div>
          <!-- /.card-footer -->
        </section>
        <!-- /.card -->
      </div>
      <!-- /grid column -->
      <!-- grid column -->
      <div class="col-12 col-lg-6 col-xl-4">
        <!-- .card -->
        <section class="card card-fluid">
          <!-- .card-body -->
          <div class="card-body pb-0">
            <h3 class="card-title"> User </h3>
            <!-- legend -->
            <ul class="list-inline small">
              <li class="list-inline-item">
                <i class="fa fa-fw fa-circle text-light"></i> Tasks </li>
              <li class="list-inline-item">
                <i class="fa fa-fw fa-circle text-purple"></i> Completed </li>
              <li class="list-inline-item">
                <i class="fa fa-fw fa-circle text-teal"></i> Active </li>
              <li class="list-inline-item">
                <i class="fa fa-fw fa-circle text-red"></i> Overdue </li>
            </ul>
            <!-- /legend -->
          </div>
          <!-- /.card-body -->
          <!-- .list-group -->
          <div class="list-group list-group-flush">
            <!-- .list-group-item -->
            <div class="list-group-item">
              <!-- .list-group-item-figure -->
              <div class="list-group-item-figure">
                <a href="user-profile.html" class="user-avatar" data-toggle="tooltip" title="Martha Myers">
                  <img src="assets/images/avatars/uifaces15.jpg" alt="">
                </a>
              </div>
              <!-- /.list-group-item-figure -->
              <!-- .list-group-item-body -->
              <div class="list-group-item-body">
                <!-- .progress -->
                <div class="progress bg-white rounded-0" data-toggle="tooltip" data-html="true" title='&lt;div class="text-left small"&gt;&lt;i class="fa fa-fw fa-circle text-purple"&gt;&lt;/i&gt; 2065&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-teal"&gt;&lt;/i&gt; 231&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-red"&gt;&lt;/i&gt; 54&lt;/div&gt;'>
                  <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="73.46140163642832" aria-valuemin="0" aria-valuemax="100" style="width: 73.46140163642832%">
                    <span class="sr-only">73.46140163642832% Complete</span>
                  </div>
                  <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="8.217716115261473" aria-valuemin="0" aria-valuemax="100" style="width: 8.217716115261473%">
                    <span class="sr-only">8.217716115261473% Complete</span>
                  </div>
                  <div class="progress-bar bg-red" role="progressbar" aria-valuenow="1.92102454642476" aria-valuemin="0" aria-valuemax="100" style="width: 1.92102454642476%">
                    <span class="sr-only">1.92102454642476% Complete</span>
                  </div>
                </div>
                <!-- /.progress -->
              </div>
              <!-- /.list-group-item-body -->
            </div>
            <!-- /.list-group-item -->
            <!-- .list-group-item -->
            <div class="list-group-item">
              <!-- .list-group-item-figure -->
              <div class="list-group-item-figure">
                <a href="user-profile.html" class="user-avatar" data-toggle="tooltip" title="Tammy Beck">
                  <img src="assets/images/avatars/uifaces16.jpg" alt="">
                </a>
              </div>
              <!-- /.list-group-item-figure -->
              <!-- .list-group-item-body -->
              <div class="list-group-item-body">
                <!-- .progress -->
                <div class="progress bg-white rounded-0" data-toggle="tooltip" data-html="true" title='&lt;div class="text-left small"&gt;&lt;i class="fa fa-fw fa-circle text-purple"&gt;&lt;/i&gt; 1432&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-teal"&gt;&lt;/i&gt; 406&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-red"&gt;&lt;/i&gt; 49&lt;/div&gt;'>
                  <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="54.180855088914115" aria-valuemin="0" aria-valuemax="100" style="width: 54.180855088914115%">
                    <span class="sr-only">54.180855088914115% Complete</span>
                  </div>
                  <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="15.361331819901627" aria-valuemin="0" aria-valuemax="100" style="width: 15.361331819901627%">
                    <span class="sr-only">15.361331819901627% Complete</span>
                  </div>
                  <div class="progress-bar bg-red" role="progressbar" aria-valuenow="1.853953840332955" aria-valuemin="0" aria-valuemax="100" style="width: 1.853953840332955%">
                    <span class="sr-only">1.853953840332955% Complete</span>
                  </div>
                </div>
                <!-- /.progress -->
              </div>
              <!-- /.list-group-item-body -->
            </div>
            <!-- /.list-group-item -->
            <!-- .list-group-item -->
            <div class="list-group-item">
              <!-- .list-group-item-figure -->
              <div class="list-group-item-figure">
                <a href="user-profile.html" class="user-avatar" data-toggle="tooltip" title="Susan Kelley">
                  <img src="assets/images/avatars/uifaces17.jpg" alt="">
                </a>
              </div>
              <!-- /.list-group-item-figure -->
              <!-- .list-group-item-body -->
              <div class="list-group-item-body">
                <!-- .progress -->
                <div class="progress bg-white rounded-0" data-toggle="tooltip" data-html="true" title='&lt;div class="text-left small"&gt;&lt;i class="fa fa-fw fa-circle text-purple"&gt;&lt;/i&gt; 1271&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-teal"&gt;&lt;/i&gt; 87&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-red"&gt;&lt;/i&gt; 82&lt;/div&gt;'>
                  <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="52.13289581624282" aria-valuemin="0" aria-valuemax="100" style="width: 52.13289581624282%">
                    <span class="sr-only">52.13289581624282% Complete</span>
                  </div>
                  <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="3.568498769483183" aria-valuemin="0" aria-valuemax="100" style="width: 3.568498769483183%">
                    <span class="sr-only">3.568498769483183% Complete</span>
                  </div>
                  <div class="progress-bar bg-red" role="progressbar" aria-valuenow="3.3634126333059884" aria-valuemin="0" aria-valuemax="100" style="width: 3.3634126333059884%">
                    <span class="sr-only">3.3634126333059884% Complete</span>
                  </div>
                </div>
                <!-- /.progress -->
              </div>
              <!-- /.list-group-item-body -->
            </div>
            <!-- /.list-group-item -->
            <!-- .list-group-item -->
            <div class="list-group-item">
              <!-- .list-group-item-figure -->
              <div class="list-group-item-figure">
                <a href="user-profile.html" class="user-avatar" data-toggle="tooltip" title="Albert Newman">
                  <img src="assets/images/avatars/uifaces18.jpg" alt="">
                </a>
              </div>
              <!-- /.list-group-item-figure -->
              <!-- .list-group-item-body -->
              <div class="list-group-item-body">
                <!-- .progress -->
                <div class="progress bg-white rounded-0" data-toggle="tooltip" data-html="true" title='&lt;div class="text-left small"&gt;&lt;i class="fa fa-fw fa-circle text-purple"&gt;&lt;/i&gt; 1527&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-teal"&gt;&lt;/i&gt; 205&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-red"&gt;&lt;/i&gt; 151&lt;/div&gt;'>
                  <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="75.18463810930577" aria-valuemin="0" aria-valuemax="100" style="width: 75.18463810930577%">
                    <span class="sr-only">75.18463810930577% Complete</span>
                  </div>
                  <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="10.093549975381585" aria-valuemin="0" aria-valuemax="100" style="width: 10.093549975381585%">
                    <span class="sr-only">10.093549975381585% Complete</span>
                  </div>
                  <div class="progress-bar bg-red" role="progressbar" aria-valuenow="7.434761201378631" aria-valuemin="0" aria-valuemax="100" style="width: 7.434761201378631%">
                    <span class="sr-only">7.434761201378631% Complete</span>
                  </div>
                </div>
                <!-- /.progress -->
              </div>
              <!-- /.list-group-item-body -->
            </div>
            <!-- /.list-group-item -->
            <!-- .list-group-item -->
            <div class="list-group-item">
              <!-- .list-group-item-figure -->
              <div class="list-group-item-figure">
                <a href="user-profile.html" class="user-avatar" data-toggle="tooltip" title="Kyle Grant">
                  <img src="assets/images/avatars/uifaces19.jpg" alt="">
                </a>
              </div>
              <!-- /.list-group-item-figure -->
              <!-- .list-group-item-body -->
              <div class="list-group-item-body">
                <!-- .progress -->
                <div class="progress bg-white rounded-0" data-toggle="tooltip" data-html="true" title='&lt;div class="text-left small"&gt;&lt;i class="fa fa-fw fa-circle text-purple"&gt;&lt;/i&gt; 643&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-teal"&gt;&lt;/i&gt; 265&lt;br&gt;&lt;i class="fa fa-fw fa-circle text-red"&gt;&lt;/i&gt; 127&lt;/div&gt;'>
                  <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="36.89041881812966" aria-valuemin="0" aria-valuemax="100" style="width: 36.89041881812966%">
                    <span class="sr-only">36.89041881812966% Complete</span>
                  </div>
                  <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="15.203671830177854" aria-valuemin="0" aria-valuemax="100" style="width: 15.203671830177854%">
                    <span class="sr-only">15.203671830177854% Complete</span>
                  </div>
                  <div class="progress-bar bg-red" role="progressbar" aria-valuenow="7.286288009179575" aria-valuemin="0" aria-valuemax="100" style="width: 7.286288009179575%">
                    <span class="sr-only">7.286288009179575% Complete</span>
                  </div>
                </div>
                <!-- /.progress -->
              </div>
              <!-- /.list-group-item-body -->
            </div>
            <!-- /.list-group-item -->
          </div>
          <!-- /.list-group -->
        </section>
        <!-- /.card -->
      </div>
      <!-- /grid column -->
    </div>
    <!-- /grid row -->
    <?php endif ?>
  </div>
  <!-- /.page-section -->