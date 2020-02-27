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

function konversiTanggal($input = null, $opsi = '')
{
    if ($input == null || $input == '0000-00-00 00:00:00') {
        return "-";
    }
    $timeStamp = $input;
    if (!$opsi) {
        return $timeStamp = date("d/m/Y H:i:s", strtotime($timeStamp));
    } elseif ($opsi == 'dateonly') {
        return $timeStamp = date("d/m/Y", strtotime($timeStamp));
    } else {}
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

// Get list of option for dropdown.
function getDropdownListBook($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->from($table)->where('draft_status', '14')->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of editor
function getDropdownListReviewer($table, $columns)
{
    $CI = &get_instance();
    if (isset($_SESSION['user_id_temp'])) {
        $query = $CI->db->select($columns)->where('user_id', $_SESSION['user_id_temp'])->or_where('level', 'reviewer')->or_where('level', 'author_reviewer')->from($table)->get();
    } else {
        $query = $CI->db->select($columns)->where('level', 'reviewer')->or_where('level', 'author_reviewer')->from($table)->get();
    }

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of editor
function getDropdownListAuthor($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->where('level', 'author')->or_where('level', 'author_reviewer')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of editor
function getDropdownListEditor($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->where('level', 'editor')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of layouter
function getDropdownListLayouter($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->where('level', 'layouter')->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Khusus untuk category, mengambil yang aktif saja
function getDropdownListCategory($table, $columns, $all = false)
{
    $CI = &get_instance();
    if ($all == true) {
        //ambil semua kategori
        $query = $CI->db->select($columns)->from($table)->order_by('category_name', 'asc')->get();
    } else {
        //ambil karegori yang aktif
        $query = $CI->db->select($columns)->from($table)->where('category_status', 'y')->get();
    }

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Semua --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of option for dropdown.
function getDropdownList($table, $columns)
{
    $CI    = &get_instance();
    $query = $CI->db->select($columns)->from($table)->get();

    if ($query->num_rows() >= 1) {
        $options1 = ['' => '-- Choose --'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Empty -'];
}

// Get list of option for dropdown with multi koolom
function getMoreDropdownList($table, $columns)
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
        $options1 = ['' => '-- Choose --'];
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
        $options1 = ['' => '- Choose -'];
        $options2 = array_column($query->result_array(), $columns[1], $columns[0]);
        $options  = $options1 + $options2;
        return $options;
    }

    return $options = ['' => '- Choose -'];
}

// Show form error validation message for "file" input.
function fileFormError($field, $prefix = '', $suffix = '')
{
    $CI          = &get_instance();
    $error_field = $CI->form_validation->error_array();

    if (!empty($error_field[$field])) {
        return $prefix . $error_field[$field] . $suffix;
    }
    return '';
}
