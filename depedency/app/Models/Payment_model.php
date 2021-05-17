<?php

namespace App\Models;

class Payment_model extends Crud_model {

  protected $table = null;
  protected $db_builder = null;
  protected $allowedFields = array();

  function __construct() {
    $this->db = db_connect('default');
  }

  function count_payment(){
    $payment_table = $this->db->prefixTable('aa_lodger_payment');
    $status_table = $this->db->prefixTable('aa_lodger_payment_status');
    $sql = $this->db->table('aa_lodger_payment')->select($payment_table.'.id_payment, '.$payment_table.'.payment_bill, ')
    ->join($status_table, $status_table.'.payment_id = '.$payment_table.'.id_payment', 'left');
    return $sql;
  }

  function get_payment($args = []) {
    $payment_table = $this->db->prefixTable('aa_lodger_payment');
    $bank_table = $this->db->prefixTable('aa_lodger_payment_bank');
    $group_table = $this->db->prefixTable('aa_lodger_payment_quotation_group');
    $status_table = $this->db->prefixTable('aa_lodger_payment_status');
    $attachment_table = $this->db->prefixTable('aa_lodger_payment_attachment');
    $user_table = $this->db->prefixTable('users');

    $sql = $this->db->table($payment_table)->select($payment_table.'.id_payment, '.$payment_table.'.user_id, '.$payment_table.'.payment_name, '.$payment_table.'.payment_bill, '.$payment_table.'.payment_due_date, '.$payment_table.'.payment_due_time, '.$payment_table.'.payment_attachment, '.$payment_table.'.payment_notes, '.$payment_table.'.bank_id, '.$payment_table.'.payment_project_name, '.$payment_table.'.created_at, '.$payment_table.'.payment_shooting_date, '.$attachment_table.'.status_id, '.$attachment_table.'.attachment_file, '.$bank_table.'.bank_name, '.$bank_table.'.bank_number, '.$bank_table.'.bank_receiver, '.$status_table.'.status_update_by, '.$status_table.'.status, '.$status_table.'.transfered_at, '.$status_table.'.message, '.$user_table.'.first_name, '.$user_table.'.last_name')
    ->join($user_table, $user_table.'.id = '.$payment_table.'.user_id', 'left')
    ->join($bank_table, $bank_table.'.id_bank = '.$payment_table.'.bank_id', 'left')
    ->join($status_table, $status_table.'.payment_id = '.$payment_table.'.id_payment', 'left')
    ->join($attachment_table, $attachment_table.'.status_id = '.$status_table.'.id_status', 'left');
    return $sql;
  }

  function insert_payment($data){
    $this->db->table('aa_lodger_payment')->insert($data);
  }

  function remove_payment($args) {
    $this->db->table('aa_lodger_payment')->update(['is_deleted' => 1], $args);
  }



  // Status
  function update_status($data, $id) {
    $this->db->table('aa_lodger_payment_status')->update($data, ['id_status' => $id]);
  }

  function insert_status($data){
    $this->db->table('aa_lodger_payment_status')->insert($data);
  }

  function get_status($args = []){
    return $this->db->table('aa_lodger_payment_status')->getWhere($args);
  }



  // Attachment
  function insert_attachment($data){
    $this->db->table('aa_lodger_payment_attachment')->insert($data);
  }

  function update_attachment($data, $id){
    $this->db->table('aa_lodger_payment_attachment')->update($data, ['status_id' => $id]);
  }

  function get_attachment($args = []){
    return $this->db->table('aa_lodger_payment_attachment')->getWhere($args);
  }



  // Bank
  function get_bank(){
    return $this->db->table('aa_lodger_payment_bank');
  }

  function insert_bank($data){
    $this->db->table('aa_lodger_payment_bank')->insert($data);
  }

  function remove_bank($args) {
    $this->db->table('aa_lodger_payment_bank')->delete($args);
  }


  // Quotation
  function get_quotation(){
    $payment_table = $this->db->prefixTable('aa_lodger_payment');
    $group_table = $this->db->prefixTable('aa_lodger_payment_quotation_group');
    $quotation = $this->db->prefixTable('aa_lodger_payment_quotation');

    $sql = $this->db->table($quotation)->select($quotation.'.id_quotation, '.$quotation.'.quotation_name, '.$quotation.'.created_at');
    return $sql;
  }

  function get_quotation_single(){
    $payment_table = $this->db->prefixTable('aa_lodger_payment');
    $group_table = $this->db->prefixTable('aa_lodger_payment_quotation_group');
    $quotation = $this->db->prefixTable('aa_lodger_payment_quotation');
    $status_table = $this->db->prefixTable('aa_lodger_payment_status');

    $sql = $this->db->table($quotation)->select($quotation.'.id_quotation, '.$quotation.'.quotation_name, '.$quotation.'.created_at, '.$group_table.'.quotation_id, '.$group_table.'.payment_id, '.$payment_table.'.id_payment, '.$payment_table.'.payment_name, '.$payment_table.'.payment_bill, '.$payment_table.'.payment_project_name, '.$payment_table.'.payment_shooting_date, '.$status_table.'.transfered_at')
    ->join($group_table, $group_table.'.quotation_id = '.$quotation.'.id_quotation', 'left')
    ->join($payment_table, $payment_table.'.id_payment = '.$group_table.'.payment_id', 'left')
    ->join($status_table, $status_table.'.payment_id = '.$payment_table.'.id_payment', 'left');
    return $sql;
  }

  function insert_quotation($data){
    $this->db->table('aa_lodger_payment_quotation')->insert($data);
  }

  function insert_quotation_group($data){
    $this->db->table('aa_lodger_payment_quotation_group')->insert($data);
  }

  function is_group_quotation($id){
    $this->db->table('aa_lodger_payment')->update(['is_group' => 1], ['id_payment' => $id]);
  }
}