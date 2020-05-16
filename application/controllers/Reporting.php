<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reporting extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'reporting';
    }

    /*Controller for fetching data to the table*/

    /* Fungsi untuk menampilkan halaman summary */
    public function index()
    {
        echo 'under construction';
        return;
        $summaries = $this->reporting->fetch_data();

        $pages     = $this->pages;
        $main_view = 'report/summary';

        $this->load->view('template', compact('main_view', 'pages', 'summaries'));
    }
    /* Fungsi untuk menampilkan halaman summary baru */
    public function index_baru()
    {
        $new = $this->reporting->fetch_data_baru();

        $pages     = $this->pages;
        $main_view = 'report/naskahbaru';

        $this->load->view('template', compact('main_view', 'pages', 'new'));
    }
    /* Fungsi untuk menampilkan halaman summary ulang */
    public function index_ulang()
    {
        $reprint = $this->reporting->fetch_data_ulang();

        $pages     = $this->pages;
        $main_view = 'report/cetakulang';

        $this->load->view('template', compact('main_view', 'pages', 'reprint'));
    }
    /* Fungsi untuk menampilkan halaman draft */
    public function index_draft()
    {
        $drafts = $this->reporting->fetch_data_draft();

        $pages     = $this->pages;
        $main_view = 'report/report_draft';

        $this->load->view('template', compact('main_view', 'pages', 'drafts'));
    }
    /* Fungsi untuk menampilkan halaman buku */
    public function index_books()
    {
        $books = $this->reporting->fetch_data_book();

        $pages     = $this->pages;
        $main_view = 'report/report_book';

        $this->load->view('template', compact('main_view', 'pages', 'books'));
    }
    /* Fungsi untuk menampilkan halaman penulis */
    public function index_author()
    {
        $author = $this->reporting->fetch_data_author();

        $pages     = $this->pages;
        $main_view = 'report/report_author';

        $this->load->view('template', compact('main_view', 'pages', 'author'));
    }
    /* Fungsi untuk menampilkan halaman hibah*/
    public function index_hibah()
    {
        $hibah = $this->reporting->fetch_data_hibah();

        $pages     = $this->pages;
        $main_view = 'report/report_hibah';

        $this->load->view('template', compact('main_view', 'pages', 'hibah'));
    }
    /* Fungsi untuk menampilkan halaman performa editor */

    /* Fungsi untuk menampilkan grafik summary */
    public function getSummary()
    {
        $count_review       = 0;
        $count_disetujui    = 0;
        $count_antri_editor = 0;
        $count_editor       = 0;
        $count_layout       = 0;
        $count_proofread    = 0;
        $count_print        = 0;
        $count_final        = 0;
        $year               = $this->input->get('droptahunsummary');

        $result_review = $this->reporting->select(['draft_status'])->getSummary($year);
        foreach ($result_review as $hasil_review) {
            if ($hasil_review->draft_status == 4) {
                $count_review++;
            }
            if ($hasil_review->draft_status == 5) {
                $count_antri_editor++;
            }
        }
        $result['count_review']       = $count_review;
        $result['count_antri_editor'] = $count_antri_editor;

        $result_disetujui = $this->reporting->select(['is_review'])->getSummary($year);
        foreach ($result_disetujui as $hasil_disetujui) {
            if ($hasil_disetujui->is_review == 'y') {
                $count_disetujui++;
            }
        }
        $result['count_disetujui'] = $count_disetujui;

        $result_editor = $this->reporting->select(['is_review', 'is_edit', 'is_layout', 'is_proofread', 'is_print'])->getSummary($year);
        foreach ($result_editor as $hasil_editor) {
            if ($hasil_editor->draft_status == 6 and $hasil_editor->is_edit == 'n') {
                $count_editor++;
            }
            if ($hasil_editor->is_edit == 'y' and $hasil_editor->is_layout == 'n') {
                $count_layout++;
            }
            if ($hasil_editor->is_layout == 'y' and $hasil_editor->is_proofread == 'n') {
                $count_proofread++;
            }
            if ($hasil_editor->is_proofread == 'y' and $hasil_editor->is_print == 'n') {
                $count_print++;
            }
            if ($hasil_editor->is_print == 'y') {
                $count_final++;
            }
        }
        $result['count_editor']    = $count_editor;
        $result['count_layout']    = $count_layout;
        $result['count_proofread'] = $count_proofread;
        $result['count_print']     = $count_print;
        $result['count_final']     = $count_final;
        echo json_encode($result);
    }

    public function getSummaryBaru()
    {
        $count_review_baru       = 0;
        $count_disetujui_baru    = 0;
        $count_antri_editor_baru = 0;
        $count_editor_baru       = 0;
        $count_layout_baru       = 0;
        $count_proofread_baru    = 0;
        $count_print_baru        = 0;
        $count_final_baru        = 0;
        $year                    = $this->input->get('droptahunsummary');

        $result_review = $this->reporting->select(['draft_status', 'is_reprint'])->getSummaryBaru($year);
        foreach ($result_review as $hasil_review) {
            if ($hasil_review->draft_status == 4 and $hasil_review->is_reprint == 'n') {
                $count_review_baru++;
            }
            if ($hasil_review->draft_status == 5 and $hasil_review->is_reprint == 'n') {
                $count_antri_editor_baru++;
            }
        }
        $result['count_review_baru']       = $count_review_baru;
        $result['count_antri_editor_baru'] = $count_antri_editor_baru;

        $result_disetujui = $this->reporting->select(['is_review', 'is_reprint'])->getSummaryBaru($year);
        foreach ($result_disetujui as $hasil_disetujui) {
            if ($hasil_disetujui->is_review == 'y' and $hasil_disetujui->is_reprint == 'n') {
                $count_disetujui_baru++;
            }
        }
        $result['count_disetujui_baru'] = $count_disetujui_baru;

        $result_editor = $this->reporting->select(['is_review', 'is_edit', 'is_layout', 'is_proofread', 'is_print', 'is_reprint', 'draft_status'])->getSummaryBaru($year);
        foreach ($result_editor as $hasil_editor) {
            if (($hasil_editor->draft_status == 6) and $hasil_editor->is_reprint == 'n') {
                $count_editor_baru++;
            }
            if (($hasil_editor->is_edit == 'y' and $hasil_editor->is_layout == 'n') and $hasil_editor->is_reprint == 'n') {
                $count_layout_baru++;
            }
            if (($hasil_editor->is_layout == 'y' and $hasil_editor->is_proofread == 'n') and $hasil_editor->is_reprint == 'n') {
                $count_proofread_baru++;
            }
            if (($hasil_editor->is_proofread == 'y' and $hasil_editor->is_print == 'n') and $hasil_editor->is_reprint == 'n') {
                $count_print_baru++;
            }
            if (($hasil_editor->is_print == 'y') and $hasil_editor->is_reprint == 'n') {
                $count_final_baru++;
            }
        }
        $result['count_editor_baru']    = $count_editor_baru;
        $result['count_layout_baru']    = $count_layout_baru;
        $result['count_proofread_baru'] = $count_proofread_baru;
        $result['count_print_baru']     = $count_print_baru;
        $result['count_final_baru']     = $count_final_baru;
        echo json_encode($result);
    }

    public function getSummaryUlang()
    {
        $count_review_ulang       = 0;
        $count_disetujui_ulang    = 0;
        $count_antri_editor_ulang = 0;
        $count_editor_ulang       = 0;
        $count_layout_ulang       = 0;
        $count_proofread_ulang    = 0;
        $count_print_ulang        = 0;
        $count_final_ulang        = 0;
        $year                     = $this->input->get('droptahunsummary');

        $result_review = $this->reporting->select(['draft_status', 'is_reprint'])->getSummaryUlang($year);
        foreach ($result_review as $hasil_review) {
            if ($hasil_review->draft_status == 4 and $hasil_review->is_reprint == 'y') {
                $count_review_ulang++;
            }
            if ($hasil_review->draft_status == 5 and $hasil_review->is_reprint == 'y') {
                $count_antri_editor_ulang++;
            }
        }
        $result['count_review_ulang']       = $count_review_ulang;
        $result['count_antri_editor_ulang'] = $count_antri_editor_ulang;

        $result_disetujui = $this->reporting->select(['is_review', 'is_reprint'])->getSummaryUlang($year);
        foreach ($result_disetujui as $hasil_disetujui) {
            if ($hasil_disetujui->is_review == 'y' and $hasil_disetujui->is_reprint == 'y') {
                $count_disetujui_ulang++;
            }
        }
        $result['count_disetujui_ulang'] = $count_disetujui_ulang;

        $result_editor = $this->reporting->select(['is_review', 'is_edit', 'is_layout', 'is_proofread', 'is_print', 'is_reprint'])->getSummaryUlang($year);
        foreach ($result_editor as $hasil_editor) {
            if (($hasil_editor->draft_status == 6) and $hasil_editor->is_reprint == 'y') {
                $count_editor_ulang++;
            }
            if (($hasil_editor->is_edit == 'y' and $hasil_editor->is_layout == 'n') and $hasil_editor->is_reprint == 'y') {
                $count_layout_ulang++;
            }
            if (($hasil_editor->is_layout == 'y' and $hasil_editor->is_proofread == 'n') and $hasil_editor->is_reprint == 'y') {
                $count_proofread_ulang++;
            }
            if (($hasil_editor->is_proofread == 'y' and $hasil_editor->is_print == 'n') and $hasil_editor->is_reprint == 'y') {
                $count_print_ulang++;
            }
            if (($hasil_editor->is_print == 'y') and $hasil_editor->is_reprint == 'y') {
                $count_final_ulang++;
            }
        }
        $result['count_editor_ulang']    = $count_editor_ulang;
        $result['count_layout_ulang']    = $count_layout_ulang;
        $result['count_proofread_ulang'] = $count_proofread_ulang;
        $result['count_print_ulang']     = $count_print_ulang;
        $result['count_final_ulang']     = $count_final_ulang;
        echo json_encode($result);
    }

    /* Fungsi untuk menampilkan grafik penulis berdasarkan instansi */
    public function getPie()
    {
        $count_ugm  = 0;
        $count_lain = 0;

        $result_ugm = $this->reporting->select(['institute_id'])->get_all('author');
        foreach ($result_ugm as $institute_ugm) {
            if ($institute_ugm->institute_id == 1) {
                $count_ugm++;
            } else {
                $count_lain++;
            }
        }
        $result['count_ugm']  = $count_ugm;
        $result['count_lain'] = $count_lain;
        echo json_encode($result);
    }

    /* Fungsi untuk menampilkan grafik penulis berdasarkan gelar */
    public function getPieAuthorGelar()
    {
        $count_prof    = 0;
        $count_doctor  = 0;
        $count_lainnya = 0;

        $result_gelar = $this->reporting->select(['author_latest_education'])->get_all('author');
        foreach ($result_gelar as $gelar_ugm) {
            if ($gelar_ugm->author_latest_education == 's4') {
                $count_prof++;
            } elseif ($gelar_ugm->author_latest_education == 's3') {
                $count_doctor++;
            } else {
                $count_lainnya++;
            }
        }
        $result['count_prof']    = $count_prof;
        $result['count_doctor']  = $count_doctor;
        $result['count_lainnya'] = $count_lainnya;
        echo json_encode($result);
    }

    /* Fungsi untuk menampilkan grafik hibah */
    public function getPieHibah()
    {
        $count_hibah       = 0;
        $count_reguler     = 0;
        $count_cetak_ulang = 0;
        $year              = $this->input->get('droptahunhibah');

        $result_ugm = $this->reporting->select(['category_type', 'is_reprint'])->join_table('category', 'draft', 'category')->where('YEAR(entry_date)', $year)->get_all('draft');
        foreach ($result_ugm as $category_ugm) {
            if ($category_ugm->category_type == 1 and $category_ugm->is_reprint == 'n') {
                $count_hibah++;
            }
            if ($category_ugm->category_type == 2 and $category_ugm->is_reprint == 'n') {
                $count_reguler++;
            }
            if ($category_ugm->category_type == 3) {
                $count_cetak_ulang++;
            }
            if (($category_ugm->category_type == 1 or $category_ugm->category_type == 2) and $category_ugm->is_reprint == 'y') {
                $count_cetak_ulang++;
            }
        }
        $result['count_hibah']       = $count_hibah;
        $result['count_reguler']     = $count_reguler;
        $result['count_cetak_ulang'] = $count_cetak_ulang;
        echo json_encode($result);
    }

    /* Fungsi untuk menambah data pada grafik draft*/
    public function getDraft()
    {
        $year = $this->input->get('droptahun');
        for ($i = 1; $i <= 12; $i++) {
            $result[$i]          = $this->reporting->getDraft($i, $year);
            $result['count'][$i] = count($result[$i]);
        }
        echo json_encode($result);
    }

    /* Fungsi untuk menambah data pada grafik buku*/
    public function getBook()
    {
        $year = $this->input->get('droptahunbuku');
        for ($i = 1; $i <= 12; $i++) {
            $result[$i]          = $this->reporting->getBook($i, $year);
            $result['count'][$i] = count($result[$i]);
        }
        echo json_encode($result);
    }

    /* Fungsi untuk menambah data pada grafik penulis*/
    public function getAuthor()
    {
        for ($i = 1; $i <= 3; $i++) {
            $result[$i]          = $this->reporting->getAuthor($i);
            $result['count'][$i] = count($result[$i]);
        }
        echo json_encode($result);
    }

    /* Fungsi filter data pada grafik summary*/
    public function getYearsSummary()
    {
        $filtertahun = $this->reporting->group_by('YEAR(entry_date)')->get_all_array('draft');
        foreach ($filtertahun as $key => $value) {
            $tahun[$key] = date('Y', strtotime($value['entry_date']));
        }
        echo json_encode($tahun);
    }

    /* Fungsi filter data pada grafik summary cetak ulang*/
    public function getYearsSummaryUlang()
    {
        $filtertahun = $this->reporting->group_by('YEAR(entry_date)')->get_all_array('draft');
        foreach ($filtertahun as $key => $value) {
            $tahun[$key] = date('Y', strtotime($value['entry_date']));
        }
        echo json_encode($tahun);
    }

    /* Fungsi filter data pada grafik draft*/
    public function getYears()
    {
        $filtertahun = $this->reporting->group_by('YEAR(entry_date)')->get_all_array('draft');
        foreach ($filtertahun as $key => $value) {
            $tahun[$key] = date('Y', strtotime($value['entry_date']));
        }
        echo json_encode($tahun);
    }

    /* Fungsi filter data pada grafik buku*/
    public function getYearsBook()
    {
        $filtertahun = $this->reporting->group_by('YEAR(published_date)')->get_all_array('book');
        foreach ($filtertahun as $key => $value) {
            $tahun[$key] = date('Y', strtotime($value['published_date']));
        }
        echo json_encode($tahun);
    }

    /* Fungsi filter data pada grafik hibah*/
    public function getYearsHibah()
    {
        $filtertahun = $this->reporting->group_by('YEAR(entry_date)')->get_all_array('draft');
        foreach ($filtertahun as $key => $value) {
            $tahun[$key] = date('Y', strtotime($value['entry_date']));
        }
        echo json_encode($tahun);
    }
}

/* End of file Reporting.php */
/* Location: ./application/controllers/Reporting.php */
