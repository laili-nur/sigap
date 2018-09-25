<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting extends CI_Controller {

	public function index()
	{
		$main_view  = 'report/report';

		$this->load->view('template', compact('main_view'));
	}

}

/* End of file Reporting.php */
/* Location: ./application/controllers/Reporting.php */