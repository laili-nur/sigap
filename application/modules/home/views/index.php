<?php
$username = $this->session->userdata('username');
$is_login = $this->session->userdata('is_login');
$level = $this->session->userdata('level');
$semua = $this->session->userdata();
?>

<header class="page-title-bar">
    <p class="lead">
        <span class="font-weight-bold">Halo, <?= $username; ?></span>
        <span class="d-block text-muted">
            <?= (!empty($dashboard_text->dashboard_head)) ? $dashboard_text->dashboard_head : ''; ?>
        </span>
        <?php
         if ($level == 'author') {
            if (!empty($dashboard_text->dashboard_content_author) or $dashboard_text->dashboard_content_author == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $dashboard_text->dashboard_content_author . '</div>';
            }
         } elseif ($level == 'reviewer') {
            if (!empty($dashboard_text->dashboard_content_reviewer) or $dashboard_text->dashboard_content_reviewer == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $dashboard_text->dashboard_content_reviewer . '</div>';
            }
         } elseif ($level == 'layouter') {
            if (!empty($dashboard_text->dashboard_content_layouter) or $dashboard_text->dashboard_content_layouter == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $dashboard_text->dashboard_content_layouter . '</div>';
            }
         } elseif ($level == 'editor') {
            if (!empty($dashboard_text->dashboard_content_editor) or $dashboard_text->dashboard_content_editor == '<p><br></p>') {
               echo '<div class="alert alert-info">' . $dashboard_text->dashboard_content_editor . '</div>';
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

      if ($level == 'editor' || $level == 'layouter') {
         $this->load->view('home/home_staff');
      }
      ?>
</div>
