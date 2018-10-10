<!-- .page-title-bar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
  <header class="page-title-bar">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?=base_url()?>"><span class="fa fa-home"></span> Admin Panel</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?=base_url('reporting')?>">Report</a>
        </li>
        <li class="breadcrumb-item active">
          <a class="text-muted">Reporting Author</a>
        </li>
      </ol>
    </nav>
    <h1 class="page-title"> Report </h1>
  </header>
  <!-- Reporting buku -->
  <ul nav class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index') ?>">Summary</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_draft') ?>">Reporting Draft</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/index_books') ?>">Reporting Book</a></li>
    <li class="nav-item"><a class="nav-link active" href="<?= base_url('reporting/index_author') ?>">Reporting Author</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_editor') ?>">Performa Editor</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= base_url('reporting/performa_layouter') ?>">Performa Layouter</a></li>
  </ul>
  <!-- Reporting buku -->
  <!-- /.page-title-bar -->
  <br />
  <h5>Report Author</h5>
  <br />
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>Author ID</th>
          <th>Author Name</th>
          <th>Author Email</th>
        </tr>
      <?php
      if($author)
      {
        foreach ($author as $row)
        {
      ?>
        <tr>
          <td><?php echo $row->author_id; ?></td>
          <td><?php echo $row->author_name; ?></td>
          <td><?php echo $row->author_email; ?></td>
        </tr>
        <?php
        }
      }
      else
      {
        ?>
        <tr>
          <td colspan="3">No data found</td>
        </tr>
      <?php
      }
      ?>
      </table>
    </div>
