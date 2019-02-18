<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->pages = 'performance';
    }

  /* Fungsi untuk menampilkan halaman performa editor */
  public function index($page = null)
    {
      // $this->db->group_by('draft_id');
      $performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->orderBy('username')->getAll('draft');

      $total = count($performance_editor);

      $tot = count($total);
      $pages    = $this->pages;
      $main_view = 'performance/performance_editor';
      $pagination = $this->performance->makePagination(site_url('performance'), 2, $tot);
      $this->load->view('template', compact('pagination','main_view', 'pages', 'performance_editor', 'tot','total'));
    }

  /* Fungsi untuk menampilkan halaman performa layouter */
  public function performa_layouter()
    {
      $this->db->group_by('draft.draft_id');
      $performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->orderBy('performance_status')->getAll('draft');

      $total = count($performance_layouter);

      $pages    = $this->pages;
      $main_view = 'performance/performance_layouter';

      $this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
    }
  }
