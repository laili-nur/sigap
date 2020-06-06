<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Responsibility extends Operator_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->pages = 'responsibility';
        $this->load->library('jagolibrary');
    }

	public function index($page = null)
	{
        $responsibilities     = $this->responsibility->join('draft')->join('user')->orderBy('draft.draft_id')->orderBy('user.user_id')->orderBy('responsibility_id')->paginate($page)->getAll();
        $tot        = $this->responsibility->join('draft')->join('user')->orderBy('draft.draft_id')->orderBy('user.user_id')->orderBy('responsibility_id')->getAll();
        $total     = count($tot);
        $pages    = $this->pages;
        $main_view  = 'responsibility/index_responsibility';
        $pagination = $this->responsibility->makePagination(site_url('responsibility'), 2, $total);

		$this->load->view('template', compact('pages', 'main_view', 'responsibilities', 'pagination', 'total'));
	}
        
        
        public function add($jenis_staff)
	{   
        $data = array();
        if (!$_POST) {
            $input = (object) $this->responsibility->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->responsibility->validate()) {
            $data['validasi'] = false;
            echo json_encode($data);
            // $pages     = $this->pages;
            // $main_view   = 'responsibility/form_responsibility';
            // $form_action = 'responsibility/add';
            // $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        //$datax = array('draft_id' => $input->draft_id);
        if($jenis_staff == 'editor'){
            $data['jmlstaff'] = count($this->responsibility->join('user')->where('user.level','editor')->where('responsibility.draft_id',$input->draft_id)->getAll());
            if($data['jmlstaff'] >1){
                $data['validasi'] = 'max';
                echo json_encode($data);
                return;
            }
        }elseif($jenis_staff == 'layouter'){
            $data['jmlstaff'] = count($this->responsibility->join('user')->where('user.level','layouter')->where('responsibility.draft_id',$input->draft_id)->getAll());
            if($data['jmlstaff'] >1){
                $data['validasi'] = 'max';
                echo json_encode($data);
                return;
            }
        }

        if ($this->responsibility->insert($input)) {
            if($jenis_staff == 'editor'){
                $r_draft = $this->db->query("select * from draft where draft_id='".$input->draft_id."'")->row();
                $user_id_notif = $input->user_id;
                $judul_notif = 'antrian edit draft baru';//
                $isi_notif = 'antrian edit draft '.$r_draft->draft_title;
                $data_notif = array('user_id' => $user_id_notif, 
                                        'judul' => $judul_notif, 
                                        'isi' => $isi_notif,
                                        'draft_id' => $r_draft->draft_id
                                    );
                $this->db->insert('notifikasi', $data_notif);
                $q_user = $this->db->query("select user_id, firebase_token from user where user_id='$user_id_notif'")->row();    
                //firebase
                if($q_user->firebase_token != ''){
                    $firebase_token = $q_user->firebase_token;
                    $params_notif = array('draft_id' => $r_draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }else if($jenis_staff == 'layouter'){
                $r_draft = $this->db->query("select * from draft where draft_id='".$input->draft_id."'")->row();
                $user_id_notif = $input->user_id;
                $judul_notif = 'draft layout baru';//
                $isi_notif = 'draft layout baru '.$r_draft->draft_title;
                $data_notif = array('user_id' => $user_id_notif, 
                                        'judul' => $judul_notif, 
                                        'isi' => $isi_notif,
                                        'draft_id' => $r_draft->draft_id
                                    );
                $this->db->insert('notifikasi', $data_notif);
                $q_user = $this->db->query("select user_id, firebase_token from user where user_id='$user_id_notif'")->row();    
                //firebase
                if($q_user->firebase_token != ''){
                    $firebase_token = $q_user->firebase_token;
                    $params_notif = array('draft_id' => $r_draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }

            $data['validasi'] = true;
            $data['status'] = true;
            $data['isi'] = 'haahashsahdhasdhasd';
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $data['validasi'] = true;
            $data['status'] = false;
            $this->session->set_flashdata('error', 'Data failed to save');
        }

        echo json_encode($data);
	}

        public function mulai_proses($jenis_staff = null)
    {
        //ketika editor/layouter klik mulai maka akan mencatat tanggal mulai dan tanggal deadline
        $input = (object) $this->input->post(null, true);

        if($jenis_staff == 'editor'){
            $status = array('draft_status' => 6);
            $this->responsibility->updateDraftStatus($input->draft_id, $status);
            $current_date = strtotime(date('Y-m-d H:i:s'));
            $end_date = 30 * 24 * 60 * 60;
            $deadline_editor = date('Y-m-d H:i:s', ($current_date + $end_date));
            $this->responsibility->editDraftDate($input->draft_id, 'edit_deadline', $deadline_editor);
            if($this->responsibility->editDraftDate($input->draft_id, $input->col)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }
            //kirim notif ke author draft bahwa editorial telah dimulai
            $draft = $this->db->query("select draft_id, draft_title from draft where draft_id='".$input->draft_id."'")->row();
            $q_admin = $this->db->query("select * from user where level='superadmin' or level='admin_penerbitan'");
            foreach($q_admin->result() as $idx => $r_admin){
                    $user_id_notif = $r_admin->user_id;
                    $judul_notif = 'draft editorial telah dimulai';//
                    $isi_notif = 'draft editorial '.$draft->draft_title.' telah dimulai';
                    $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                    $this->db->insert('notifikasi', $data_notif);
                    if($idx==0){
                        //firebase
                        $topics = "sigap_superadmin";
                        $params_notif = array('draft_id' => $draft->draft_id);
                        $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);

                        $topics = "sigap_admin_penerbitan";
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);
                    }

            }
            $q_author = $this->db->query("select a.user_id, firebase_token from draft_author da join author a on da.author_id=a.author_id join user u on a.user_id=u.user_id where draft_id='".$input->draft_id."'");
            foreach($q_author->result() as $r_author){
                $user_id_notif = $r_author->user_id;
                $judul_notif = 'draft telah masuk editorial';//
                $isi_notif = 'draft '.$draft->draft_title.' telah masuk tahapan editorial';
                $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                $this->db->insert('notifikasi', $data_notif);   
                //firebase
                if($r_author->firebase_token != ''){
                    $firebase_token = $r_author->firebase_token;
                    $params_notif = array('draft_id' => $draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }
        }elseif($jenis_staff == 'layouter'){
            $status = array('draft_status' => 8);
            $this->responsibility->updateDraftStatus($input->draft_id, $status);
            $current_date = strtotime(date('Y-m-d H:i:s'));
            $end_date = 30 * 24 * 60 * 60;
            $deadline_layouter = date('Y-m-d H:i:s', ($current_date + $end_date));
            $this->responsibility->editDraftDate($input->draft_id, 'layout_deadline', $deadline_layouter);
            if($this->responsibility->editDraftDate($input->draft_id, $input->col)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }

            //kirim notif ke author draft bahwa layout telah dimulai
            $draft = $this->db->query("select draft_title, draft_id from draft where draft_id='".$input->draft_id."'")->row();
            $q_admin = $this->db->query("select * from user where level='superadmin' or level='admin_penerbitan'");
            foreach($q_admin->result() as $idx => $r_admin){
                    $user_id_notif = $r_admin->user_id;
                    $judul_notif = 'draft layout telah dimulai';//
                    $isi_notif = 'draft layout '.$draft->draft_title.' telah dimulai';
                    $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                    $this->db->insert('notifikasi', $data_notif);
                    if($idx == 0){
                        //firebase
                        $topics = "sigap_superadmin";
                        $params_notif = array('draft_id' => $draft->draft_id);
                        $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);

                        $topics = "sigap_admin_penerbitan";
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);
                    }
            }
            $q_author = $this->db->query("select a.user_id, firebase_token from draft_author da join author a on da.author_id=a.author_id join user u on a.user_id=u.user_id where draft_id='".$input->draft_id."'");
            foreach($q_author->result() as $r_author){
                $user_id_notif = $r_author->user_id;
                $judul_notif = 'draft telah masuk layouter';//
                $isi_notif = 'draft '.$draft->draft_title.' telah masuk tahapan layout';
                $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                $this->db->insert('notifikasi', $data_notif);
                //firebase
                if($r_author->firebase_token != ''){
                    $firebase_token = $r_author->firebase_token;
                    $params_notif = array('draft_id' => $draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }
        }elseif($jenis_staff == 'cover'){
            $status = array('draft_status' => 10);
            $this->responsibility->updateDraftStatus($input->draft_id, $status);
            $current_date = strtotime(date('Y-m-d H:i:s'));
            $end_date = 30 * 24 * 60 * 60;
            $deadline_cover = date('Y-m-d H:i:s', ($current_date + $end_date));
            $this->responsibility->editDraftDate($input->draft_id, 'layout_deadline', $deadline_cover);
            if($this->responsibility->editDraftDate($input->draft_id, $input->col)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }

            //kirim notif ke author draft bahwa layout telah dimulai
            $draft = $this->db->query("select draft_title, draft_id from draft where draft_id='".$input->draft_id."'")->row();
            $q_admin = $this->db->query("select * from user where level='superadmin' or level='admin_penerbitan'");
            foreach($q_admin->result() as $idx => $r_admin){
                    $user_id_notif = $r_admin->user_id;
                    $judul_notif = 'draft cover telah dimulai';//
                    $isi_notif = 'draft cover '.$draft->draft_title.' telah dimulai';
                    $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif
                                        );
                    $this->db->insert('notifikasi', $data_notif);
                    if($idx == 0){
                        $topics = "sigap_superadmin";
                        $params_notif = array('draft_id' => $draft->draft_id);
                        $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);

                        $topics = "sigap_admin_penerbitan";
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);
                    }
            }
            $q_author = $this->db->query("select a.user_id, firebase_token from draft_author da join author a on da.author_id=a.author_id join user on a.user_id=u.user_id where draft_id='".$input->draft_id."'");
            foreach($q_author->result() as $r_author){
                $user_id_notif = $r_author->user_id;
                $judul_notif = 'draft telah masuk desain cover';//
                $isi_notif = 'draft '.$draft->draft_title.' telah masuk tahapan desain cover';
                $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                $this->db->insert('notifikasi', $data_notif);
                //firebase
                if($r_author->firebase_token != ''){
                    $firebase_token = $r_author->firebase_token;
                    $params_notif = array('draft_id' => $draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }
        }else{
            $status = array('draft_status' => 15);
            $this->responsibility->updateDraftStatus($input->draft_id, $status);
            if($this->responsibility->editDraftDate($input->draft_id, $input->col)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }
        }
        echo json_encode($data);
    }

    public function selesai_proses($jenis_staff = null)
    {
        //ketika editor/layouter klik selesai maka akan mencatat tanggal selesai
        $input = (object) $this->input->post(null, true);

        if($jenis_staff == 'editor'){
            //untuk set performance status
           // $this->db->query("UPDATE responsibility
           //  LEFT JOIN user ON responsibility.user_id = user.user_id 
           //  SET performance_status = 2
           //  WHERE level = '".$jenis_staff."' and draft_id = ".$input->draft_id);

            if($this->responsibility->editDraftDate($input->draft_id, $input->col)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }
            $draft = $this->db->query("select draft_id, draft_title from draft where draft_id='".$input->draft_id."'")->row();
            $q_admin = $this->db->query("select * from user where level='superadmin' or level='admin_penerbitan'");
            foreach($q_admin->result() as $idx => $r_admin){
                    $user_id_notif = $r_admin->user_id;
                    $judul_notif = 'draft editorial telah selesai';//
                    $isi_notif = 'draft editorial '.$draft->draft_title.' telah selesai';
                    $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                    $this->db->insert('notifikasi', $data_notif);
                    if($idx == 0){
                        $topics = "sigap_superadmin";
                        $params_notif = array('draft_id' => $draft->draft_id);
                        $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);

                        $topics = "sigap_admin_penerbitan";
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);
                    }
            }

            $q_author = $this->db->query("select a.user_id, firebase_token from draft_author da join author a on da.author_id=a.author_id join user u on a.user_id=u.user_id where draft_id='".$input->draft_id."'");
            foreach($q_author->result() as $r_author){
                $user_id_notif = $r_author->user_id;
                $judul_notif = 'draft editorial telah selesai';//
                $isi_notif = 'draft editorial '.$draft->draft_title.' telah selesai';
                $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                $this->db->insert('notifikasi', $data_notif);
                if($r_author->firebase_token != ''){
                    $firebase_token = $r_author->firebase_token;
                    $params_notif = array('draft_id' => $draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }
        }elseif($jenis_staff == 'layouter'){
            //untuk set performance status
            // $this->db->query("UPDATE responsibility
            // LEFT JOIN user ON responsibility.user_id = user.user_id 
            // SET performance_status = 2
            // WHERE level = '".$jenis_staff."' and draft_id = ".$input->draft_id);

            if($this->responsibility->editDraftDate($input->draft_id, $input->col)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }

            $draft = $this->db->query("select draft_title, draft_id from draft where draft_id='".$input->draft_id."'")->row();
            $q_admin = $this->db->query("select * from user where level='superadmin' or level='admin_penerbitan'");
            foreach($q_admin->result() as $idx => $r_admin){
                    $user_id_notif = $r_admin->user_id;
                    $judul_notif = 'draft layout telah selesai';//
                    $isi_notif = 'draft layout '.$draft->draft_title.' telah selesai';
                    $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif
                                        );
                    $this->db->insert('notifikasi', $data_notif);
                    if($idx == 0){
                        $topics = "sigap_superadmin";
                        $params_notif = array('draft_id' => $draft->draft_id);
                        $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);

                        $topics = "sigap_admin_penerbitan";
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);
                    }
            }

            $q_author = $this->db->query("select a.user_id, firebase_token from draft_author da join author a on da.author_id=a.author_id join user u on a.user_id=u.user_id where draft_id='".$input->draft_id."'");
            foreach($q_author->result() as $r_author){
                $user_id_notif = $r_author->user_id;
                $judul_notif = 'draft layout telah selesai';//
                $isi_notif = 'draft layout '.$draft->draft_title.' telah selesai';
                $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                $this->db->insert('notifikasi', $data_notif);
                if($r_author->firebase_token != ''){
                    $firebase_token = $r_author->firebase_token;
                    $params_notif = array('draft_id' => $draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }
        }elseif($jenis_staff == 'cover'){
            //untuk set performance status
            // $this->db->query("UPDATE responsibility
            // LEFT JOIN user ON responsibility.user_id = user.user_id 
            // SET performance_status = 2
            // WHERE level = '".$jenis_staff."' and draft_id = ".$input->draft_id);

            if($this->responsibility->editDraftDate($input->draft_id, $input->col)){
                $data['status'] = true;
            }else{
                $data['status'] = false;
            }

            $draft = $this->db->query("select draft_title, draft_id from draft where draft_id='".$input->draft_id."'")->row();
            $q_admin = $this->db->query("select * from user where level='superadmin' or level='admin_penerbitan'");
            foreach($q_admin->result() as $idx => $r_admin){
                    $user_id_notif = $r_admin->user_id;
                    $judul_notif = 'draft cover telah selesai';//
                    $isi_notif = 'draft cover '.$draft->draft_title.' telah selesai';
                    $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                    $this->db->insert('notifikasi', $data_notif);
                    if($idx == 0){
                        $topics = "sigap_superadmin";
                        $params_notif = array('draft_id' => $draft->draft_id);
                        $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);

                        $topics = "sigap_admin_penerbitan";
                        $this->jagolibrary->sendNotifTopics($message_notif, $topics, $params_notif);
                    }
            }

            $q_author = $this->db->query("select a.user_id, firebase_token from draft_author da join author a on da.author_id=a.author_id join user u on a.user_id=u.user_id where draft_id='".$input->draft_id."'");
            foreach($q_author->result() as $r_author){
                $user_id_notif = $r_author->user_id;
                $judul_notif = 'draft cover telah selesai';//
                $isi_notif = 'draft cover '.$draft->draft_title.' telah selesai';
                $data_notif = array('user_id' => $user_id_notif, 
                                            'judul' => $judul_notif, 
                                            'isi' => $isi_notif,
                                            'draft_id' => $draft->draft_id
                                        );
                $this->db->insert('notifikasi', $data_notif);
                //firebase
                if($r_author->firebase_token != ''){
                    $firebase_token = $r_author->firebase_token;
                    $params_notif = array('draft_id' => $draft->draft_id);
                    $message_notif = array('title' => $judul_notif, 'body' => $isi_notif, 'sound' => 'default');
                    $this->jagolibrary->sendNotifToId($message_notif, $firebase_token, $params_notif);
                }
            }
        }
        echo json_encode($data);
    }
        
        public function edit($id = null)
	{
        $responsibility = $this->responsibility->where('responsibility_id', $id)->get();
        if (!$responsibility) {
            $this->session->set_flashdata('warning', 'Responsibility data were not available');
            redirect('responsibility');
        }

        if (!$_POST) {
            $input = (object) $responsibility;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->responsibility->validate()) {
            $pages    = $this->pages;
            $main_view   = 'responsibility/form_responsibility';
            $form_action = "responsibility/edit/$id";

            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        if ($this->responsibility->where('responsibility_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }

        redirect('responsibility');
	}
        
        public function delete($id = null)
	{
        $data = array();
	   $responsibility = $this->responsibility->where('responsibility_id', $id)->get();
        if (!$responsibility) {
            $data['cek'] = false;
            $this->session->set_flashdata('warning', 'Responsibility data were not available');
            //redirect('responsibility');
        }

        if ($this->responsibility->where('responsibility_id', $id)->delete()) {
            $data['cek'] = true;
            $data['status'] = true;
            $this->session->set_flashdata('success', 'Data deleted');
		} else {
            $data['cek'] = true;
            $data['status'] = false;
            $this->session->set_flashdata('error', 'Data failed to delete');
        }

		echo json_encode($data);
	}
        
        public function search($page = null)
        {
        $keywords   = $this->input->get('keywords', true);
        $responsibilities     = $this->responsibility->like('responsibility_id', $keywords)
                                  ->orLike('user_id', $keywords)
                                  ->join('draft')
                                  ->join('user')
                                  ->orderBy('draft.draft_id')
                                  ->orderBy('user.user_id')                
                                  ->orderBy('responsibility_id')
                                  ->paginate($page)
                                  ->getAll();
        $tot        = $this->responsibility->like('responsibility_id', $keywords)
                                  ->orLike('user_id', $keywords)
                                  ->join('draft')
                                  ->join('user')
                                  ->orderBy('draft.draft_id')
                                  ->orderBy('user.user_id')                
                                  ->orderBy('responsibility_id')
                                  ->getAll();
        $total = count($tot);

        $pagination = $this->responsibility->makePagination(site_url('responsibility/search/'), 3, $total);

        if (!$responsibilities) {
            $this->session->set_flashdata('warning', 'Data were not found');
            redirect('responsibility');
        }

        $pages    = $this->pages;
        $main_view  = 'responsibility/index_responsibility';
        $this->load->view('template', compact('pages', 'main_view', 'responsibilities', 'pagination', 'total'));
    }
        
        /*
    |-----------------------------------------------------------------
    | Callback
    |-----------------------------------------------------------------
    */
//    public function alpha_coma_dash_dot_space($str)
//    {
//        if ( !preg_match('/^[a-zA-Z .,\-]+$/i',$str) )
//        {
//            $this->form_validation->set_message('alpha_coma_dash_dot_space', 'Can only be filled with letters, numbers, dash(-), dot(.), and comma(,).');
//            return false;
//        }
//    }
//
    public function unique_responsibility_match()
    {
        $user_id      = $this->input->post('user_id');
        $draft_id      = $this->input->post('draft_id');
        $responsibility_id = $this->input->post('responsibility_id');

        $this->responsibility->where('user_id', $user_id);
        $this->responsibility->where('draft_id', $draft_id);
        !$responsibility_id || $this->responsibility->where('responsibility_id !=', $responsibility_id);
        $responsibility = $this->responsibility->get();

        if(is_array($responsibility)){
            if (count($responsibility)) {
                $this->form_validation->set_message('unique_responsibility_match', 'Both of %s has been used');
                return false;
            }
        }
        return true;
    }

}