<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->pages = 'performance';

		$performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->where('responsibility.user_id !=', null)->orderBy('performance_status')->getAll('draft');

		foreach ($performance_editor as $key => $row) {
			if(($row->edit_start_date == '0000-00-00 00:00:00' OR $row->edit_start_date == 'NULL') AND ($row->edit_end_date == '0000-00-00 00:00:00' OR $row->edit_end_date == 'NULL')){
				$data	= array('performance_status' => null);
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif (($row->edit_start_date != '0000-00-00 00:00:00' AND $row->edit_start_date != 'NULL') AND ($row->edit_end_date == '0000-00-00 00:00:00' OR $row->edit_end_date == 'NULL')){
				$data	= array('performance_status' => '1');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif ($row->is_edit == 'n' AND ($row->edit_end_date < $row->edit_deadline) AND $row->edit_start_date != '0000-00-00 00:00:00' AND $row->edit_start_date != 'NULL' AND $row->edit_end_date != '0000-00-00 00:00:00' AND $row->edit_end_date != 'NULL') {
				$data	= array('performance_status' => '2');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif ($row->is_edit == 'y' AND ($row->edit_end_date < $row->edit_deadline) AND $row->edit_start_date != '0000-00-00 00:00:00' AND $row->edit_start_date != 'NULL' AND $row->edit_end_date != '0000-00-00 00:00:00' AND $row->edit_end_date != 'NULL') {
				$data	= array('performance_status' => '3');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif ($row->edit_end_date > $row->edit_deadline AND ($row->edit_start_date != '0000-00-00 00:00:00' AND $row->edit_start_date != 'NULL') AND ($row->edit_end_date != '0000-00-00 00:00:00' AND $row->edit_end_date != 'NULL')) {
				$data	= array('performance_status' => '4');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			else {
				$data	= array('performance_status' => '5');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
		}

		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('responsibility.user_id !=', null)->orderBy('performance_status')->getAll('draft');

		foreach ($performance_layouter as $key => $row) {
			if(($row->layout_start_date == '0000-00-00 00:00:00' OR $row->layout_start_date == 'NULL') AND ($row->layout_end_date == '0000-00-00 00:00:00' OR $row->layout_end_date == 'NULL')){
				$data	= array('performance_status' => null);
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif (($row->layout_start_date != '0000-00-00 00:00:00' AND $row->layout_start_date != 'NULL') AND ($row->layout_end_date == '0000-00-00 00:00:00' OR $row->layout_end_date == 'NULL')){
				$data	= array('performance_status' => '1');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif ($row->is_layout == 'n' AND ($row->layout_end_date < $row->layout_deadline) AND $row->layout_start_date != '0000-00-00 00:00:00' AND $row->layout_start_date != 'NULL' AND $row->layout_end_date != '0000-00-00 00:00:00' AND $row->layout_end_date != 'NULL') {
				$data	= array('performance_status' => '2');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif ($row->is_layout == 'y' AND ($row->layout_end_date < $row->layout_deadline) AND $row->layout_start_date != '0000-00-00 00:00:00' AND $row->layout_start_date != 'NULL' AND $row->layout_end_date != '0000-00-00 00:00:00' AND $row->layout_end_date != 'NULL') {
				$data	= array('performance_status' => '3');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			elseif ($row->layout_end_date > $row->layout_deadline AND ($row->layout_start_date != '0000-00-00 00:00:00' AND $row->layout_start_date != 'NULL') AND ($row->layout_end_date != '0000-00-00 00:00:00' AND $row->layout_end_date != 'NULL')) {
				$data	= array('performance_status' => '4');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
			else {
				$data	= array('performance_status' => '5');
				$this->performance->where('draft_id', $row->draft_id)->update($data, 'responsibility');
			}
		}
	}

	/* Fungsi untuk menampilkan halaman performa editor */
	public function index()
	{
		// $this->db->group_by('draft_id');
		$performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->where('performance_status', 1)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('performance_status', 1)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');


		$total = count($performance_editor);

		$pages    = $this->pages;
		$main_view = 'performance/performance_editor';

		$this->load->view('template', compact('pagination','main_view', 'pages', 'performance_editor','total'));
	}

	public function index_final()
	{
		// $this->db->group_by('draft_id');
		$performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->where('performance_status', 2)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_editor);

		$pages    = $this->pages;
		$main_view = 'performance/performance_editor';

		$this->load->view('template', compact('pagination','main_view', 'pages', 'performance_editor','total'));
	}

	public function index_ontime()
	{
		// $this->db->group_by('draft_id');
		$performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->where('performance_status',3)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_editor);

		$pages    = $this->pages;
		$main_view = 'performance/performance_editor';

		$this->load->view('template', compact('pagination','main_view', 'pages', 'performance_editor','total'));
	}

	public function index_late()
	{
		// $this->db->group_by('draft_id');
		$performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->where('performance_status',4)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_editor);

		$pages    = $this->pages;
		$main_view = 'performance/performance_editor';

		$this->load->view('template', compact('pagination','main_view', 'pages', 'performance_editor','total'));
	}

	public function index_error()
	{
		$performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->where('performance_status',5)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_editor);

		$pages    = $this->pages;
		$main_view = 'performance/performance_editor';

		$this->load->view('template', compact('pagination','main_view', 'pages', 'performance_editor','total'));
	}

	public function index_null()
	{
		$performance_editor = $this->performance->select(['draft.draft_id','draft_title','username','category_name','edit_start_date','edit_deadline','edit_end_date','is_edit','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->where('performance_status',null)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_editor);

		$pages    = $this->pages;
		$main_view = 'performance/performance_editor';

		$this->load->view('template', compact('pagination','main_view', 'pages', 'performance_editor','total'));
	}

	public function performa_layouter()
	{
		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('performance_status', 1)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_layouter);

		$pages    = $this->pages;
		$main_view = 'performance/performance_layouter';

		$this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
	}

	public function performa_layouter_final()
	{
		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('performance_status', 2)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_layouter);

		$pages    = $this->pages;
		$main_view = 'performance/performance_layouter';

		$this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
	}

	public function performa_layouter_ontime()
	{
		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('performance_status', 3)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_layouter);

		$pages    = $this->pages;
		$main_view = 'performance/performance_layouter';

		$this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
	}

	public function performa_layouter_late()
	{
		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('performance_status', 4)->where('responsibility.user_id !=', null)->orderBy('performance_status')->getAll('draft');

		$total = count($performance_layouter);

		$pages    = $this->pages;
		$main_view = 'performance/performance_layouter';

		$this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
	}

	public function performa_layouter_error()
	{
		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('performance_status', 5)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_layouter);

		$pages    = $this->pages;
		$main_view = 'performance/performance_layouter';

		$this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
	}

	public function performa_layouter_null()
	{
		$performance_layouter = $this->performance->select(['draft.draft_id','draft_title','username','category_name','layout_start_date','layout_deadline','layout_end_date','is_layout','performance_status'])->join3('category','draft','category')->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->where('performance_status', null)->where('responsibility.user_id !=', null)->orderBy('username')->getAll('draft');

		$total = count($performance_layouter);

		$pages    = $this->pages;
		$main_view = 'performance/performance_layouter';

		$this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
	}
}
