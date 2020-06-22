<?php defined('BASEPATH') or exit('No direct script access allowed');

class Printing extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'printing';
        $this->load->model('printing/Printing_model');
    }

    public function index(){
        // if($this->check_level() == TRUE):

        // $filters = [
        //     'status'    => $this->input->get('status', true),//0-6 > belum,preprint,print,binding,final,tolak,selesai
        //     'category'  => $this->input->get('category', true),//0-1 > cetak baru, cetak ulang
        //     'type'      => $this->input->get('type', true),//0-1 > POD, Offset
        //     'priority'  => $this->input->get('priority', true),//0-2 > rendah, sedang, tinggi
        //     'keyword'   => $this->input->get('keyword', true),//cari berdasarkan semua kolom
        // ];

        // $get_data   = $this->Printing_model->filter_printing($filters, $page);
        
        // $pages      = $this->pages;
        // $main_view  = 'printing/index_printing';
        // $data       = $get_data['printing'];
        // $pagination = $this->draft->make_pagination(site_url('printing'), 2, $total);
        // $total      = $get_data['printing'];
        // $this->load->view('template', compact('pages', 'main_view', 'data', 'pagination', 'total'));

        // endif;
    }

    public function view_printing_add(){
        if($this->check_level() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'printing/printing_add';
        $this->load->view('template', compact('pages', 'main_view'));
        endif;
    }

    public function view_printing_edit($print_id){
        if($this->check_level_admin() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'printing/printing_edit';
        $pData       = $this->Printing_model->fetch_print_id($print_id);
        if(empty($pData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'pData'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function view_printing_view($print_id){
        if($this->check_level() == TRUE):
        $pages       = $this->pages;
        $main_view   = 'printing/printing_view';
        $pData       = $this->Printing_model->fetch_print_id($print_id);
        if(empty($pData) == FALSE):
        $this->load->view('template', compact('pages', 'main_view', 'pData'));
        else:
        $this->session->set_flashdata('error','Halaman tidak ditemukan.');
        redirect(base_url(), 'refresh');
        endif;
        endif;
    }

    public function add_printing(){
        if($this->check_level() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('book_id', 'Judul buku', 'required|max_length[10]');
        $this->form_validation->set_rules('print_type', 'Tipe cetak', 'required|max_length[1]');
        $this->form_validation->set_rules('print_total', 'Jumlah cetak', 'required|max_length[5]');
        $this->form_validation->set_rules('print_category', 'Kategori cetak', 'required|max_length[1]');
        $this->form_validation->set_rules('print_edition', 'Edisi cetak', 'required|max_length[100]');
        $this->form_validation->set_rules('paper_content', 'Kertas isi', 'required|max_length[100]');
        $this->form_validation->set_rules('paper_cover', 'Kertas cover', 'required|max_length[100]');
        $this->form_validation->set_rules('paper_size', 'Ukuran kertas', 'required|max_length[100]');
        $this->form_validation->set_rules('print_priority', 'Prioritas cetak', 'required|max_length[1]');
        $this->form_validation->set_rules('order_number', 'Nomor order', 'required|max_length[15]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check_add  =   $this->Printing_model->add_printing();
            if($check_add   ==  TRUE){
                $this->session->set_flashdata('success','Order cetak berhasil dibuat.');
                redirect('printing');
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function edit_printing($print_id){
        if($this->check_level_admin() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('book_id', 'Judul buku', 'max_length[10]');
        $this->form_validation->set_rules('print_type', 'Tipe cetak', 'max_length[1]');
        $this->form_validation->set_rules('print_total', 'Jumlah cetak', 'max_length[5]');
        $this->form_validation->set_rules('print_category', 'Kategori cetak', 'max_length[1]');
        $this->form_validation->set_rules('print_edition', 'Edisi cetak', 'max_length[100]');
        $this->form_validation->set_rules('paper_content', 'Kertas isi', 'max_length[100]');
        $this->form_validation->set_rules('paper_cover', 'Kertas cover', 'max_length[100]');
        $this->form_validation->set_rules('paper_size', 'Ukuran kertas', 'max_length[100]');
        $this->form_validation->set_rules('print_priority', 'Prioritas cetak', 'max_length[1]');
        $this->form_validation->set_rules('order_number', 'Nomor order', 'max_length[15]');
        $this->form_validation->set_rules('entry_date', 'Tanggal input', '');
        $this->form_validation->set_rules('finish_date', 'Tanggal selesai', '');
        $this->form_validation->set_rules('preprint_status', 'Status pracetak', 'max_length[1]');
        $this->form_validation->set_rules('preprint_start_date', 'Tanggal Mulai Pracetak', '');
        $this->form_validation->set_rules('preprint_end_date', 'Tanggal Selesai Pracetak', '');
        $this->form_validation->set_rules('print_status', 'Status cetak', 'max_length[1]');
        $this->form_validation->set_rules('print_start_date', 'Tanggal Mulai Cetak', '');
        $this->form_validation->set_rules('print_end_date', 'Tanggal Selesai Cetak', '');
        $this->form_validation->set_rules('binding_status', 'Status jilid', 'max_length[1]');
        $this->form_validation->set_rules('binding_start_date', 'Tanggal Mulai Jilid', '');
        $this->form_validation->set_rules('binding_end_date', 'Tanggal Selesai Jilid', '');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }else{
            $check_edit  =   $this->Printing_model->edit_printing($print_id);
            if($check_edit   ==  TRUE){
                $this->session->set_flashdata('success','Order cetak berhasil diubah.');
                redirect('printing/view_printing_view/'.$print_id);
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'], 'refresh');
            }
        }
        endif;
    }

    public function delete_printing($print_id){
        if($this->check_level_admin() == TRUE):
        $isDeleted  = $this->Printing_model->delete_printing($print_id);
        if($isDeleted   ==  TRUE){
            $this->session->set_flashdata('success','Order printing berhasil di hapus.');
            redirect('Printing');
        }else{
            $this->session->set_flashdata('error',print_r($this->db->error()));
            redirect('Printing');
        }
        endif;
    }

    public function ac_book_id(){
        $postData   =   $this->input->post();
        $data       =   $this->Printing_model->fetch_book_id($postData);

        echo json_encode($data);
    }

    public function ac_draft_id(){
        $postData   =   $this->input->post();
        $data       =   $this->Printing_model->fetch_draft_id($postData);

        echo json_encode($data);
    }

    public function start_progress($print_id,$progress_name){
        if($this->check_level() == TRUE):
        $check  = $this->Printing_model->start_progress($print_id,$progress_name);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil memulai progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh');
        }else{
            $this->session->set_flashdata('error','Gagal memulai progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }
        endif;
    }

    public function stop_progress($print_id,$progress_name){
        if($this->check_level() == TRUE):
        $check  = $this->Printing_model->stop_progress($print_id,$progress_name);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil memberhentikan progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh');  
        }else{
            $this->session->set_flashdata('error','Gagal memberhentikan progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }
        endif;
    }

    public function set_deadline($print_id,$progress_name){
        if($this->check_level() == TRUE):
        $check  = $this->Printing_model->set_deadline($print_id,$progress_name);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menentukan deadline progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }else{
            $this->session->set_flashdata('error','Gagal menentukan deadline progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }
        endif;
    }

    public function add_notes($print_id,$progress_name){
        if($this->check_level() == TRUE):
        $check  = $this->Printing_model->add_notes($print_id,$progress_name);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil menambahkan catatan pada progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }else{
            $this->session->set_flashdata('error','Gagal menambahkan catatan pada progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }
        endif;
    }

    public function choose_action($print_id,$progress_name){
        if($this->check_level() == TRUE):
        $check  = $this->Printing_model->choose_action($print_id,$progress_name);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil melakukan aksi pada progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }else{
            $this->session->set_flashdata('error','Gagal melakukan aksi pada progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }
        endif;
    }

    public function set_book($print_id,$progress_name){
        if($this->check_level() == TRUE):
        $check =   $this->Printing_model->set_book($print_id);
        if($check   ==  TRUE){
            $this->session->set_flashdata('success','Berhasil memilih buku pada progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }else{
            $this->session->set_flashdata('error','Gagal memilih buku pada progress '.$progress_name.'.');
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }
        endif;
    }

    public function to_new_book($print_id,$progress_name){
        if($this->check_level() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('draft_id', 'Judul draft', 'required|max_length[9]');
        $this->form_validation->set_rules('book_code', 'Kode buku', 'max_length[5]');
        $this->form_validation->set_rules('book_title', 'Judul buku', 'required|max_length[256]');
        $this->form_validation->set_rules('book_edition', 'Edisi buku', 'max_length[25]');
        $this->form_validation->set_rules('book_pages', 'Jumlah halaman', 'max_length[25]');
        $this->form_validation->set_rules('isbn', 'ISBN', 'max_length[25]');
        $this->form_validation->set_rules('eisbn', 'eISBN', 'max_length[25]');
        $this->form_validation->set_rules('published_date', 'Tanggal terbit', '');
        $this->form_validation->set_rules('harga', 'Harga', 'max_length[11]');
        $this->form_validation->set_rules('book_file_link', 'Link file buku', 'max_length[256]');
        $this->form_validation->set_rules('book_notes', 'Keterangan buku', 'max_length[1024]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
        }else{
            $config['upload_path']      = './bookfile/';
            $config['allowed_types']    = '*';
            $config['max_size']         = 51200;
            $config['overwrite']        = true;
            $this->load->library('upload',$config);

            if ($this->upload->do_upload('book_file')) {
                $book_file  =   $this->upload->data("file_name");
            }else{
                $this->session->set_flashdata('error',$this->upload->display_errors());
                redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
            }

            $check_add  =   $this->Printing_model->to_new_book($print_id,$book_file);

            if($check_add   ==  TRUE){
                $this->session->set_flashdata('success','Berhasil mengubah buku.');
                redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh');
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'].'#section_'.$progress_name, 'refresh'); 
            }
        }
        endif;
    }

    public function finalisasi_printing($print_id){
        if($this->check_level() == TRUE):
        $this->load->library('form_validation');
        $this->form_validation->set_rules('stock_in_warehouse', 'Stok dalam gudang', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_out_warehouse', 'Stok luar gudang', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_marketing', 'Stok pemasaran', 'required|max_length[10]');
        $this->form_validation->set_rules('stock_input_notes', 'Catatan', 'required|max_length[256]');

        if($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('error',validation_errors());
            redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
        }else{
            $check  =   $this->Printing_model->finalisasi_printing($print_id);
            if($check   ==  TRUE){
                $this->session->set_flashdata('success','Order cetak telah difinalisasi.');
                redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
            }else{
                $this->session->set_flashdata('error',print_r($this->db->error()));
                redirect($_SERVER['HTTP_REFERER'].'#section_final', 'refresh');
            }
        }
        endif;
    }

    public function check_level(){
        if($_SESSION['level'] == 'superadmin' || $_SESSION['level'] == 'admin_percetakan'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya admin percetakan dan superadmin yang dapat mengakses.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
    }

    public function check_level_admin(){
        if($_SESSION['level'] == 'superadmin'){
            return TRUE;
        }else{
            $this->session->set_flashdata('error','Hanya superadmin yang dapat mengakses.');
            redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }
    }
}
