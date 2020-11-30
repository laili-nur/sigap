<?php

function lihatEkstensi($ext = '')
{
    if (!empty($ext)) {
        $getextension = explode(".", $ext);
        return strtolower($getextension[1]);
    } else {
        return false;
    }
}

function getYearsDocument()
{
    $tahun        = array();
    $CI           = &get_instance();
    $filtertahun  = $CI->db->from('document')->group_by('document_year')->get();
    $filtertahunz = $filtertahun->result();
    foreach ($filtertahunz as $key => $value) {
        $tahun[$value->document_year] = $value->document_year;
    }
    $tahun[''] = '';
    return ($tahun);
}

function getYears()
{
    $tahun        = array();
    $CI           = &get_instance();
    $filtertahun  = $CI->db->from('draft')->group_by('YEAR(entry_date)')->order_by('entry_date', 'DESC')->get();
    $filtertahunz = $filtertahun->result();
    foreach ($filtertahunz as $key => $value) {
        $tahun[date('Y', strtotime($value->entry_date))] = date('Y', strtotime($value->entry_date));
    }
    return ($tahun);
}

function getYearsBook()
{
    $tahun        = array();
    $CI           = &get_instance();
    $filtertahun  = $CI->db->from('book')->group_by('YEAR(published_date)')->order_by('published_date', 'DESC')->get();
    $filtertahunz = $filtertahun->result();
    foreach ($filtertahunz as $key => $value) {
        $tahun[date('Y', strtotime($value->published_date))] = date('Y', strtotime($value->published_date));
    }
    return ($tahun);
}

function getYearsSummary()
{
    $tahun = array();
    //$filtertahun = $this->reporting->group_by('YEAR(entry_date)')->get_all_array('draft');
    $CI           = &get_instance();
    $filtertahun  = $CI->db->from('draft')->group_by('YEAR(entry_date)')->order_by('entry_date', 'DESC')->get();
    $filtertahunz = $filtertahun->result();
    foreach ($filtertahunz as $key => $value) {
        $tahun[date('Y', strtotime($value->entry_date))] = date('Y', strtotime($value->entry_date));
    }
    return ($tahun);
}

function getYearsHibah()
{
    $tahun        = array();
    $CI           = &get_instance();
    $filtertahun  = $CI->db->from('draft')->group_by('YEAR(entry_date)')->order_by('entry_date', 'DESC')->get();
    $filtertahunz = $filtertahun->result();
    foreach ($filtertahunz as $key => $value) {
        $tahun[date('Y', strtotime($value->entry_date))] = date('Y', strtotime($value->entry_date));
    }
    return ($tahun);
}

function konversi_username_level($username)
{
    if ($username == '' || $username == null) {
        return "-";
    } else {
        $CI    = &get_instance();
        $query = $CI->db->from('user')->where('username', $username)->get();
        if (!$query) {
            return "-";
        } else {
            if (isset($query->row()->level)) {
                return $query->row()->level;
            } else {
                return "-";
            }
        }
    }
}

function is_datetime_null($datetime)
{
    if ($datetime == '' || $datetime == null || $datetime == '0000-00-00 00:00:00') {
        return null;
    }
    return $datetime;
}

function format_datetime($input = null, $opsi = '')
{
    if ($input == null || $input == '0000-00-00 00:00:00') {
        return null;
    }

    if ($opsi == 'dateonly') {
        return date("d/m/Y", strtotime($input));
    } else {
        return date("d/m/Y H:i:s", strtotime($input));
    }
}

//konversi date ke format tahun
function konversiTahun($input = null)
{
    if ($input == null || $input == '0000-00-00') {
        return "-";
    }
    $timeStamp        = $input;
    return $timeStamp = date("Y", strtotime($timeStamp));
}

// konversi id ke nama
function konversiID($table, $vars, $id)
{
    if ($id == '') {
        return "";
    } else {
        $CI    = &get_instance();
        $query = $CI->db->from($table)->where($vars, $id)->get();
        if ($query) {
            return $query->row();
        } else {
            return "";
        }
    }
}

/**
 * Membuat array buku
 *
 * @return array
 */
function get_dropdown_list_book()
{
    $condition = function () {
        $CI = &get_instance();
        $CI->db->order_by('book_title', 'asc');
        return $CI;
    };

    return get_dropdown_list('book', ['book_id', 'book_title'], $condition);
}

/**
 * Membuat array draft yang final (draft_status = 14)
 *
 * @return array
 */
function get_dropdown_list_draft_final()
{
    $condition = function () {
        $CI = &get_instance();
        $CI->db->where('draft_status', 14);
        $CI->db->order_by('draft_title', 'asc');
        return $CI;
    };

    return get_dropdown_list('draft', ['draft_id', 'draft_title'], $condition);
}

// Get list of editor
function get_dropdown_listReviewer($table, $columns)
{
    $CI = &get_instance();
    if (isset($_SESSION['user_id_temp'])) {
        $query = $CI->db->select($columns)->where('user_id', $_SESSION['user_id_temp'])->or_where('level', 'reviewer')->or_where('level', 'author_reviewer')->from($table)->get();
    } else {
        $query = $CI->db->select($columns)->where('level', 'reviewer')->or_where('level', 'author_reviewer')->from($table)->get();
    }

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Pilih --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of editor
function get_dropdown_listEditor($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->where('level', 'editor')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Pilih --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of layouter
function get_dropdown_listLayouter($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->where('level', 'layouter')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Pilih --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

/**
 * Membuat array category
 *
 * @param boolean $all_categories
 * @return array
 */
function get_dropdown_list_category($all_categories = true)
{
    $condition = function () use ($all_categories) {
        $CI = &get_instance();
        if (!$all_categories) {
            $CI->db->where('category_status', 'y');
        }
        $CI->db->order_by('category_name', 'asc');
        return $CI;
    };

    return get_dropdown_list('category', ['category_id', 'category_name'], $condition);
}

/**
 * Membuat array user
 *
 * @return array
 */
function get_dropdown_list_user()
{
    $condition = function () {
        $CI = &get_instance();
        $CI->db->where('level', 'author');
        $CI->db->or_where('level', 'author');
        $CI->db->order_by('username', 'asc');
        return $CI;
    };

    return get_dropdown_list('user', ['user_id', 'username'], $condition);
}

/**
 * Membuat array untuk dropdown
 * Bisa diextend menggunakan condition
 *
 * @param string $table
 * @param array $columns
 * @param callable $condition
 * @return array
 */
function get_dropdown_list(string $table, array $columns, callable $condition = null)
{
    $CI = &get_instance();
    $CI->db->select($columns);
    $CI->db->from($table);
    if ($condition) {
        call_user_func($condition);
    }
    $query = $CI->db->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Pilih --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Kosong -'];
}

// Get list of option for dropdown untuk multi kolom
function get_dropdown_list_multi_column($table, $columns)
{
    $tables = array();
    for ($i = 0; $i < count($columns); $i++) {
        $column = explode('_', $columns[$i]);
        if (count($column) > 2) {
            $column[0] = $column[0] . '_' . $column[1];
        }
        if (!array_key_exists($column[0], $tables)) {
            $tables[$column[0]] = array($columns[$i]);
        } else {
            array_push($tables[$column[0]], $columns[$i]);
        }
    }

    $CI = &get_instance();

    foreach ($tables as $key => $val) {
        if ($key == $table) {
            $query = $CI->db->get($key);
        }
    }
    if ($query->num_rows() >= 1) {
        $result   = $query->result_array();
        $options1 = ['' => '-- Pilih --'];
        $options2 = array_column($result, $columns[1], $columns[0]);
        if (count($columns) > 2) {
            $j = 0;
            foreach ($options2 as $key => $value) {
                for ($i = 2; $i < count($columns); $i++) {
                    foreach ($tables as $key1 => $val1) {
                        if ($key1 != $table) {
                            $table_rel = explode('_', $columns[$i]);
                            if (count($table_rel) > 2) {
                                $table_rel[0] = $table_rel[0] . '_' . $table_rel[1];
                            }
                            $table_rel = $table_rel[0];
                            if ($table_rel == $key1) {
                                $query2  = $CI->db->select($val1)->where($table_rel . '_id', $result[$j][$table_rel . '_id'])->from($key1)->get();
                                $result2 = $query2->result_array();
                                $value2  = '';
                                if (count($result2) > 0) {
                                    foreach ($result2 as $key2) {
                                        $value2 .= ' - ';
                                        $value2 .= $result[$j][$columns[$i]] = $key2[$columns[$i]];
                                    }
                                }
                            }
                        }
                    }
                    $value .= $value2;
                    $options2[$key] = $value;
                }
                $j++;
            }
        }
        $options = $options1 + $options2;
        return $options;
    }
    return $options = ['' => '- Empty -'];
}

function getDropdownBankList($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->from($table)->order_by("bank_name", "asc")->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '- Pilih -'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Pilih -'];
}

// Show form error validation message for "file" input.
function file_form_error($field, $prefix = '', $suffix = '')
{
    $CI          = &get_instance();
    $error_field = $CI->form_validation->error_array();

    if (!empty($error_field[$field])) {
        return $prefix . $error_field[$field] . $suffix;
    }
    return '';
}

function highlight_keyword($str, $search)
{
    if (!$search) {
        return $str;
    }

    $highlightcolor = "red";
    $occurrences    = substr_count(strtolower($str), strtolower($search));
    $newstring      = $str;
    $match          = array();

    for ($i = 0; $i < $occurrences; $i++) {
        $match[$i] = stripos($str, $search, $i);
        $match[$i] = substr($str, $match[$i], strlen($search));
        $newstring = str_replace($match[$i], '[#]' . $match[$i] . '[@]', strip_tags($newstring));
    }

    $newstring = str_replace('[#]', '<span style="color: ' . $highlightcolor . ';">', $newstring);
    $newstring = str_replace('[@]', '</span>', $newstring);
    return $newstring;
}

function check_file_extension($file_name)
{
    if ($file_name) {
        return pathinfo($file_name)['extension'];
    } else {
        return null;
    }
}

// memaksa variabel kosong agar disimpan sebagai 'null'
function empty_to_null($v = '')
{
    return empty($v) ? null : $v;
}

function get_allowed_file_types($field_name = null)
{
    // default
    $types = 'docx|doc|pdf|zip|rar';

    if ($field_name == 'draft_file') {
        $types = 'docx|doc|pdf|zip|rar';
    }
    if ($field_name == 'book_file') {
        $types = 'docx|doc|pdf|zip|rar';
    }

    if ($field_name == 'hakcipta_file') {
        $types = 'docx|doc|pdf|zip|rar|jpg|jpeg|png';
    }

    if ($field_name == 'document_file') {
        $types = 'txt|docx|doc|pdf|jpeg|jpg|png|xls|xlsx|zip|rar';
    }

    if ($field_name == 'preprint_file') {
        $types = 'docx|doc|pdf|zip|rar';
    }

    if ($field_name == 'print_order_file') {
        $types = 'docx|doc|pdf|zip|rar';
    }

    return [
        'types'   => $types,
        'to_text' => str_replace("|", ", ", $types),
    ];
}

function draft_status_to_text($code)
{
    // status 0,1,2 sama dengan status desk screening worksheet
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
            $status = 'Proses Review';
            break;
        case 5:
            $status = 'Review Selesai';
            break;
        case 6:
            $status = 'Proses Edit';
            break;
        case 7:
            $status = 'Editorial Selesai';
            break;
        case 8:
            $status = 'Proses Layout';
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
            $status = 'Proses Proofread';
            break;
        case 13:
            $status = 'Proofread Selesai';
            break;
        case 14:
            $status = 'Final';
            break;
            // case 15:
            //     $status = 'Proses Cetak';
            //     break;
            // case 16:
            //     $status = 'Cetak Selesai';
            //     break;
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
            $status = 'Error';
            break;
    }
    return $status;
}

function get_per_page_options()
{
    return [
        '10'  => '10',
        '25'  => '25',
        '50'  => '50',
        '100' => '100',
    ];
}

function get_user_levels()
{
    return ['superadmin', 'admin_penerbitan', 'author', 'reviewer', 'editor', 'layouter', 'author_reviewer', 'admin_percetakan', 'staff_percetakan', 'admin_gudang', 'admin_pemasaran', 'admin_keuangan'];
}

function filter_boolean($data)
{
    return filter_var($data, FILTER_VALIDATE_BOOLEAN);
}

function now()
{
    return date('Y-m-d H:i:s');
}

function get_published_date()
{
    $CI    = &get_instance();
    $query = $CI->db->select(['published_date'])->from('book')->order_by("published_date", "asc")->group_by('published_date')->get()->result_array();

    $published_years = [
        '' => 'Semua'
    ];

    foreach ($query as $k => $value) {
        if (!$value['published_date']) {
            continue;
        }
        $date = DateTime::createFromFormat("Y-m-d", $value['published_date']);
        $published_years[$date->format('Y')] = $date->format('Y');
    }

    return $published_years;
}

function expand($authors)
{
    $authors_list = '<ul class="p-0 m-0" style="list-style-type: none;">';
    foreach ($authors as $a) {
        $authors_list .= '<li>';
        $authors_list .= '<i class="fa fa-user fa-fw"></i> ';
        $authors_list .= $a->author_name;
        $authors_list .= '</li>';
    }
    $authors_list .= '</ul>';
    return $authors_list;
}

function get_print_order_category()
{
    return [
        '' => null,
        'new' => 'Cetak Baru',
        'revise' => 'Cetak Ulang Revisi',
        'reprint' => 'Cetak Ulang Non Revisi',
        'nonbook' => 'Cetak Non Buku',
        'outsideprint' => 'Cetak Di Luar',
        'from_outside' => 'Cetak Dari Luar'
    ];
}

function get_print_order_mode()
{
    return [
        'book' => 'Cetak Buku',
        'nonbook' => 'Cetak Non Buku',
        'outsideprint' => 'Cetak di Luar'
    ];
}

function get_print_order_status()
{
    return [
        'waiting' => 'Menunggu diproses',
        'preprint' => 'Proses pracetak',
        'preprint_approval' => 'Pracetak menunggu approval',
        'preprint_finish' => 'Pracetak selesai',
        'print' => 'Proses cetak',
        'print_approval' => 'Cetak menunggu approval',
        'print_finish' => 'Cetak selesai',
        'postprint' => 'Proses jilid',
        'postprint_approval' => 'Jilid menunggu approval',
        'postprint_finish' => 'Jilid selesai',
        'reject' => 'Ditolak',
        'finish' => 'Selesai',
    ];
}

function get_username($user_id)
{
    $CI     = &get_instance();
    return $CI->db->get_where('user', ['user_id' => $user_id])->row()->username;
}

function processing_time($date1, $date2)
{
    // Formulate the Difference between two dates
    $diff = abs($date2 - $date1);


    // To get the year divide the resultant date into
    // total seconds in a year (365*60*60*24)
    $years = floor($diff / (365 * 60 * 60 * 24));


    // To get the month, subtract it with years and
    // divide the resultant date into
    // total seconds in a month (30*60*60*24)
    $months = floor(($diff - $years * 365 * 60 * 60 * 24)
        / (30 * 60 * 60 * 24));


    // To get the day, subtract it with years and
    // months and divide the resultant date into
    // total seconds in a days (60*60*24)
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
        $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


    // To get the hour, subtract it with years,
    // months & seconds and divide the resultant
    // date into total seconds in a hours (60*60)
    $hours = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
        / (60 * 60));


    // To get the minutes, subtract it with years,
    // months, seconds and hours and divide the
    // resultant date into total seconds i.e. 60
    $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
        - $hours * 60 * 60) / 60);


    // To get the minutes, subtract it with years,
    // months, seconds, hours and minutes
    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
        - $hours * 60 * 60 - $minutes * 60));

    // Print the result
    if (empty($years) && empty($months) && empty($days) && empty($hours) && empty($minutes)) {
        return printf(
            "%d Detik",
            $seconds
        );
    } elseif (empty($years) && empty($months) && empty($days) && empty($hours)) {
        return printf(
            "%d Menit %d Detik",
            $minutes,
            $seconds
        );
    } elseif (empty($years) && empty($months) && empty($days)) {
        return printf(
            "%d Jam %d Menit %d Detik",
            $hours,
            $minutes,
            $seconds
        );
    } elseif (empty($years) && empty($months)) {
        return printf(
            "%d Hari %d Jam %d Menit %d Detik",
            $days,
            $hours,
            $minutes,
            $seconds
        );
    } elseif (empty($years)) {
        return printf(
            "%d Bulan %d Hari %d Jam %d Menit %d Detik",
            $months,
            $days,
            $hours,
            $minutes,
            $seconds
        );
    } else {
        return printf(
            "%d Tahun %d Bulan %d Hari %d Jam %d Menit %d Detik",
            $years,
            $months,
            $days,
            $hours,
            $minutes,
            $seconds
        );
    }
}

function deadline_color($deadline = null, $status)
{
    $now        = strtotime('now');
    $day3       = strtotime('+3 days');

    if (empty($deadline)) {
        return '-';
    } else {
        if ($status != 'finish') {
            if (strtotime($deadline) < $now) {
                return '<div class="text-danger">' . format_datetime($deadline) . '</div>';
            } else if (strtotime($deadline) <= $day3) {
                return '<div class="text-warning">' . format_datetime($deadline) . '</div>';
            } else {
                return '<div class="text-success">' . format_datetime($deadline) . '</div>';
            }
        } else {
            return format_datetime($deadline);
        }
    }
}

function deadline_detail($deadline = null, $status)
{
    $now        = strtotime('now');
    $day3       = strtotime('+3 days');

    if (empty($deadline)) {
        return '<span class="badge badge-info">Tidak ada deadline</span>';
    } else {
        if ($status != 'finish') {
            if ($deadline < $now) {
                return '<span class="badge badge-danger">Terlambat</span>';
            } else if ($deadline <= $day3) {
                return '<span class="badge badge-warning">Hampir Terlambat</span>';
            } else {
                return '<span class="badge badge-success">Belum Terlambat</span>';
            }
        } else {
            return '<span class="badge badge-secondary">Selesai</span>';
        }
    }
}

function get_theme($theme_id)
{
    $CI = &get_instance();
    return $CI->db->select('theme_name')->from('theme')->where('theme_id', $theme_id)->get()->row()->theme_name;
}

function get_print_order_finishing()
{
    return [
        '' => null,
        'inside' => 'Internal',
        'outside' => 'External',
        'partial' => 'Parsial'
    ];
}

function strip_disallowed_char($string)
{
    $bad = array_merge(
        array_map('chr', range(0, 31)),
        array("<", ">", ":", '"', "/", "\\", "|", "?", "*", "(", ")", "@", "&", "!", ";", ",")
    );
    $string = str_replace($bad, "_", $string);
    return $string;
}
