<?php defined('BASEPATH') or exit('No direct script access allowed');

use Carbon\Carbon;

class Draft extends Operator_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pages = 'draft';
    }

    public function index($page = null)
    {
        // all filter
        $filters = [
            'category' => $this->input->get('category', true),
            'reprint'  => $this->input->get('reprint', true),
            'progress' => $this->input->get('progress', true),
            'keyword'  => $this->input->get('keyword', true),
        ];

        // custom per page
        if ($this->input->get('per_page', true) != null) {
            $this->draft->per_page = $this->input->get('per_page', true);
        }

        if ($this->level == 'reviewer') {
            $get_data = $this->draft->filter_draft_for_reviewer($filters, $this->username, $page);

            // user yang sedang login merupakan reviewer 1 atau 2
            foreach ($get_data['drafts'] as $d) {
                $draft_reviewers = $this->draft->get_id_and_name('reviewer', 'draft_reviewer', $d->draft_id);
                $reviewer_key    = key(array_filter($draft_reviewers, function ($dr) {
                    return $dr->reviewer_id == $this->role_id;
                }));
                if ($reviewer_key == 0) {
                    // reviewer 1
                    $d->review_flag     = $d->review1_flag;
                    $d->review_deadline = $d->review1_deadline;
                } elseif ($reviewer_key == 1) {
                    // reviewer 2
                    $d->review_flag     = $d->review2_flag;
                    $d->review_deadline = $d->review2_deadline;
                } else {
                    $d->review_flag     = null;
                    $d->review_deadline = null;
                }

                $date          = Carbon::parse($d->review_deadline);
                $d->sisa_waktu = $date->diffInDays();
            }
        } elseif ($this->level == 'editor') {
            $get_data = $this->draft->filter_draft_for_staff($filters, $this->username, $page);

            foreach ($get_data['drafts'] as $d) {
                $date          = Carbon::parse($d->edit_deadline);
                $d->sisa_waktu = $date->diffInDays();
            }
        } elseif ($this->level == 'layouter') {
            $get_data = $this->draft->filter_draft_for_staff($filters, $this->username, $page);
            foreach ($get_data['drafts'] as $d) {
                $date          = Carbon::parse($d->layout_deadline);
                $d->sisa_waktu = $date->diffInDays();
            }
        } elseif ($this->level == 'author') {
            $get_data = $this->draft->filter_draft_for_author($filters, $this->username, $page);
        } else {
            $get_data = $this->draft->filter_draft_for_admin($filters, $page);

            // if ($progress == 'error') {
            //     //inisialisasi array penampung kondisi not in
            //     $desk_screening = [''];
            //     $review         = [''];
            //     $edit           = [''];
            //     $layout         = [''];
            //     $proofread      = [''];
            //     $final          = [''];
            //     $cetak_ulang    = [''];
            //     $ditolak        = [''];

            //     //menghitung filter lain, untuk mencari draft yang error
            //     $desk_screenings = $this->draft->select(['draft_id'])->where('draft_status', 1)->or_where('draft_status', 0)->get_all();
            //     foreach ($desk_screenings as $value) {
            //         $desk_screening[] = $value->draft_id;
            //     }
            //     $reviews = $this->draft->select(['draft_id'])->where('is_review', 'n')->where('is_edit', 'n')->where('is_layout', 'n')->where('is_proofread', 'n')->where('is_print', 'n')->where('draft_status', '4')->get_all();
            //     foreach ($reviews as $value) {
            //         $review[] = $value->draft_id;
            //     }
            //     $edits = $this->draft->select(['draft_id'])->where('is_review', 'y')->where('is_edit', 'n')->where('is_layout', 'n')->where('is_proofread', 'n')->where('is_print', 'n')->where_not('draft_status', '99')->get_all();
            //     foreach ($edits as $value) {
            //         $edit[] = $value->draft_id;
            //     }
            //     $layouts = $this->draft->select(['draft_id'])->where('is_review', 'y')->where('is_edit', 'y')->where('is_layout', 'n')->where('is_proofread', 'n')->where('is_print', 'n')->where_not('draft_status', '99')->get_all();
            //     foreach ($layouts as $value) {
            //         $layout[] = $value->draft_id;
            //     }
            //     $proofreads = $this->draft->select(['draft_id'])->where('is_review', 'y')->where('is_edit', 'y')->where('is_layout', 'y')->where('is_proofread', 'n')->where('is_print', 'n')->where_not('draft_status', '99')->get_all();
            //     foreach ($proofreads as $value) {
            //         $proofread[] = $value->draft_id;
            //     }
            //     $prints = $this->draft->select(['draft_id'])->where('is_review', 'y')->where('is_edit', 'y')->where('is_layout', 'y')->where('is_proofread', 'y')->group_start()->where('is_print', 'n')->or_where('is_print', 'y')->group_end()->where_not('draft_status', '99')->where_not('draft_status', '14')->get_all();
            //     foreach ($prints as $value) {
            //         $print[] = $value->draft_id;
            //     }
            //     $finals = $this->draft->select(['draft_id'])->where('is_review', 'y')->where('is_edit', 'y')->where('is_layout', 'y')->where('is_proofread', 'y')->where('is_print', 'y')->where('is_reprint', 'n')->where('draft_status', 14)->get_all();
            //     foreach ($finals as $value) {
            //         $final[] = $value->draft_id;
            //     }
            //     $cetak_ulangs = $this->draft->select(['draft_id'])->where('is_reprint', 'y')->get_all();
            //     foreach ($cetak_ulangs as $value) {
            //         $cetak_ulang[] = $value->draft_id;
            //     }
            //     $rejecteds = $this->draft->select(['draft_id'])->where('draft_status', 2)->or_where('draft_status', 99)->get_all();
            //     foreach ($rejecteds as $value) {
            //         $rejected[] = $value->draft_id;
            //     }

            //     $drafts = $this->draft->join('category')->join('theme')->where_not_in('draft_id', $desk_screening)->where_not_in('draft_id', $review)->where_not_in('draft_id', $edit)->where_not_in('draft_id', $layout)->where_not_in('draft_id', $proofread)->where_not_in('draft_id', $print)->where_not_in('draft_id', $final)->where_not_in('draft_id', $cetak_ulang)->where_not_in('draft_id', $rejected)->where($kat['cond_temp'], $kat['category'])->order_by('draft_status')->order_by('draft_title')->paginate($page)->get_all();

            //     $total = $this->draft->where_not_in('draft_id', $desk_screening)->where_not_in('draft_id', $review)->where_not_in('draft_id', $edit)->where_not_in('draft_id', $layout)->where_not_in('draft_id', $proofread)->where_not_in('draft_id', $print)->where_not_in('draft_id', $final)->where_not_in('draft_id', $cetak_ulang)->where_not_in('draft_id', $rejected)->where($kat['cond_temp'], $kat['category'])->count();
            // } else {
            //     //get semua draft jik filter gagal semua
            //     $drafts = $this->draft->join('category')->join('theme')->join_relation_middle('draft', 'draft_author')->join_relation_dest('author', 'draft_author')->where($kat['cond_temp'], $kat['category'])->order_by('draft_status')->order_by('draft_title')->paginate($page)->get_all();
            //     $total  = $this->draft->where($kat['cond_temp'], $kat['category'])->count();
            // }
        }

        $drafts     = $get_data['drafts'];
        $total      = $get_data['total'];
        $pagination = $this->draft->make_pagination(site_url('draft'), 2, $total);
        if (!$drafts) {
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
        }

        $pages     = $this->pages;
        $main_view = 'draft/index_draft';
        $this->load->view('template', compact('pages', 'main_view', 'drafts', 'pagination', 'total'));
    }

    // public function ajax_reload_author()
    // {
    //     $data = $this->draft->select(['author_id', 'author_name'])->get_all('author');
    //     if ($data) {
    //         foreach ($data as $value) {
    //             $datax[$value->author_id] = $value->author_name;
    //         }
    //         echo json_encode($datax);
    //     }
    // }

    public function add($category = null)
    {
        // khusus admin dan author
        if (!is_admin() && $this->level != 'author') {
            redirect();
        }

        if ($this->level == 'author') {
            // author tidak boleh daftar draft tanpa kategori
            if (!$category) {
                $this->session->set_flashdata('error', $this->lang->line('form_draft_error_category_not_found'));
                redirect();
            }
            // hanya untuk user level author yang terdaftar sebagai author
            if ($this->role_id == 0) {
                $this->session->set_flashdata('error', $this->lang->line('form_draft_error_author_not_registered'));
                redirect();
            }
        }

        // cek category tersedia dan aktif
        // untuk pendaftaran draft oleh author
        if ($category) {
            $data            = array('category_id' => $category);
            $cekcategory     = $this->draft->get_where($data, 'category');
            $sisa_waktu_buka = ceil((strtotime($cekcategory->date_open) - strtotime(date('Y-m-d H:i:s'))) / 86400);
            if (!$cekcategory || $cekcategory->category_status == 'n') {
                $this->session->set_flashdata('error', $this->lang->line('form_draft_error_category_not_found')
                );
                redirect();
            } elseif ($sisa_waktu_buka >= 1) {
                $this->session->set_flashdata('error', $this->lang->line('form_draft_error_category_not_opened'));
                redirect();
            }
        }

        if (!$_POST) {
            $input              = (object) $this->draft->get_default_values();
            $input->category_id = $category;
        } else {
            $input = (object) $this->input->post(null, true);
            // catat orang yang menginput draft
            $input->input_by = $this->username;

            // repopulate draft_file ketika validasi form gagal
            if (!isset($input->draft_file)) {
                $input->draft_file = null;
            }
            if (!isset($input->author_id)) {
                $input->author_id = [];
            }

            $this->session->set_flashdata('draft_file_no_data', $this->lang->line('form_error_file_no_data'));
        }

        if ($this->draft->validate()) {
            if (!empty($_FILES) && $df = $_FILES['draft_file']['name']) {
                $draft_file_name = $this->_generate_draft_file_name($df, $input->draft_title);
                $upload          = $this->draft->upload_draft_file('draft_file', $draft_file_name);
                if ($upload) {
                    $input->draft_file = $draft_file_name;
                }
            }
        }

        if (!$this->draft->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'draft/form_draft_add';
            $form_action = 'draft/add';
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }

        $draft_id = $this->draft->insert($input);

        if ($draft_id) {
            // hanya author pertama yang boleh edit draft
            // author lain hanya bisa view only
            foreach ($input->author_id as $key => $value) {
                $draft_author_id = $this->draft->insert([
                    'author_id'           => $value,
                    'draft_id'            => $draft_id,
                    'draft_author_status' => $key == 0 ? 1 : 0, // author pertama, flag 1, artinya boleh edit draft
                ], 'draft_author');

                if (!$draft_author_id) {
                    $is_success = false;
                } else {
                    $is_success = true;
                }
            }
        } else {
            $is_success = false;
        }

        if ($is_success) {
            // insert ke worksheet
            $worksheet_num = $this->generate_worksheet_number();
            $worksheet_id  = $this->draft->insert([
                'draft_id'         => $draft_id,
                'worksheet_num'    => $worksheet_num,
                'worksheet_status' => 0,
            ], 'worksheet');
            if ($worksheet_id < 1) {
                $is_success = false;
            }
        }

        if ($is_success) {
            $this->session->set_flashdata('success', $this->lang->line('toast_add_success'));
        } else {
            $this->session->set_flashdata('error', $this->lang->line('toast_add_fail'));
        }
        redirect('draft/view/' . $draft_id);
    }

    public function view($id = null)
    {
        if ($id == null) {
            redirect($this->pages);
        }

        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            die();
            $this->session->set_flashdata('warning', $this->lang->line('toast_data_not_available'));
            redirect($this->pages);
        }

        if (!$this->draft->is_authorized($this->level, $this->username, $id)) {
            $this->session->set_flashdata('error', $this->lang->line('toast_error_not_authorized'));
            redirect($this->pages);
        }

        // ambil tabel worksheet
        $desk = $this->draft->get_where(['draft_id' => $id], 'worksheet');
        // ambil tabel books
        $books = $this->draft->get_where(['draft_id' => $id], 'book');

        // pecah data nilai, csv jadi array
        // hitung bobot nilai
        if ($draft->nilai_reviewer1) {
            $draft->nilai_reviewer1       = explode(",", $draft->nilai_reviewer1);
            $draft->nilai_total_reviewer1 = 35 * $draft->nilai_reviewer1[0] + 25 * $draft->nilai_reviewer1[1] + 10 * $draft->nilai_reviewer1[2] + 30 * $draft->nilai_reviewer1[3];
        } else {
            $draft->nilai_total_reviewer1 = '';
        }
        if ($draft->nilai_reviewer2) {
            $draft->nilai_reviewer2       = explode(",", $draft->nilai_reviewer2);
            $draft->nilai_total_reviewer2 = 35 * $draft->nilai_reviewer2[0] + 25 * $draft->nilai_reviewer2[1] + 10 * $draft->nilai_reviewer2[2] + 30 * $draft->nilai_reviewer2[3];
        } else {
            $draft->nilai_total_reviewer2 = '';
        }

        // if ($draft->nilai_reviewer1) {
        //     $draft->nilai_total_reviewer1 = 35 * $draft->nilai_reviewer1[0] + 25 * $draft->nilai_reviewer1[1] + 10 * $draft->nilai_reviewer1[2] + 30 * $draft->nilai_reviewer1[3];
        // } else {
        // }
        // if ($draft->nilai_reviewer2) {
        //     $draft->nilai_total_reviewer2 = 35 * $draft->nilai_reviewer2[0] + 25 * $draft->nilai_reviewer2[1] + 10 * $draft->nilai_reviewer2[2] + 30 * $draft->nilai_reviewer2[3];
        // } else {
        //     $draft->nilai_total_reviewer2 = '';
        // }

        $input = (object) $draft;

        // ambil author
        $this->load->model('author_model', 'author');
        $authors = $this->author->get_draft_authors($id);
        // cek author pertama, jika $author_order == 0
        $author_order = array_search($this->role_id, array_column($authors, 'author_id')) == 0 ? true : false;

        // ambil reviewer
        $this->load->model('reviewer_model', 'reviewer');
        $reviewers = $this->reviewer->get_draft_reviewers($id);
        // cari reviewer pertama, jika $reviewer_order == 0
        $reviewer_order = array_search($this->role_id, array_column($reviewers, 'reviewer_id'));

        // ambil editor dan layouter
        $this->load->model('user_model', 'user');
        $editors   = $this->user->get_draft_staffs($id, 'editor');
        $layouters = $this->user->get_draft_staffs($id, 'layout');

        // hitung jumlah revisi
        $this->load->model('revision_model', 'revision');
        $revision_total['editor']   = $this->revision->count_revision($id, 'editor');
        $revision_total['layouter'] = $this->revision->count_revision($id, 'layouter');

        $pages       = $this->pages;
        $main_view   = 'draft/view/view';
        $form_action = "draft/edit/$id";
        $this->load->view('template', compact('revision_total', 'books', 'author_order', 'draft', 'reviewer_order', 'desk', 'pages', 'main_view', 'form_action', 'input', 'authors', 'reviewers', 'editors', 'layouters'));
    }

    // public function download($path, $file_name)
    // {
    //     $this->load->helper('download');
    //     force_download('./' . $path . '/' . $file_name, null);
    // }

    public function upload_progress($id, $column)
    {
        $draft     = $this->draft->where('draft_id', $id)->get();
        $datatitle = ['draft_id' => $id];
        $title     = $this->draft->get_where($datatitle);
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }
        $isCanAccess = false;
        if ($this->level == 'author') {
            $draft_author_status = $this->getDraftAuthorStatus($this->role_id, $id);
            if ($draft_author_status < 1) {
                $data['status'] = false;
            } else {
                $isCanAccess = true;
            }
        } else {
            $isCanAccess = true;
        }
        if ($isCanAccess) {
            if (!$_POST) {
                $input = (object) $draft;
            } else {
                $input          = (object) $this->input->post(null, true);
                $input->$column = $draft->$column; // Set draft file for preview.

            }
            //tiap upload, update upload date
            $tahap = explode('_', $column);
            $this->draft->edit_draft_date($id, $tahap[0] . '_upload_date');
            $last_upload         = $tahap[0] . '_last_upload';
            $input->$last_upload = $this->username;
            if (!empty($_FILES) && $_FILES[$column]['size'] > 0) {
                // Upload new draft (if any)
                $getextension  = explode(".", $_FILES[$column]['name']);
                $draftFileName = str_replace(" ", "_", $title->draft_title . '_' . $column . '_' . date('YmdHis') . "." . $getextension[1]); // draft file name
                if ($column == 'cover_file') {
                    $upload = $this->draft->uploadProgressCover($column, $draftFileName);
                } else {
                    $upload = $this->draft->uploadProgress($column, $draftFileName);
                }
                if ($upload) {
                    $input->$column = "$draftFileName";
                    // Delete old draft file
                    if ($draft->$column) {
                        if ($column == 'cover_file') {
                            $this->draft->deleteProgressCover($draft->$column);
                        } else {
                            $this->draft->deleteProgress($draft->$column);
                        }
                    }
                }
            }
            //If something wrong
            // if (!$this->draft->validate() || $this->form_validation->error_array()) {
            //     $pages    = $this->pages;
            //     $main_view   = 'draft/view/view';
            //     $form_action = "draft/edit/$id";
            //     $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            //     return;
            // }
            if ($this->draft->where('draft_id', $id)->update($input)) {
                //$this->session->set_flashdata('success', 'Upload Success');
                $data['status'] = true;
            } else {
                //$this->session->set_flashdata('error', 'Upload Failed');
                $data['status'] = false;
            }
        }
        echo json_encode($data);
        //redirect('draft/view/'.$id);

    }
    // hapus progress draft
    public function delete_progress($id, $jenis)
    {
        $draft = $this->draft->where('draft_id', $id)->get();
        if ($jenis == 'edit') {
            if (file_exists("./draftfile/$draft->edit_file")) {
                unlink("./draftfile/$draft->edit_file");
                $flag = true;
            } else {
                $data['status'] = false;
            }
        } elseif ($jenis == 'layout') {
            if (file_exists("./draftfile/$draft->layout_file")) {
                unlink("./draftfile/$draft->layout_file");
                $flag = true;
            } else {
                $data['status'] = false;
            }
        }

        if ($flag) {
            $draft->{$jenis . '_upload_date'} = null;
            $draft->{$jenis . '_last_upload'} = '';
            $draft->{$jenis . '_file'}        = '';
            if ($jenis == 'edit') {
                $draft->editor_file_link = '';
            } elseif ($jenis == 'layout') {
                $draft->layouter_file_link = '';
            }

            if ($this->draft->where('draft_id', $id)->update($draft)) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
            }
        }

        echo json_encode($data);
    }

    // ubah notes - buat ubah deadline juga
    public function ubahnotes($id = null, $rev = null)
    {
        $ceklevel = $this->session->userdata('level');
        $data     = array();
        $draft    = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }
        $isCanAccess = false;
        if ($this->level == 'author') {
            $draft_author_status = $this->getDraftAuthorStatus($this->role_id, $id);
            if ($draft_author_status < 1) {
                $data['status'] = false;
            } else {
                $isCanAccess = true;
            }
        } else {
            $isCanAccess = true;
        }
        if ($isCanAccess) {
            if (!$_POST) {
                $input = (object) $draft;
            } else {
                $input = (object) $this->input->post(null, false);
            }
            if (empty($input->files)) {
                unset($input->files);
            }
            // If something wrong
            // if (!$this->draft->validate() || $this->form_validation->error_array()) {
            //     return;
            // }
            //gabungkan array menjadi csv
            if ($rev == 1) {
                $input->nilai_reviewer1 = implode(",", $input->nilai_reviewer1);
            } elseif ($rev == 2) {
                $input->nilai_reviewer2 = implode(",", $input->nilai_reviewer2);
            } else {
                unset($input->nilai_reviewer1);
                unset($input->nilai_reviewer2);
            }

            if (!empty($this->input->post('edit_notes_date'))) {
                if ($ceklevel == 'editor') {
                    $input->edit_notes_date  = date('Y-m-d H:i:s');
                    $data['edit_notes_date'] = format_datetime($input->edit_notes_date);
                }
            }

            if (!empty($this->input->post('layout_notes_date'))) {
                if ($ceklevel == 'layouter') {
                    $input->layout_notes_date  = date('Y-m-d H:i:s');
                    $data['layout_notes_date'] = format_datetime($input->layout_notes_date);
                }
            }

            if ($this->draft->where('draft_id', $id)->update($input)) {
                //$this->session->set_flashdata('success', 'Data updated');
                $data['status'] = true;
            } else {
                $data['status'] = false;
                //$this->session->set_flashdata('error', 'Data failed to update');

            }
        }
        echo json_encode($data);
    }

    public function edit($id = null)
    {
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin' and $ceklevel != 'admin_penerbitan') {
            redirect('draft');
        }
        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }
        if (!$_POST) {
            $input = (object) $draft;
        } else {
            $input = (object) $this->input->post(null, false);
            //$input->draft_file = $draft->draft_file; // Set draft file for preview.

        }
        if ($this->draft->validate()) {
            if (!empty($_FILES) && $_FILES['draft_file']['size'] > 0) {
                $getextension  = explode(".", $_FILES['draft_file']['name']);
                $draftFileName = str_replace(" ", "_", $input->draft_title . '_' . date('YmdHis') . "." . $getextension[1]); // draft file name
                $upload        = $this->draft->upload_draft_file('draft_file', $draftFileName);
                if ($upload) {
                    $input->draft_file = "$draftFileName";
                    // Delete old draft file
                    if ($draft->draft_file) {
                        $this->draft->delete_draft_file($draft->draft_file);
                    }
                }
            }
        }
        if ($this->draft->validate()) {
            if (!empty($_FILES) && $_FILES['cover_file']['size'] > 0) {
                // Upload new draft (if any)
                $getextension  = explode(".", $_FILES['cover_file']['name']);
                $coverFileName = str_replace(" ", "_", $input->draft_title . '_' . date('YmdHis') . "." . $getextension[1]); // cover file name
                $upload        = $this->draft->uploadCoverfile('cover_file', $coverFileName);
                if ($upload) {
                    $input->cover_file = "$coverFileName";
                    // Delete old cover file
                    if ($draft->cover_file) {
                        $this->draft->deleteCoverfile($draft->cover_file);
                    }
                }
            }
        }
        // If something wrong
        if (!$this->draft->validate() || $this->form_validation->error_array()) {
            $pages       = $this->pages;
            $main_view   = 'draft/form_draft_edit';
            $form_action = "draft/edit/$id";
            $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
            return;
        }
        if ($this->draft->where('draft_id', $id)->update($input)) {
            $this->session->set_flashdata('success', 'Data updated');
        } else {
            $this->session->set_flashdata('error', 'Data failed to update');
        }
        redirect('draft');
    }
    public function delete($id = null)
    {
        //khusus admin
        $ceklevel = $this->session->userdata('level');
        if ($ceklevel != 'superadmin' and $ceklevel != 'admin_penerbitan') {
            redirect('draft');
        }
        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }
        $is_success = true;
        $this->draft->where('draft_id', $id)->delete('draft_author');
        $affected_rows = $this->db->affected_rows();
        if ($affected_rows > 0) {
            if ($this->draft->where('draft_id', $id)->delete()) {
                // Delete cover.
                $this->draft->delete_draft_file($draft->draft_file);
                $this->draft->delete_draft_file($draft->review1_file);
                $this->draft->delete_draft_file($draft->review2_file);
                $this->draft->delete_draft_file($draft->edit_file);
                $this->draft->delete_draft_file($draft->layout_file);
                $this->draft->deleteCoverfile($draft->cover_file);
                $this->draft->delete_draft_file($draft->proofread_file);
            } else {
                $is_success = false;
            }
        } else {
            $is_success = false;
        }
        if ($is_success) {
            $this->session->set_flashdata('success', 'Data deleted');
        } else {
            $this->session->set_flashdata('error', 'Data failed to delete');
        }
        redirect('draft');
    }
    public function copyToBook($draft_id)
    {
        $this->load->model('book_model', 'book', true);
        $book_id = $this->book->get_id_draft_from_draft_id($draft_id, 'book');
        $datax   = array('draft_id' => $draft_id);
        $draft   = $this->draft->get_where($datax);
        if ($book_id == 0) {
            $data = array('draft_id' => $draft_id, 'book_title' => $draft->draft_title, 'book_file' => $draft->print_file, 'book_file_link' => $draft->print_file_link, 'published_date' => date('Y-m-d H:i:s'));
            if ($this->book->insert($data)) {
                $book_id = $this->db->insert_id();
                if ($book_id != 0) {
                    $this->session->set_flashdata('warning', 'Lengkapi data lalu Submit');
                    redirect('book/edit/' . $book_id);
                }
            }
        } else {
            $this->session->set_flashdata('error', 'Book has been created');
            redirect('book');
        }
    }

    public function cetakUlang($id = '')
    {

        $draft = $this->draft->where('draft_id', $id)->get();
        if (!$draft) {
            $this->session->set_flashdata('warning', 'Draft data were not available');
            redirect('draft');
        }
        $draft->draft_title = $draft->draft_title . " (cetak ulang)";
        // if (!$_POST) {
        // } else {
        //     $input = (object)$this->input->post(null, false);
        // }
        $input             = (object) $draft;
        $input->is_reprint = 'y';
        unset($input->draft_id);

        //get array penulis
        $input->authors   = $this->draft->select('draft_author.author_id')->join_table('draft_author', 'draft', 'draft')->join_table('author', 'draft_author', 'author')->join_table('work_unit', 'author', 'work_unit')->join_table('institute', 'author', 'institute')->where('draft_author.draft_id', $id)->get_all();
        $input->author_id = array();
        foreach ($input->authors as $au) {
            array_push($input->author_id, $au->author_id);
        }

        // if (!$this->draft->validate() || $this->form_validation->error_array()) {
        //     $pages = $this->pages;
        //     $main_view = 'draft/form_draft_add';
        //     $form_action = 'draft/add';
        //     $this->load->view('template', compact('pages', 'main_view', 'form_action', 'input'));
        //     return;
        // }

        $draft_id   = $this->draft->insert($input);
        $is_success = true;
        if ($draft_id > 0) {
            foreach ($input->author_id as $key => $value) {
                $data_author = array('author_id' => $value, 'draft_id' => $draft_id);
                if ($key == 0) {
                    $data_author['draft_author_status'] = 1;
                }
                $draft_author_id = $this->draft->insert($data_author, 'draft_author');
                if ($draft_author_id < 1) {
                    $is_success = false;
                    break;
                }
            }
        } else {
            $is_success = false;
        }
        if ($is_success) {
            $worksheet_num  = $this->generate_worksheet_number();
            $data_worksheet = array('draft_id' => $draft_id, 'worksheet_num' => $worksheet_num, 'worksheet_status' => 1, 'is_reprint' => 'y');
            $worksheet_id   = $this->draft->insert($data_worksheet, 'worksheet');
            if ($worksheet_id < 1) {
                $is_success = false;
            }
        }
        if ($is_success) {
            $this->session->set_flashdata('success', 'Data saved');
        } else {
            $this->session->set_flashdata('error', 'Data failed to save');
        }
        redirect('draft/view/' . $draft_id);
    }

    public function getRevision()
    {
        $input    = (object) $this->input->post(null);
        $ceklevel = $this->session->userdata('level');
        $revisi   = $this->draft->where('revision_role', $input->role)->where('draft_id', $input->draft_id)->get_all('revision');
        $urutan   = 1;
        //flag menandai revisi yang belum selesai
        //flag 1 dan lebih artinya ada yg blm selese
        $flag = 0;
        if ($revisi) {
            foreach ($revisi as $value) {
                if ($value->revision_end_date != '0000-00-00 00:00:00' and $value->revision_end_date != null) {
                    $atribut_tombol_selesai = 'disabled';
                    $atribut_tombol_simpan  = 'd-none';
                    if (!empty($value->revision_notes)) {
                        $form_revisi = '<div class="font-italic">' . nl2br($value->revision_notes) . '</div>';
                    } else {
                        $form_revisi = '<div class="font-italic mb-3">Tidak ada Catatan</div>';
                    }
                    $badge_revisi = '<span class="badge badge-success">Selesai</span>';
                } else {
                    $flag++;
                    $atribut_tombol_selesai = '';
                    $atribut_tombol_simpan  = 'd-inline';
                    if ($ceklevel != 'editor') {
                        if (!empty($value->revision_notes)) {
                            $form_revisi = '<div class="font-italic">' . nl2br($value->revision_notes) . '</div>';
                        } else {
                            $form_revisi = '<div class="font-italic mb-3">Tidak ada Catatan</div>';
                        }
                    } else {
                        $form_revisi = '<textarea rows="6" name="revisi' . $value->revision_id . '" class="form-control summernote-basic" id="revisi' . $value->revision_id . '">' . $value->revision_notes . '</textarea>';
                    }
                    $badge_revisi = '<span class="badge badge-info">Dalam Proses</span>';
                }
                if ($input->role == 'editor') {
                    $tahap = 'edit';
                    $role  = 'editor';
                } else {
                    $tahap = 'layout';
                    $role  = 'layouter';
                }

                if ($ceklevel == 'superadmin' or $ceklevel == 'admin_penerbitan') {
                    $tombol_hapus = '<button title="Hapus revisi" type="button" class="d-inline btn btn-danger hapus-revisi" data="' . $value->revision_id . '"><i class="fa fa-trash"></i><span class="d-none d-lg-inline"> Hapus</span></button>';
                    $tombol_edit  = '<button type="button" class="d-inline btn btn-secondary btn-xs trigger-' . $tahap . '-revisi-deadline" data-toggle="modal" data-target="#' . $tahap . '-revisi-deadline" title="' . $tahap . ' Deadline" data="' . $value->revision_id . '">Edit</button>';
                } else {
                    $tombol_hapus = '';
                    $tombol_edit  = '';
                }

                $data['revisi'][] = '<section class="card card-expansion-item">
                    <header class="card-header border-0" id="heading' . $value->revision_id . '">
                      <button class="btn btn-reset collapsed" data-toggle="collapse" data-target="#collapse' . $value->revision_id . '" aria-expanded="false" aria-controls="collapse' . $value->revision_id . '">
                        <span class="collapse-indicator mr-2">
                          <i class="fa fa-fw fa-caret-right"></i>
                        </span>
                        <span>Revisi #' . $urutan . '</span>
                        ' . $badge_revisi . '
                      </button>
                    </header>
                    <div id="collapse' . $value->revision_id . '" class="collapse" aria-labelledby="heading' . $value->revision_id . '" data-parent="#accordion-' . $role . '">
                    <div class="list-group list-group-flush list-group-bordered">
                        <div class="list-group-item justify-content-between">
                          <span class="text-muted">Tanggal mulai</span>
                          <strong>' . format_datetime($value->revision_start_date) . '</strong>
                        </div>
                        <div class="list-group-item justify-content-between">
                          <span class="text-muted">Tanggal selesai</span>
                          <strong>' . format_datetime($value->revision_end_date) . '</strong>
                        </div>
                        <div class="list-group-item justify-content-between">
                          <span class="text-muted">Deadline ' . $tombol_edit . '</span>
                          <strong>' . format_datetime($value->revision_deadline) . '</strong>
                        </div>
                        <div class="list-group-item mb-0 pb-0">
                          <span class="text-muted">Catatan ' . $role . '</span>
                        </div>
                    </div>
                    <div class="card-body">
                    <form>
                    ' . $form_revisi . '
                    </form>
                        <div class="el-example">
                            <button title="Submit catatan" type="button" class="' . $atribut_tombol_simpan . ' btn btn-primary submit-revisi" data="' . $value->revision_id . '"><i class="fas fa-save"></i><span class="d-none d-lg-inline"> Simpan</span></button>
                            <button title="Selesai revisi" type="button" class="d-inline btn btn-secondary selesai-revisi" ' . $atribut_tombol_selesai . ' data="' . $value->revision_id . '"><i class="fas fa-stop"></i><span class="d-none d-lg-inline"> Selesai</span></button>
                            ' . $tombol_hapus . '
                        </div>
                    </div>
                    </div>
                  </section>';
                $urutan++;
            }
        } else {
            $data['revisi'] = 'Tidak ada revisi';
        }

        if ($flag > 0) {
            $data['flag'] = true;
        } else {
            $data['flag'] = false;
        }
        echo json_encode($data);
    }

    public function insertRevision()
    {
        $input = (object) $this->input->post(null);
        if ($input->role == 'editor') {
            $status = array('draft_status' => 17);
        } elseif ($input->role == 'layouter') {
            $status = array('draft_status' => 18);
        }
        $this->draft->update_draft_status($input->draft_id, $status);
        $datenow  = date('Y-m-d H:i:s');
        $deadline = date('Y-m-d H:i:s', (strtotime($datenow) + (7 * 24 * 60 * 60)));
        $data     = array('draft_id' => $input->draft_id, 'revision_start_date' => $datenow, 'revision_role' => $input->role, 'revision_deadline' => $deadline, 'user_id' => $this->session->userdata('user_id'));
        $insert   = $this->draft->insert($data, 'revision');
        if ($insert) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function endRevision()
    {
        $input  = (object) $this->input->post(null);
        $status = array('draft_status' => 19);
        $this->draft->update_draft_status($input->draft_id, $status);
        $datenow = date('Y-m-d H:i:s');
        $data    = array('revision_end_date' => $datenow);
        $insert  = $this->draft->where('revision_id', $input->revision_id)->update($data, 'revision');
        if ($insert) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function submitRevision()
    {
        $input          = (object) $this->input->post(null);
        $revision_notes = $this->input->post('revision_notes');
        $data           = array('revision_notes' => $revision_notes);
        $insert         = $this->draft->where('revision_id', $input->revision_id)->update($data, 'revision');
        if ($insert) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function deleteRevision($revision_id = '')
    {
        $delete = $this->draft->where('revision_id', $revision_id)->delete('revision');
        if ($delete) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function deadlineRevision()
    {
        $input  = (object) $this->input->post(null);
        $data   = ['revision_deadline' => $input->revision_deadline, 'revision_start_date' => $input->revision_start_date, 'revision_end_date' => $input->revision_end_date];
        $insert = $this->draft->where('revision_id', $input->revision_id)->update($data, 'revision');
        if ($insert) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        echo json_encode($data);
    }

    public function endProgress($id, $status)
    {
        $this->draft->update_draft_status($id, array('draft_status' => $status + 1));
        switch ($status) {
            case '4':
                $column = 'review_end_date';
                break;
            default:
                # code...

                break;
        }
        $this->draft->edit_draft_date($id, $column);
        $this->detail($id);
    }
    public function generate_worksheet_number()
    {
        $date = date('Y-m');
        $this->db->limit(1);
        $query = $this->draft->like('worksheet_num', $date, 'after')->order_by('draft_id', 'desc')->get('worksheet');
        if ($query) {
            $worksheet_num = $query->worksheet_num;
            $worksheet_num = explode("-", $worksheet_num);
            $num           = (int) $worksheet_num[2];
            $num++;
            $num = str_pad($num, 2, '0', STR_PAD_LEFT);
        } else {
            $num = '01';
        }
        return $date . '-' . $num;
    }
    private function getDraftAuthorStatus($author_id, $draft_id)
    {
        $data   = array('author_id' => $author_id, 'draft_id' => $draft_id);
        $result = $this->draft->get_where($data, 'draft_author');
        if ($result) {
            $draft_author_status = $result->draft_author_status;
        } else {
            $draft_author_status = -1;
        }
        return $draft_author_status;
    }

    public function checkStatus($code)
    {
        $status = "";
        switch ($code) {
            case 0:
                $status = 'Desk Screening';
                break;
            case 1:
                $status = 'Lolos Desk Screening';
                break;
            case 2:
                $status = 'Tidak Lolos Desk Screening';
                break;
            case 3:
                $status = 'Review Ditolak';
                break;
            case 4:
                $status = 'Reviewing';
                break;
            case 5:
                $status = 'Antri Edit';
                break;
            case 6:
                $status = 'Editing';
                break;
            case 7:
                $status = 'Editorial Selesai';
                break;
            case 8:
                $status = 'Layouting';
                break;
            case 9:
                $status = 'Layout selesai';
                break;
            case 10:
                $status = 'Desain Cover';
                break;
            case 11:
                $status = 'Cover Selesai';
                break;
            case 12:
                $status = 'Proofreading';
                break;
            case 13:
                $status = 'Proofread Selesai';
                break;
            case 14:
                $status = 'Final';
                break;
            case 15:
                $status = 'Cetak';
                break;
            case 16:
                $status = 'Cetak Selesai';
                break;
            case 17:
                $status = 'Revisi Edit';
                break;
            case 18:
                $status = 'Revisi Layout';
                break;
            case 19:
                $status = 'Selesai Revisi';
                break;
            case 99:
                $status = 'Draft Ditolak';
                break;
            default:
                # code...

                break;
        }
        return $status;
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

    public function unique_data($str, $data_key)
    {
        $draft_id = $this->input->post('draft_id');
        if (!$str) {
            return true;
        }
        $this->draft->where($data_key, $str);
        !$draft_id || $this->draft->where_not('draft_id', $draft_id);
        $draft = $this->draft->get();
        if ($draft) {
            $this->form_validation->set_message('unique_data', $this->lang->line('toast_data_duplicate'));
            return false;
        }
        return true;
    }

    public function valid_url($str)
    {
        if (!$str) {
            return true;
        }
        return (bool) filter_var($str, FILTER_VALIDATE_URL);
    }

    private function _generate_draft_file_name($draft_file_name, $draft_title)
    {
        $get_extension = explode(".", $draft_file_name)[1];
        return str_replace(" ", "_", $draft_title . '_' . date('YmdHis') . '.' . $get_extension); // draft file name
    }
}