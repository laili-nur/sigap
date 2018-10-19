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

		$result_review = $this->reporting->select(['draft_status'])->getAll('draft');
		foreach ($result_review as $hasil_review){
			if ($hasil_review->draft_status == 5) {
					$count_review++;
			}
		}
		$result['count_review'] = $count_review;

		$result_disetujui = $this->reporting->select(['is_review'])->getAll('draft');
		foreach ($result_disetujui as $hasil_disetujui) {
			if ($hasil_disetujui->is_review == 'y') {
				$count_disetujui++;
			}
		}
		$result['count_disetujui'] = $count_disetujui;

		$result_editor = $this->reporting->select(['is_review','is_edit','is_layout','is_proofread'])->getAll('draft');
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

	public function getDraft()
  {
		for($i = 1; $i <= 12; $i++)
		{
			$result[$i] = $this->reporting->getDraft($i);
			$result['count'][$i] = count($result[$i]);
		}
		echo json_encode($result);
  }

	public function getBook()
  {
		for($i = 1; $i <= 12; $i++)
		{
			$result[$i] = $this->reporting->getBook($i);
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

	/*GET Controller for access API*/

	public function apiDraft($draft_id = NULL)
	{
		$result=$this->reporting->apiDraft($draft_id);
		echo json_encode($result);
	}

	public function apiBook($book_id = NULL)
	{

		$result=$this->reporting->apiBook($book_id);
		echo json_encode($result);
	}

	public function apiAuthor($author_id = NULL)
	{

		$result=$this->reporting->apiAuthor($author_id);
		echo json_encode($result);
	}
}

/*search filter*/


/* End of file Reporting.php */
/* Location: ./application/controllers/Reporting.php */
