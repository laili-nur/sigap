<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends Admin_Controller {


	/*Controller for fetching data to the table*/

	public function index()
	{
		$drafts     = $this->reporting->fetch_data();

		$main_view  = 'report/report_draft';

		$this->load->view('template', compact('main_view', 'drafts'));
	}

	public function index_books()
	{
		$books     = $this->reporting->fetch_data_book();

		$main_view  = 'report/report_book';

		$this->load->view('template', compact('main_view', 'books'));
	}

	public function index_author()
	{
		$author     = $this->reporting->fetch_data_author();

		$main_view  = 'report/report_author';

		$this->load->view('template', compact('main_view', 'author'));
	}

	public function performa_editor()
	{

		$performance_editor = $this->reporting->select(['draft_title','username','edit_start_date','edit_deadline','edit_end_date'])->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'editor')->getAll('draft');

		$main_view = 'report/performance_editor';

		$this->load->view('template', compact('main_view', 'performance_editor'));

	}

	public function performa_layouter()
	{
		$performance_layouter = $this->reporting->select(['draft_title','username','layout_start_date','layout_deadline','layout_end_date'])->join3('responsibility','draft','draft')->join3('user','responsibility','user')->where('level', 'layouter')->getAll('draft');

		$main_view = 'report/performance_layouter';

		$this->load->view('template', compact('main_view', 'performance_layouter'));
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

/* End of file Reporting.php */
/* Location: ./application/controllers/Reporting.php */
