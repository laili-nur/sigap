<?php defined('BASEPATH') or exit('No direct script access allowed');
class Notifikasi extends Operator_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->pages = 'notifikasi';
    }

    public function belum_dibaca($page = null)
    {
        $user_id_notif = $this->session->userdata('user_id');
        $q_notifikasi = $this->db->query("select * from notifikasi where is_read='0' and user_id='$user_id_notif'");

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi belum dibaca';
        $main_view = 'notifikasi/belum_dibaca';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi/belum_dibaca'), 3, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }

    public function ditandai($page = null)
    {
        $user_id_notif = $this->session->userdata('user_id');
        $q_notifikasi = $this->db->query("select * from notifikasi where is_mark='1' and user_id='$user_id_notif'");

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi ditandai';
        $main_view = 'notifikasi/ditandai';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi'), 2, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }

    public function semua($page = null)
    {
        $user_id_notif = $this->session->userdata('user_id');
        $q_notifikasi = $this->db->query("select * from notifikasi where user_id='$user_id_notif'");

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi semua';
        $main_view = 'notifikasi/semua';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi/semua'), 3, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }

    public function tandai_hapus($id = null, $destination)
    {
        if($this->db->update("notifikasi", array('is_mark' => '0'), "id='$id'")){
            $this->session->set_flashdata('success', 'berhasil menghapus tanda notifikasi');
        } else {
            $this->session->set_flashdata('error', 'gagal menghapus tanda notifikasi');
        }
        redirect('notifikasi/'.$destination);
    }
    public function tandai($id = null, $destination)
    {
        if($this->db->update("notifikasi", array('is_mark' => '1'), "id='$id'")){
            $this->session->set_flashdata('success', 'berhasil menandai notifikasi');
        } else {
            $this->session->set_flashdata('error', 'gagal menandai notifikasi');
        }
        redirect('notifikasi/'.$destination);
    }

    public function searchs_belum_dibaca($page = null)
    {
        $keywords = $this->input->get('keywords', true);
        $user_id_notif = $this->session->userdata('user_id');
        $q_notifikasi = $this->db->query("select * from notifikasi where user_id='$user_id_notif' and is_read='0' and (judul like '%$keywords%' or isi like '%$keywords%')");

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi belum dibaca';
        $main_view = 'notifikasi/belum_dibaca';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi/belum_dibaca'), 3, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }
    public function searchs_ditandai($page = null)
    {
        $keywords = $this->input->get('keywords', true);
        $user_id_notif = $this->session->userdata('user_id');
        $q_notifikasi = $this->db->query("select * from notifikasi where user_id='$user_id_notif' and is_mark='1' and (judul like '%$keywords%' or isi like '%$keywords%')");

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi ditandai';
        $main_view = 'notifikasi/ditandai';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi/ditandai'), 3, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }
    public function searchs_semua($page = null)
    {
        $keywords = $this->input->get('keywords', true);
        $user_id_notif = $this->session->userdata('user_id');
        $q_notifikasi = $this->db->query("select * from notifikasi where user_id='$user_id_notif' and (judul like '%$keywords%' or isi like '%$keywords%')");

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi semua';
        $main_view = 'notifikasi/semua';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi/semua'), 3, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }

    public function deadline($page = null)
    {
        $user_id_notif = $this->session->userdata('user_id');
        $ceklevel = $this->session->userdata('level');

        if($ceklevel=='editor'){
            $q_notifikasi = $this->db->query("select d.draft_id, draft_title, datediff(edit_deadline, now()) remaining, edit_deadline deadline from draft d join responsibility r on d.draft_id=r.draft_id where user_id='$user_id_notif' and datediff(edit_deadline, now())<=7 and edit_end_date='0000-00-00 00:00:00'");
        }else if($ceklevel=='layouter'){
            $q_notifikasi = $this->db->query("select d.draft_id, draft_title, datediff(layout_deadline, now()) remaining, layout_deadline deadline, datediff(cover_deadline, now()) remaining2, cover_deadline deadline2 from draft d join responsibility r on d.draft_id=r.draft_id where user_id='$user_id_notif' and ((datediff(layout_deadline, now())<=7 and layout_end_date='0000-00-00 00:00:00') or (datediff(cover_deadline, now())<=7 and cover_end_date='0000-00-00 00:00:00'))");
        }else if($ceklevel=='reviewer'){
            $q_notifikasi = $this->db->query("select d.draft_id, draft_title, datediff(review1_deadline, now()) remaining, review1_deadline deadline, datediff(review2_deadline, now()) remaining2, review2_deadline deadline2 from draft d join draft_reviewer r on d.draft_id=r.draft_id join reviewer e on r.reviewer_id=e.reviewer_id where user_id='$user_id_notif' and ((datediff(review1_deadline, now())<=7 or datediff(review2_deadline, now())<=7)) and review_end_date='0000-00-00 00:00:00'");
        }

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi deadline';
        $main_view = 'notifikasi/deadline';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi/deadline'), 3, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }

    public function searchs_deadline($page = null)
    {
        $keywords = $this->input->get('keywords', true);
        $user_id_notif = $this->session->userdata('user_id');
        $ceklevel = $this->session->userdata('level');

        if($ceklevel=='editor'){
            $q_notifikasi = $this->db->query("select d.draft_id, draft_title, datediff(edit_deadline, now()) remaining, edit_deadline deadline from draft d join responsibility r on d.draft_id=r.draft_id where user_id='$user_id_notif' and datediff(edit_deadline, now())<=7 and edit_end_date='0000-00-00 00:00:00' and draft_title like '%$keywords%'");
        }else if($ceklevel=='layouter'){
            $q_notifikasi = $this->db->query("select d.draft_id, draft_title, datediff(layout_deadline, now()) remaining, layout_deadline deadline, datediff(cover_deadline, now()) remaining2, cover_deadline deadline2 from draft d join responsibility r on d.draft_id=r.draft_id where user_id='$user_id_notif' and ((datediff(layout_deadline, now())<=7 and layout_end_date='0000-00-00 00:00:00') or (datediff(cover_deadline, now())<=7 and cover_end_date='0000-00-00 00:00:00')) and draft_title like '%$keywords%'");
        }else if($ceklevel=='reviewer'){
            $q_notifikasi = $this->db->query("select d.draft_id, draft_title, datediff(review1_deadline, now()) remaining, review1_deadline deadline, datediff(review2_deadline, now()) remaining2, review2_deadline deadline2 from draft d join draft_reviewer r on d.draft_id=r.draft_id join reviewer e on r.reviewer_id=e.reviewer_id where user_id='$user_id_notif' and ((datediff(review1_deadline, now())<=7 or datediff(review2_deadline, now())<=7)) and review_end_date='0000-00-00 00:00:00' and draft_title like '%$keywords%'");
        }
        //echo $this->db->last_query();

        $total = $q_notifikasi->num_rows();
        $notifikasi = $q_notifikasi->result();
        $pages = 'notifikasi deadline';
        $main_view = 'notifikasi/deadline';
        $pagination = $this->notifikasi->makePagination(site_url('notifikasi/deadline'), 3, $total);
        $this->load->view('template', compact('pages', 'main_view', 'notifikasi', 'pagination', 'total'));
    }
}
