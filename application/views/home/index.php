<?php
$username = $this->session->userdata('username');
$is_login = $this->session->userdata('is_login');
$level = $this->session->userdata('level');
$role  = $this->session->userdata('role_id');
$semua = $this->session->userdata();
?>

<header class="page-title-bar">
    <h1 class="page-title"> Dashboard </h1>
    <p class="lead">
        <span class="font-weight-bold">Halo, <?= $username; ?></span>
        <span class="d-block text-muted">
         <?= (!empty($tulisan_dashboard->dashboard_head)) ? $tulisan_dashboard->dashboard_head : ''; ?>
      </span>
        <?php
         if ($level == 'author') {
            if (!empty($tulisan_dashboard->dashboard_content_author) or $tulisan_dashboard->dashboard_content_author == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_author . '</div>';
            }
         } elseif ($level == 'reviewer') {
            if (!empty($tulisan_dashboard->dashboard_content_reviewer) or $tulisan_dashboard->dashboard_content_reviewer == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_reviewer . '</div>';
            }
         } elseif ($level == 'layouter') {
            if (!empty($tulisan_dashboard->dashboard_content_layouter) or $tulisan_dashboard->dashboard_content_layouter == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_layouter . '</div>';
            }
         } elseif ($level == 'editor') {
            if (!empty($tulisan_dashboard->dashboard_content_editor) or $tulisan_dashboard->dashboard_content_editor == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $tulisan_dashboard->dashboard_content_editor . '</div>';
            }
         }
         ?>
    </p>

</header>
<div class="page-section">
    <?php
      if (is_admin()) {
         $this->load->view('home/home_admin');
      }

      if ($level == 'reviewer') {
         $this->load->view('home/home_reviewer');
      }

      if ($level == 'author') {
         $this->load->view('home/home_author');
      }

      if ($level == 'editor') {
         $this->load->view('home/home_editor');
      }

      if ($level == 'layouter') {
         $this->load->view('home/home_layouter');
      } ?>
</div>
