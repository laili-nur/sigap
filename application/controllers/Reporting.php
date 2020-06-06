<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('application/libraries/phpspreadsheet/vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Reporting extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->pages = 'reporting';
		\PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
	}

	/*Controller for fetching data to the table*/

	/* Fungsi untuk menampilkan halaman summary */
	public function index()
	{
		$summaries     = $this->reporting->fetch_data();

		$pages    = $this->pages;
		$main_view  = 'report/summary';

		$this->load->view('template', compact('main_view', 'pages', 'summaries'));
	}
	/* Fungsi untuk menampilkan halaman summary baru */
	public function index_baru()
	{
		$new     = $this->reporting->fetch_data_baru();

		$pages    = $this->pages;
		$main_view  = 'report/naskahbaru';

		$this->load->view('template', compact('main_view', 'pages', 'new'));
	}
	/* Fungsi untuk menampilkan halaman summary ulang */
	public function index_ulang()
	{
		$reprint     = $this->reporting->fetch_data_ulang();

		$pages    = $this->pages;
		$main_view  = 'report/cetakulang';

		$this->load->view('template', compact('main_view', 'pages', 'reprint'));
	}
	/* Fungsi untuk menampilkan halaman draft */
	public function index_draft()
	{
		$drafts     = $this->reporting->fetch_data_draft();

		$pages    = $this->pages;
		$main_view  = 'report/report_draft';

		$this->load->view('template', compact('main_view', 'pages', 'drafts'));
	}
	/* Fungsi untuk menampilkan halaman buku */
	public function index_books()
	{
		$books     = $this->reporting->fetch_data_book();

		$pages    = $this->pages;
		$main_view  = 'report/report_book';

		$this->load->view('template', compact('main_view', 'pages','books'));
	}
	/* Fungsi untuk menampilkan halaman penulis */
	public function index_author()
	{
		$author     = $this->reporting->fetch_data_author();

		$pages    = $this->pages;
		$main_view  = 'report/report_author';

		$this->load->view('template', compact('main_view', 'pages','author'));
	}
	/* Fungsi untuk menampilkan halaman hibah*/
	public function index_hibah()
	{
		$hibah     = $this->reporting->fetch_data_hibah();

		$pages    = $this->pages;
		$main_view  = 'report/report_hibah';

		$this->load->view('template', compact('main_view', 'pages','hibah'));
	}
	/* Fungsi untuk menampilkan halaman performa editor */

	/* Fungsi untuk menampilkan grafik summary */
	public function getSummary()
	{
		$count_review = 0;
		$count_disetujui = 0;
		$count_antri_editor = 0;
		$count_editor = 0;
		$count_layout = 0;
		$count_proofread = 0;
		$count_print = 0;
		$count_final = 0;
		$year = $this->input->get('droptahunsummary');
		$category = $this->input->get('category');

		$result_review = $this->reporting->select(['draft_status'])->getSummary($year, $category);
		foreach ($result_review as $hasil_review){
			if ($hasil_review->draft_status == 4) {
				$count_review++;
			}
			if ($hasil_review->draft_status == 5){
				$count_antri_editor++;
			}
		}
		$result['count_review'] = $count_review;
		$result['count_antri_editor'] = $count_antri_editor;

		$result_disetujui = $this->reporting->select(['is_review'])->getSummary($year, $category);
		foreach ($result_disetujui as $hasil_disetujui) {
			if ($hasil_disetujui->is_review == 'y') {
				$count_disetujui++;
			}
		}
		$result['count_disetujui'] = $count_disetujui;

		$result_editor = $this->reporting->select(['is_review','is_edit','is_layout','is_proofread', 'is_print'])->getSummary($year, $category);
		foreach ($result_editor as $hasil_editor) {
			if ($hasil_editor->draft_status == 6 AND $hasil_editor->is_edit == 'n') {
				$count_editor++;
			}
			if($hasil_editor->is_edit == 'y' AND $hasil_editor->is_layout == 'n'){
				$count_layout++;
			}
			if($hasil_editor->is_layout == 'y' AND $hasil_editor->is_proofread == 'n'){
				$count_proofread++;
			}
			if($hasil_editor->is_proofread == 'y' AND $hasil_editor->is_print == 'n'){
				$count_print++;
			}
			if($hasil_editor->is_print == 'y'){
				$count_final++;
			}
		}
		$result['count_editor'] = $count_editor;
		$result['count_layout'] = $count_layout;
		$result['count_proofread'] = $count_proofread;
		$result['count_print'] = $count_print;
		$result['count_final'] = $count_final;
		echo json_encode($result);
	}

	public function getSummaryBaru()
	{
		$count_review_baru = 0;
		$count_disetujui_baru = 0;
		$count_antri_editor_baru = 0;
		$count_editor_baru = 0;
		$count_layout_baru = 0;
		$count_proofread_baru = 0;
		$count_print_baru = 0;
		$count_final_baru = 0;
		$year = $this->input->get('droptahunsummary');
		$category = $this->input->get('category');

		$result_review = $this->reporting->select(['draft_status', 'is_reprint'])->getSummaryBaru($year, $category);
		foreach ($result_review as $hasil_review){
			if ($hasil_review->draft_status == 4 AND $hasil_review->is_reprint == 'n') {
				$count_review_baru++;
			}
			if ($hasil_review->draft_status == 5 AND $hasil_review->is_reprint == 'n'){
				$count_antri_editor_baru++;
			}
		}
		$result['count_review_baru'] = $count_review_baru;
		$result['count_antri_editor_baru'] = $count_antri_editor_baru;

		$result_disetujui = $this->reporting->select(['is_review','is_reprint'])->getSummaryBaru($year,$category);
		foreach ($result_disetujui as $hasil_disetujui) {
			if ($hasil_disetujui->is_review == 'y' AND $hasil_disetujui->is_reprint == 'n') {
				$count_disetujui_baru++;
			}
		}
		$result['count_disetujui_baru'] = $count_disetujui_baru;

		$result_editor = $this->reporting->select(['is_review','is_edit','is_layout','is_proofread', 'is_print', 'is_reprint','draft_status'])->getSummaryBaru($year, $category);
		foreach ($result_editor as $hasil_editor) {
			if (($hasil_editor->draft_status == 6) AND $hasil_editor->is_reprint == 'n') {
				$count_editor_baru++;
			}
			if(($hasil_editor->is_edit == 'y' AND $hasil_editor->is_layout == 'n') AND $hasil_editor->is_reprint == 'n'){
				$count_layout_baru++;
			}
			if(($hasil_editor->is_layout == 'y' AND $hasil_editor->is_proofread == 'n') AND $hasil_editor->is_reprint == 'n'){
				$count_proofread_baru++;
			}
			if(($hasil_editor->is_proofread == 'y' AND $hasil_editor->is_print == 'n') AND $hasil_editor->is_reprint == 'n'){
				$count_print_baru++;
			}
			if(($hasil_editor->is_print == 'y') AND $hasil_editor->is_reprint == 'n'){
				$count_final_baru++;
			}
		}
		$result['count_editor_baru'] = $count_editor_baru;
		$result['count_layout_baru'] = $count_layout_baru;
		$result['count_proofread_baru'] = $count_proofread_baru;
		$result['count_print_baru'] = $count_print_baru;
		$result['count_final_baru'] = $count_final_baru;
		echo json_encode($result);
	}

	public function getSummaryUlang()
	{
		$count_review_ulang = 0;
		$count_disetujui_ulang = 0;
		$count_antri_editor_ulang = 0;
		$count_editor_ulang = 0;
		$count_layout_ulang = 0;
		$count_proofread_ulang = 0;
		$count_print_ulang = 0;
		$count_final_ulang = 0;
		$year = $this->input->get('droptahunsummary');
		$category = $this->input->get('category');

		$result_review = $this->reporting->select(['draft_status', 'is_reprint'])->getSummaryUlang($year, $category);
		foreach ($result_review as $hasil_review){
			if ($hasil_review->draft_status == 4 AND $hasil_review->is_reprint == 'y') {
				$count_review_ulang++;
			}
			if ($hasil_review->draft_status == 5 AND $hasil_review->is_reprint == 'y'){
				$count_antri_editor_ulang++;
			}
		}
		$result['count_review_ulang'] = $count_review_ulang;
		$result['count_antri_editor_ulang'] = $count_antri_editor_ulang;

		$result_disetujui = $this->reporting->select(['is_review','is_reprint'])->getSummaryUlang($year, $category);
		foreach ($result_disetujui as $hasil_disetujui) {
			if ($hasil_disetujui->is_review == 'y' AND $hasil_disetujui->is_reprint == 'y') {
				$count_disetujui_ulang++;
			}
		}
		$result['count_disetujui_ulang'] = $count_disetujui_ulang;

		$result_editor = $this->reporting->select(['is_review','is_edit','is_layout','is_proofread', 'is_print', 'is_reprint'])->getSummaryUlang($year, $category);
		foreach ($result_editor as $hasil_editor) {
			if (($hasil_editor->draft_status == 6) AND $hasil_editor->is_reprint == 'y') {
				$count_editor_ulang++;
			}
			if(($hasil_editor->is_edit == 'y' AND $hasil_editor->is_layout == 'n') AND $hasil_editor->is_reprint == 'y'){
				$count_layout_ulang++;
			}
			if(($hasil_editor->is_layout == 'y' AND $hasil_editor->is_proofread == 'n') AND $hasil_editor->is_reprint == 'y'){
				$count_proofread_ulang++;
			}
			if(($hasil_editor->is_proofread == 'y' AND $hasil_editor->is_print == 'n') AND $hasil_editor->is_reprint == 'y'){
				$count_print_ulang++;
			}
			if(($hasil_editor->is_print == 'y') AND $hasil_editor->is_reprint == 'y'){
				$count_final_ulang++;
			}
		}
		$result['count_editor_ulang'] = $count_editor_ulang;
		$result['count_layout_ulang'] = $count_layout_ulang;
		$result['count_proofread_ulang'] = $count_proofread_ulang;
		$result['count_print_ulang'] = $count_print_ulang;
		$result['count_final_ulang'] = $count_final_ulang;
		echo json_encode($result);
	}

	/* Fungsi untuk menampilkan grafik penulis berdasarkan instansi */
	public function getPie()
	{
		$count_ugm = 0;
		$count_lain = 0;

		$result_ugm = $this->reporting->select(['institute_id'])->getAll('author');
		foreach ($result_ugm as $institute_ugm){
			if ($institute_ugm->institute_id == 1) {
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

	/* Fungsi untuk menampilkan grafik penulis berdasarkan gelar */
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

	/* Fungsi untuk menampilkan grafik hibah */
	public function getPieHibah()
	{
		$count_hibah = 0;
		$count_reguler = 0;
		$count_cetak_ulang = 0;
		$year = $this->input->get('droptahunhibah');

		$result_ugm = $this->reporting->select(['category_type','is_reprint'])->join3('category', 'draft', 'category')->where('YEAR(entry_date)',$year)->getAll('draft');
		foreach ($result_ugm as $category_ugm){
			if ($category_ugm->category_type == 1 AND $category_ugm->is_reprint == 'n') {
				$count_hibah++;
			}
			if ($category_ugm->category_type == 2 AND $category_ugm->is_reprint == 'n'){
				$count_reguler++;
			}
			if ($category_ugm->category_type == 3){
				$count_cetak_ulang++;
			}
			if (($category_ugm->category_type == 1 OR $category_ugm->category_type == 2) AND $category_ugm->is_reprint == 'y'){
				$count_cetak_ulang++;
			}
		}
		$result['count_hibah'] = $count_hibah;
		$result['count_reguler'] = $count_reguler;
		$result['count_cetak_ulang'] = $count_cetak_ulang;
		echo json_encode($result);
	}

	/* Fungsi untuk menambah data pada grafik draft*/
	public function getDraft()
	{
		$year = $this->input->get('droptahun');
		$category = $this->input->get('category');
		for($i = 1; $i <= 12; $i++)
		{
			$result[$i] = $this->reporting->getDraft($i, $year, $category);
			$result['count'][$i] = count($result[$i]);
		}
		echo json_encode($result);
	}

	/* Fungsi untuk menambah data pada grafik buku*/
	public function getBook()
	{
		$year = $this->input->get('droptahunbuku');
		$category = $this->input->get('category');
		for($i = 1; $i <= 12; $i++)
		{
			$result[$i] = $this->reporting->getBook($i,$year,$category);
			$result['count'][$i] = count($result[$i]);
		}
		echo json_encode($result);
	}

	/* Fungsi untuk menambah data pada grafik penulis*/
	public function getAuthor()
	{
		for($i = 1; $i <= 3; $i++)
		{
			$result[$i] = $this->reporting->getAuthor($i);
			$result['count'][$i] = count($result[$i]);
		}
		echo json_encode($result);
	}

	/* Fungsi filter data pada grafik summary*/
	public function getYearsSummary()
	{
		$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->getAllArray('draft');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['entry_date']));
		}
		echo json_encode($tahun);
	}

	/* Fungsi filter data pada grafik summary cetak ulang*/
	public function getYearsSummaryUlang()
	{
		$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->getAllArray('draft');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['entry_date']));
		}
		echo json_encode($tahun);
	}

	/* Fungsi filter data pada grafik draft*/
	public function getYears()
	{
		$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->getAllArray('draft');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['entry_date']));
		}
		echo json_encode($tahun);
	}

	/* Fungsi filter data pada grafik buku*/
	public function getYearsBook()
	{
		$filtertahun = $this->reporting->group_by('YEAR(published_date)')->getAllArray('book');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['published_date']));
		}
		echo json_encode($tahun);
	}

	/* Fungsi filter data pada grafik hibah*/
	public function getYearsHibah()
	{
		$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->getAllArray('draft');
		foreach ($filtertahun as $key => $value){
			$tahun[$key] = date('Y',strtotime($value['entry_date']));
		}
		echo json_encode($tahun);
	}

	function export_summary($tahun=null){
		//select year(published_date) tahun, sum((case when book_edition='' or book_edition='1' or book_edition='Pertama' then 1 else 0 end)) jml_terbit_baru, sum((case when book_edition<>'' and book_edition<>'1' and book_edition<>'Pertama' then 1 else 0 end)) jml_cetak_ulang from book group by year(published_date) order by tahun asc
		$this->db->select("year(published_date) tahun, sum((case when book_edition='' or book_edition='1' or book_edition='Pertama' then 1 else 0 end)) jml_terbit_baru, sum((case when book_edition<>'' and book_edition<>'1' and book_edition<>'Pertama' then 1 else 0 end)) jml_cetak_ulang");
		$this->db->from("book");
		if($tahun!=null){
			$this->db->where("year(published_date)", $tahun);
		}
		$this->db->group_by("year(published_date)");
		$this->db->order_by("tahun", "asc");
		$query = $this->db->get();
		try{
			// Create new Spreadsheet object
			$spreadsheet = new Spreadsheet();

			// Set document properties
			$spreadsheet->getProperties()->setCreator('SIGAP')
			->setLastModifiedBy('SIGAP')
			->setTitle('Summary')
			->setSubject('Summary')
			->setDescription('Data Summary SIGAP')
			->setKeywords('office 2007 openxml php')
			->setCategory('Report generated');

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'REPORT SUMMARY SIGAP');
			$spreadsheet->getActiveSheet()->mergeCells('A1:F1');
			$spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
			$spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);


			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A3', 'NO')
			->setCellValue('B3', 'TAHUN')
			->setCellValue('C3', 'JUMLAH BUKU TERBIT BARU')
			->setCellValue('D3', 'JUMLAH BUKU CETAK ULANG')
			->setCellValue('E3', 'JUMLAH PENULIS UGM')
			->setCellValue('F3', 'JUMLAH PENULIS NON UGM');
			$spreadsheet->getActiveSheet()->getStyle('A3:F3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B3B3B3');
			$spreadsheet->getActiveSheet()->getStyle('A3:F3')->getAlignment()->setHorizontal('center');
			//->setCellValue('L1', 'OBAT LAMA');
			// Miscellaneous glyphs, UTF-8
			$i=4; 
			$no = 1;
			foreach($query->result() as $row) {
				$jml_penulis_ugm = $this->get_jml_buku_by_institute("1", $row->tahun);
				$jml_penulis_non_ugm = $this->get_jml_buku_by_institute("2", $row->tahun);
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $no)
				->setCellValue('B'.$i, $row->tahun)
				->setCellValue('C'.$i, $row->jml_terbit_baru)
				->setCellValue('D'.$i, $row->jml_cetak_ulang)
				->setCellValue('E'.$i, $jml_penulis_ugm)
				->setCellValue('F'.$i, $jml_penulis_non_ugm);

				$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$i++;
				$no++;
			}
			$styleArray = [
			    'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '000'],
			        ],
			    ],
			];
			$spreadsheet->getActiveSheet()->getStyle('A3:F'.($i-1))->applyFromArray($styleArray);

			// Rename worksheet
			$spreadsheet->getActiveSheet()->setTitle('summary');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$spreadsheet->setActiveSheetIndex(0);

			// Redirect output to a client’s web browser (Xlsx)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="summary_sigap.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			ob_end_clean();
			$writer->save('php://output');
			exit;
		}catch(\Exception $e) {
		    print_r($e);
		}
	}

	function get_jml_buku_by_institute($jenis, $tahun){
		//SELECT * FROM `book` `b` JOIN `draft_author` `da` ON `b`.`draft_id`=`da`.`draft_id` JOIN `author` `a` ON `da`.`author_id`=`a`.`author_id` WHERE `institute_id` = '1' AND year(published_date) = '2019' group by da.draft_id order by da.draft_id
		$this->db->select("*");
		$this->db->from("book b");
		$this->db->join("draft_author da", "b.draft_id=da.draft_id");
		$this->db->join("author a", "da.author_id=a.author_id");
		if($jenis=="1"){
			$this->db->where("institute_id", $jenis);
		}else{
			$this->db->where("institute_id<>1");
		}
		$this->db->where("year(published_date)", $tahun);
		$this->db->group_by("da.draft_id");
		$jml = $this->db->get()->num_rows();
		return $jml;
	}
	/*
	*naskah baru
	*/
	function ajax_naskah_baru(){
		/*
		$_POST['dari'] = '01/01/2019';
		$_POST['sampai'] = '31/12/2019';
		/*
		//select book_title from book where published_date between '2019-01-01' and '2019-12-31' and (book_edition='' or book_edition='1' or book_edition='Pertama') order by published_date asc
		*/
		$tgl_daris = explode("/", $this->input->post('dari'));
		$tgl_dari = $tgl_daris[2].'-'.$tgl_daris[1].'-'.$tgl_daris[0];
		$tgl_sampais = explode("/", $this->input->post('sampai'));
		$tgl_sampai = $tgl_sampais[2].'-'.$tgl_sampais[1].'-'.$tgl_sampais[0];
		$this->db->select("book_id, draft_id, book_title");
		$this->db->from("book");
		$this->db->where("published_date >=", $tgl_dari);
		$this->db->where("published_date <=", $tgl_sampai);
		$this->db->group_start();
			$this->db->where("book_edition", "Pertama");
			$this->db->or_where("book_edition", "1");
			$this->db->or_where("book_edition", "");
		$this->db->group_end();
		$query = $this->db->get();
		if($query->num_rows()==0){
			echo '{
					"sEcho": 1,
					"iTotalRecords": "0",
					"iTotalDisplayRecords": "0",
					"aaData": []
			}';
		}else{
			$no = 1;
			foreach($query->result() as $row){
				$q_pen_ugm = $this->get_penulis($row->draft_id, "1");
				$penulis_ugm = "";
				foreach($q_pen_ugm->result() as $r_penulis){
					if($penulis_ugm==""){
						$penulis_ugm = "<ul><li>".$r_penulis->author_name."</li>";
					}else{
						$penulis_ugm .= "<li>".$r_penulis->author_name."</li>";
					}
				}
				if($penulis_ugm!=""){
					$penulis_ugm .= "</ul>";
				}
				$q_pen_non_ugm = $this->get_penulis($row->draft_id, "2");
				$penulis_non_ugm = "";
				foreach($q_pen_non_ugm->result() as $r_penulis){
					if($penulis_non_ugm==""){
						$penulis_non_ugm = "<ul><li>".$r_penulis->author_name."</li>";
					}else{
						$penulis_non_ugm .= "<li>".$r_penulis->author_name."</li>";
					}
				}
				if($penulis_non_ugm!=""){
					$penulis_non_ugm .= "</ul>";
				}
				$data['aaData'][] = array('no' => $no, 'judul' => $row->book_title,
										'penulis_ugm' => $penulis_ugm,
										'penulis_non_ugm' => $penulis_non_ugm,
									);
				$no++;
			}
			echo json_encode($data);
		}

	}

	function get_penulis($draf_id, $jenis){
		$this->db->select("author_name");
		$this->db->from("draft_author da");
		$this->db->join("author a", "da.author_id=a.author_id");
		$this->db->where("draft_id", $draf_id);
		if($jenis=='1'){
			$this->db->where("institute_id", $jenis);
		}else{
			$this->db->where("institute_id<>'1'");
		}
		return $this->db->get();
	}

	function export_naskah_baru(){
		$tgl_daris = explode("/", $this->input->post('dari'));
		$tgl_dari = $tgl_daris[2].'-'.$tgl_daris[1].'-'.$tgl_daris[0];
		$tgl_sampais = explode("/", $this->input->post('sampai'));
		$tgl_sampai = $tgl_sampais[2].'-'.$tgl_sampais[1].'-'.$tgl_sampais[0];
		$this->db->select("book_id, draft_id, book_title");
		$this->db->from("book");
		$this->db->where("published_date >=", $tgl_dari);
		$this->db->where("published_date <=", $tgl_sampai);
		$this->db->group_start();
			$this->db->where("book_edition", "Pertama");
			$this->db->or_where("book_edition", "1");
			$this->db->or_where("book_edition", "");
		$this->db->group_end();
		$query = $this->db->get();
		try{
			// Create new Spreadsheet object
			$spreadsheet = new Spreadsheet();

			// Set document properties
			$spreadsheet->getProperties()->setCreator('SIGAP')
			->setLastModifiedBy('SIGAP')
			->setTitle('laporan naskah baru')
			->setSubject('laporan naskah baru')
			->setDescription('laporan naskah baru SIGAP')
			->setKeywords('office 2007 openxml php')
			->setCategory('Report generated');

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'LAPORAN NASKAH BARU');
			$spreadsheet->getActiveSheet()->mergeCells('A1:D1');
			$spreadsheet->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal('center');
			$spreadsheet->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A2', 'periode '.$this->input->post('dari').' s/d '.$this->input->post('sampai'));
			$spreadsheet->getActiveSheet()->mergeCells('A2:D2');
			$spreadsheet->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal('center');
			$spreadsheet->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);


			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A4', 'NO')
			->setCellValue('B4', 'JUDUL BUKU')
			->setCellValue('C4', 'PENULIS UGM')
			->setCellValue('D4', 'PENULIS NON UGM');
			$spreadsheet->getActiveSheet()->getStyle('A4:D4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B3B3B3');
			$spreadsheet->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal('center');
			//->setCellValue('L1', 'OBAT LAMA');
			// Miscellaneous glyphs, UTF-8
			$i=5; 
			$no = 1;
			foreach($query->result() as $row) {
				$q_pen_ugm = $this->get_penulis($row->draft_id, "1");
				$penulis_ugm = "";
				foreach($q_pen_ugm->result() as $r_penulis){
					if($penulis_ugm==""){
						$penulis_ugm = $r_penulis->author_name;
					}else{
						$penulis_ugm .= ", ".$r_penulis->author_name;
					}
				}
				$q_pen_non_ugm = $this->get_penulis($row->draft_id, "2");
				$penulis_non_ugm = "";
				foreach($q_pen_non_ugm->result() as $r_penulis){
					if($penulis_non_ugm==""){
						$penulis_non_ugm = $r_penulis->author_name;
					}else{
						$penulis_non_ugm .= ", ".$r_penulis->author_name;
					}
				}

				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $no)
				->setCellValue('B'.$i, $row->book_title)
				->setCellValue('C'.$i, $penulis_ugm)
				->setCellValue('D'.$i, $penulis_non_ugm);

				$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$i++;
				$no++;
			}
			$styleArray = [
			    'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '000'],
			        ],
			    ],
			];
			$spreadsheet->getActiveSheet()->getStyle('A4:D'.($i-1))->applyFromArray($styleArray);

			// Rename worksheet
			$spreadsheet->getActiveSheet()->setTitle('naskah baru');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$spreadsheet->setActiveSheetIndex(0);

			// Redirect output to a client’s web browser (Xlsx)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_naskah_baru_sigap.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			ob_end_clean();
			$writer->save('php://output');
			exit;
		}catch(\Exception $e) {
		    print_r($e);
		}
	}
	/*
	*cetak ulang
	*/
	function ajax_cetak_ulang(){
		/*
		$_POST['dari'] = '01/01/2019';
		$_POST['sampai'] = '31/12/2019';
		/*
		//select book_title from book where published_date between '2019-01-01' and '2019-12-31' and (book_edition='' or book_edition='1' or book_edition='Pertama') order by published_date asc
		*/
		$tgl_daris = explode("/", $this->input->post('dari'));
		$tgl_dari = $tgl_daris[2].'-'.$tgl_daris[1].'-'.$tgl_daris[0];
		$tgl_sampais = explode("/", $this->input->post('sampai'));
		$tgl_sampai = $tgl_sampais[2].'-'.$tgl_sampais[1].'-'.$tgl_sampais[0];
		$this->db->select("book_id, draft_id, book_title");
		$this->db->from("book");
		$this->db->where("published_date >=", $tgl_dari);
		$this->db->where("published_date <=", $tgl_sampai);
		$this->db->where("book_edition<>'Pertama'");
		$this->db->where("book_edition<>'1'");
		$this->db->where("book_edition<>''");
		$query = $this->db->get();
		if($query->num_rows()==0){
			echo '{
					"sEcho": 1,
					"iTotalRecords": "0",
					"iTotalDisplayRecords": "0",
					"aaData": []
			}';
		}else{
			$no = 1;
			foreach($query->result() as $row){
				$q_pen_ugm = $this->get_penulis($row->draft_id, "1");
				$penulis_ugm = "";
				foreach($q_pen_ugm->result() as $r_penulis){
					if($penulis_ugm==""){
						$penulis_ugm = "<ul><li>".$r_penulis->author_name."</li>";
					}else{
						$penulis_ugm .= "<li>".$r_penulis->author_name."</li>";
					}
				}
				if($penulis_ugm!=""){
					$penulis_ugm .= "</ul>";
				}
				$q_pen_non_ugm = $this->get_penulis($row->draft_id, "2");
				$penulis_non_ugm = "";
				foreach($q_pen_non_ugm->result() as $r_penulis){
					if($penulis_non_ugm==""){
						$penulis_non_ugm = "<ul><li>".$r_penulis->author_name."</li>";
					}else{
						$penulis_non_ugm .= "<li>".$r_penulis->author_name."</li>";
					}
				}
				if($penulis_non_ugm!=""){
					$penulis_non_ugm .= "</ul>";
				}
				$data['aaData'][] = array('no' => $no, 'judul' => $row->book_title,
										'penulis_ugm' => $penulis_ugm,
										'penulis_non_ugm' => $penulis_non_ugm,
									);
				$no++;
			}
			echo json_encode($data);
		}

	}

	function export_cetak_ulang(){
		$tgl_daris = explode("/", $this->input->post('dari'));
		$tgl_dari = $tgl_daris[2].'-'.$tgl_daris[1].'-'.$tgl_daris[0];
		$tgl_sampais = explode("/", $this->input->post('sampai'));
		$tgl_sampai = $tgl_sampais[2].'-'.$tgl_sampais[1].'-'.$tgl_sampais[0];
		$this->db->select("book_id, draft_id, book_title, book_edition");
		$this->db->from("book");
		$this->db->where("published_date >=", $tgl_dari);
		$this->db->where("published_date <=", $tgl_sampai);
		$this->db->where("book_edition<>'Pertama'");
		$this->db->where("book_edition<>'1'");
		$this->db->where("book_edition<>''");
		$query = $this->db->get();
		try{
			// Create new Spreadsheet object
			$spreadsheet = new Spreadsheet();

			// Set document properties
			$spreadsheet->getProperties()->setCreator('SIGAP')
			->setLastModifiedBy('SIGAP')
			->setTitle('laporan cetak ulang')
			->setSubject('laporan cetak ulang')
			->setDescription('laporan cetak ulang SIGAP')
			->setKeywords('office 2007 openxml php')
			->setCategory('Report generated');

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'LAPORAN CETAK ULANG');
			$spreadsheet->getActiveSheet()->mergeCells('A1:E1');
			$spreadsheet->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal('center');
			$spreadsheet->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);

			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A2', 'periode '.$this->input->post('dari').' s/d '.$this->input->post('sampai'));
			$spreadsheet->getActiveSheet()->mergeCells('A2:E2');
			$spreadsheet->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
			$spreadsheet->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);


			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A4', 'NO')
			->setCellValue('B4', 'JUDUL BUKU')
			->setCellValue('C4', 'EDISI')
			->setCellValue('D4', 'PENULIS UGM')
			->setCellValue('E4', 'PENULIS NON UGM');
			$spreadsheet->getActiveSheet()->getStyle('A4:E4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('B3B3B3');
			$spreadsheet->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal('center');
			//->setCellValue('L1', 'OBAT LAMA');
			// Miscellaneous glyphs, UTF-8
			$i=5; 
			$no = 1;
			foreach($query->result() as $row) {
				$q_pen_ugm = $this->get_penulis($row->draft_id, "1");
				$penulis_ugm = "";
				foreach($q_pen_ugm->result() as $r_penulis){
					if($penulis_ugm==""){
						$penulis_ugm = $r_penulis->author_name;
					}else{
						$penulis_ugm .= ", ".$r_penulis->author_name;
					}
				}
				$q_pen_non_ugm = $this->get_penulis($row->draft_id, "2");
				$penulis_non_ugm = "";
				foreach($q_pen_non_ugm->result() as $r_penulis){
					if($penulis_non_ugm==""){
						$penulis_non_ugm = $r_penulis->author_name;
					}else{
						$penulis_non_ugm .= ", ".$r_penulis->author_name;
					}
				}

				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $no)
				->setCellValue('B'.$i, $row->book_title)
				->setCellValue('C'.$i, $row->book_edition)
				->setCellValue('D'.$i, $penulis_ugm)
				->setCellValue('E'.$i, $penulis_non_ugm);

				$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$i++;
				$no++;
			}
			$styleArray = [
			    'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '000'],
			        ],
			    ],
			];
			$spreadsheet->getActiveSheet()->getStyle('A4:E'.($i-1))->applyFromArray($styleArray);

			// Rename worksheet
			$spreadsheet->getActiveSheet()->setTitle('cetak ulang');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$spreadsheet->setActiveSheetIndex(0);

			// Redirect output to a client’s web browser (Xlsx)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="laporan_cetak_ulang_sigap.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			ob_end_clean();
			$writer->save('php://output');
			exit;
		}catch(\Exception $e) {
		    print_r($e);
		}
	}

}

/* End of file Reporting.php */
/* Location: ./application/controllers/Reporting.php */
