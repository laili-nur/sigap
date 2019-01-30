<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends Admin_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->pages = 'reporting';
    }

	/*Controller for fetching data to the table*/

	public function index()
	{
		$summaries     = $this->reporting->fetch_data();

		$pages    = $this->pages;
		$main_view  = 'report/summary';

		$this->load->view('template', compact('main_view', 'pages', 'summaries'));
	}

	public function index_draft()
	{
		$drafts     = $this->reporting->fetch_data_draft();

		$pages    = $this->pages;
		$main_view  = 'report/report_draft';

		$this->load->view('template', compact('main_view', 'pages', 'drafts'));
	}

	public function index_books()
	{
		$books     = $this->reporting->fetch_data_book();

		$pages    = $this->pages;
		$main_view  = 'report/report_book';

		$this->load->view('template', compact('main_view', 'pages','books'));
	}

	public function index_author()
	{
		$author     = $this->reporting->fetch_data_author();

		$pages    = $this->pages;
		$main_view  = 'report/report_author';

		$this->load->view('template', compact('main_view', 'pages','author'));
	}

	public function index_hibah()
	{
		$hibah     = $this->reporting->fetch_data_hibah();

		$pages    = $this->pages;
		$main_view  = 'report/report_hibah';

		$this->load->view('template', compact('main_view', 'pages','hibah'));
	}

	public function performa_editor()
	{

		$performance_editor = $this->reporting->select(['draft_title','username','edit_start_date','edit_deadline','edit_end_date'])->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->getAll('draft');

		$pages    = $this->pages;
		$main_view = 'report/performance_editor';

		$this->load->view('template', compact('main_view', 'pages', 'performance_editor'));

	}

	public function performa_layouter()
	{
		$performance_layouter = $this->reporting->select(['draft_title','username','layout_start_date','layout_deadline','layout_end_date'])->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->getAll('draft');

		$pages    = $this->pages;
		$main_view = 'report/performance_layouter';

		$this->load->view('template', compact('main_view', 'pages', 'performance_layouter'));
	}

	public function getSummary()
	{
		$count_review = 0;
		$count_disetujui = 0;
		$count_editor = 0;
		$count_layout = 0;
		$count_proofread = 0;
		$count_book = 0;
		$year = $this->input->get('droptahunsummary');

		$result_review = $this->reporting->select(['draft_status'])->getSummary($year);
		foreach ($result_review as $hasil_review){
			if ($hasil_review->draft_status == 4 or $hasil_review->draft_status == 5) {
					$count_review++;
			}
		}
		$result['count_review'] = $count_review;

		$result_disetujui = $this->reporting->select(['is_review'])->getSummary($year);
		foreach ($result_disetujui as $hasil_disetujui) {
			if ($hasil_disetujui->is_review == 'y') {
				$count_disetujui++;
			}
		}
		$result['count_disetujui'] = $count_disetujui;

		$result_editor = $this->reporting->select(['is_review','is_edit','is_layout','is_proofread'])->getSummary($year);
		foreach ($result_editor as $hasil_editor) {
			if ($hasil_editor->is_review == 'y' AND $hasil_editor->is_edit == 'n') {
				$count_editor++;
			}
			if($hasil_editor->is_edit == 'y' AND $hasil_editor->is_layout == 'n'){
				$count_layout++;
			}
			if($hasil_editor->is_layout == 'y' AND $hasil_editor->is_proofread == 'n'){
				$count_proofread++;
			}
			if($hasil_editor->is_proofread == 'y'){
				$count_book++;
			}
		}
		$result['count_editor'] = $count_editor;
		$result['count_layout'] = $count_layout;
		$result['count_proofread'] = $count_proofread;
		$result['count_book'] = $count_book;
		echo json_encode($result);
	}

	public function getPie()
	{
		$count_ugm = 0;
		$count_lain = 0;

		$result_ugm = $this->reporting->select(['institute_id'])->getAll('author');
		foreach ($result_ugm as $institute_ugm){
			if ($institute_ugm->institute_id == 4) {
					$count_ugm++;
			}
			else {
				$count_lain++;
			}
		}
		$result['count_ugm'] = $count_ugm;
		$result['count_lain'] = $count_lain;
		echo json_encode($result);
	}

	public function getPieAuthorGelar(){
		$count_prof = 0;
		$count_doctor = 0;
		$count_lainnya = 0;

		$result_gelar = $this->reporting->select(['author_latest_education'])->getAll('author');
		foreach ($result_gelar as $gelar_ugm){
			if ($gelar_ugm->author_latest_education == 's4'){
				$count_prof++;
			}
			elseif ($gelar_ugm->author_latest_education == 's3'){
				$count_doctor++;
			}
			else {
				$count_lainnya++;
			}
		}
		$result['count_prof'] = $count_prof;
		$result['count_doctor'] = $count_doctor;
		$result['count_lainnya'] = $count_lainnya;
		echo json_encode($result);
	}

	public function getPieHibah()
	{
		$count_hibah = 0;
		$count_reguler = 0;
		$year = $this->input->get('droptahunhibah');

		$result_ugm = $this->reporting->select(['category_type'])->join3('category', 'draft', 'category')->where('YEAR(entry_date)',$year)->getAll('draft');
		foreach ($result_ugm as $category_ugm){
			if ($category_ugm->category_type == 1) {
					$count_hibah++;
			}
			else {
					$count_reguler++;
			}
		}
		$result['count_hibah'] = $count_hibah;
		$result['count_reguler'] = $count_reguler;
		echo json_encode($result);
	}

	public function getDraft()
  {
		$year = $this->input->get('droptahun');
		for($i = 1; $i <= 12; $i++)
		{
			$result[$i] = $this->reporting->getDraft($i, $year);
			$result['count'][$i] = count($result[$i]);
		}
		echo json_encode($result);
  }

	public function getBook()
  {
		$year = $this->input->get('droptahunbuku');
		for($i = 1; $i <= 12; $i++)
		{
			$result[$i] = $this->reporting->getBook($i,$year);
			$result['count'][$i] = count($result[$i]);
		}
		echo json_encode($result);
  }

	public function getAuthor()
  {
		for($i = 1; $i <= 3; $i++)
		{
			$result[$i] = $this->reporting->getAuthor($i);
			$result['count'][$i] = count($result[$i]);
		}
		echo json_encode($result);
  }


	public function getYearsSummary()
	{
		$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->getAllArray('draft');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['entry_date']));
		}
		echo json_encode($tahun);
	}

	public function getYears()
	{
		$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->getAllArray('draft');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['entry_date']));
		}
		echo json_encode($tahun);
	}

	public function getYearsBook()
	{
		$filtertahun = $this->reporting->group_by('YEAR(published_date)')->getAllArray('book');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['published_date']));
		}
		echo json_encode($tahun);
	}

	public function getYearsHibah()
	{
		$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->getAllArray('draft');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['entry_date']));
		}
		echo json_encode($tahun);
	}

}

/* End of file Reporting.php */
/* Location: ./application/controllers/Reporting.php */
