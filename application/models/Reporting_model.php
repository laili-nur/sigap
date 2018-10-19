<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporting_model extends MY_Model{

  public function __construct()
  {
    parent::__construct();
  }

  /*Model for fetching data to the table*/

  public function fetch_data()
  {
    $query = $this->db->query("SELECT * FROM draft ORDER BY entry_date ASC");
    return $query->result();
  }

  public function fetch_data_draft()
  {
    $query = $this->db->query("SELECT * FROM draft ORDER BY entry_date DESC LIMIT 5");
    return $query->result();
  }

  public function fetch_data_book()
  {
    $query = $this->db->query("SELECT * FROM book ORDER BY published_date DESC LIMIT 5");
    return $query->result();
  }

  public function fetch_data_author()
  {
    $query = $this->db->query("SELECT * FROM author ORDER BY author_id DESC LIMIT 10");
    return $query->result();
  }

  public function fetch_performa_editor()
  {
    $query = $this->db->query("SELECT * FROM draft ORDER BY edit_start_date DESC LIMIT 5");
    return $query->result();
  }

  public function fetch_performa_layouter()
  {
    $this->db->select('*');
    $this->db->from('draft');
    $query = $this->db->get();
    return $query->result();
  }

  /*model for graph*/

  public function getDraft($month)
  {
    $query = $this->db->query("SELECT draft_id, draft_title, entry_date FROM draft WHERE Month(entry_date) = $month");
    return $query->result();
  }

  public function getBook($month)
  {
    $query = $this->db->query("SELECT book_id, book_title, published_date FROM book WHERE Month(published_date) = $month");
    return $query->result();
  }

  public function getAuthor($month)
  {
    $query = $this->db->query("SELECT author_id, author_name, author_email FROM author ");
    return $query->result();
  }

  /*Model for API*/

  public function apiDraft($draft_id = NULL)
  {
    if($draft_id == FALSE){
			$result = $this->db->select('draft_id, category_id, theme_id, draft_title, entry_date, finish_date, review_start_date, review_end_date, draft_status')->get('draft')->result();
		} else{
			$this->db->select('draft_id, category_id, theme_id, draft_title, entry_date, finish_date, review_start_date, review_end_date, draft_status')->where('draft_id', $draft_id);
			$result = $this->db->get('draft')->result();
		}
    return $result;
  }

  public function apiBook($book_id = NULL)
  {
    if($book_id == FALSE){
			$result = $this->db->select('book_id, draft_id, book_code, book_title, isbn, published_date, serial_num')->get('book')->result();
		} else{
			$this->db->select('book_id, draft_id, book_code, book_title, isbn, published_date, serial_num')->where('book_id', $book_id);
			$result = $this->db->get('book')->result();
		}
    return $result;
  }

  public function apiAuthor($author_id = NULL)
  {
    if($author_id == FALSE){
      $result = $this->db->select('author_id, work_unit_id, author_name, author_nip, author_latest_education, author_address, author_contact, author_email, author_saving_num, heir_name')->get('author')->result();
    } else{
      $this->db->select('author_id, work_unit_id, author_name, author_nip, author_latest_education, author_address, author_contact, author_email, author_saving_num, heir_name')->where('author_id', $author_id);
      $result = $this->db->get('author')->result();
    }
    return $result;
  }
}
