<?php

namespace App\Controllers;

class Payment extends Security_Controller {

  // Payment
  function index() {
      if($this->login_user->is_admin) {
        $view_data['paymentList_All'] = $this->Payment_model->get_payment()->orderBy('id_payment', 'DESC')->where('is_deleted = "0" AND is_group = "0"')->get()->getResultArray();
        $view_data['quotationList'] = $this->Payment_model->get_quotation()->get()->getResultArray();
        $view_data['paymentList_Pending'] = $this->Payment_model->get_payment()->orderBy('id_payment', 'DESC')->where('is_deleted = "0" AND aa_lodger_payment_status.status = "1" OR is_deleted = "0" AND aa_lodger_payment_status.status = '.NULL.'')->get()->getResultArray();
        $view_data['paymentList_Paid'] = $this->Payment_model->get_payment()->orderBy('id_payment', 'DESC')->where('aa_lodger_payment_status.status = "2" AND is_deleted = "0" AND is_group = "0"')->get()->getResultArray();
        $view_data['paymentList_Trash'] = $this->Payment_model->get_payment()->orderBy('id_payment', 'DESC')->where('is_deleted = "1" AND is_group = "0"')->get()->getResultArray();
        $view_data['countPayment_Pending'] = $this->Payment_model->count_payment()->where('is_deleted = "0" AND aa_lodger_payment_status.status = "1" AND is_group = "0" OR is_deleted = "0" AND is_group = "0" AND aa_lodger_payment_status.status = '.NULL.' ')->get()->getResultArray();
        $view_data['countPayment_Paid'] = $this->Payment_model->get_payment()->where('aa_lodger_payment_status.status = "2" AND is_deleted = "0" AND is_group = "0"')->get()->getResultArray();
        $view_data['countPayment_Invalid'] = $this->Payment_model->get_payment()->where('aa_lodger_payment_status.status = "3" AND is_deleted = "0" AND is_group = "0"')->get()->getResultArray();
        return $this->template->rander("payment/admin/index", $view_data);
      } else {
        $view_data['paymentList_All'] = $this->Payment_model->get_payment()->orderBy('id_payment', 'DESC')->where('is_deleted = "0" AND aa_lodger_payment.user_id = "'.$this->login_user->id.'"')->get()->getResultArray();
        $view_data['paymentList_Pending'] = $this->Payment_model->get_payment()->orderBy('id_payment', 'DESC')->where('is_deleted = "0" AND aa_lodger_payment_status.status = "1" AND aa_lodger_payment.user_id = "'.$this->login_user->id.'" OR is_deleted = "0" AND aa_lodger_payment.user_id = "'.$this->login_user->id.'" AND aa_lodger_payment_status.status = '.NULL.'')->get()->getResultArray();
        $view_data['paymentList_Paid'] = $this->Payment_model->get_payment()->orderBy('id_payment', 'DESC')->where('is_deleted = "0" AND aa_lodger_payment_status.status = "2" AND aa_lodger_payment.user_id = "'.$this->login_user->id.'"')->get()->getResultArray();
        return $this->template->rander("payment/index", $view_data);
      }
  }
  
  function export_excel(){
    if($this->request->getPost()){
      $min = $this->request->getPost('export-by-date-min');
      $max = $this->request->getPost('export-by-date-max');
      $condition = $this->request->getPost('export-by-condition') ?? '';
      if(isset($min) && isset($max)){
        if($condition == '1'){
          $view_data['PaymentExport'] = $this->Payment_model->get_payment()->where('(aa_lodger_payment.created_at BETWEEN "'.$min.'" AND "'.$max.'") AND (aa_lodger_payment_status.status = "1" OR aa_lodger_payment_status.status = NULL) AND aa_lodger_payment.is_deleted = "0"')->get()->getResultArray();
          $view_data['saveAs'] = ['max' => $max, 'min' => $min, 'status' => 'Pending'];
        } else if($condition == '2'){
          $view_data['PaymentExport'] = $this->Payment_model->get_payment()->where('(aa_lodger_payment.created_at BETWEEN "'.$min.'" AND "'.$max.'") AND aa_lodger_payment_status.status = "2" AND aa_lodger_payment.is_deleted = "0"')->get()->getResultArray();
          $view_data['saveAs'] = ['max' => $max, 'min' => $min, 'status' => 'Paid'];
        } else if($condition == '3'){
          $view_data['PaymentExport'] = $this->Payment_model->get_payment()->where('(aa_lodger_payment.created_at BETWEEN "'.$min.'" AND "'.$max.'") AND aa_lodger_payment_status.status = "3" AND aa_lodger_payment.is_deleted = "0"')->get()->getResultArray();
          $view_data['saveAs'] = ['max' => $max, 'min' => $min, 'status' => 'Invalid'];
        } else {
          $view_data['PaymentExport'] = $this->Payment_model->get_payment()->where('(aa_lodger_payment.created_at BETWEEN "'.$min.'" AND "'.$max.'") AND aa_lodger_payment.is_deleted = "0"')->get()->getResultArray();
          $view_data['saveAs'] = ['max' => $max, 'min' => $min, 'status' => 'All'];
        }
      } else {
        $view_data['PaymentExport'] = $this->Payment_model->get_payment()->where('aa_lodger_payment.id_payment', $this->request->getPost('id-payment'))->get()->getResultArray();
      }
      return view('payment/admin/export_excel', $view_data);
    } else {
      echo 'Oops...';
    }
  }

  function export_excel_quotation(){
    if($this->request->getPost()){
      $view_data['QuotationExport'] = $this->Payment_model->get_quotation_single()->where('quotation_id', $this->request->getPost('id-quotation'))->get()->getResultArray();
      $view_data['QuotationName'] = $this->Payment_model->get_quotation()->where('id_quotation', $this->request->getPost('id-quotation'))->get()->getResultArray();
      return view('payment/admin/export_excel_quotation', $view_data);
    } else {
      echo 'Oops...';
    }
  }

  function create() {
    $files = $this->request->getFiles('payment-attachment');
    if($this->request->getPost()){
      $due = explode('/', $this->request->getPost('payment-due-date'));
      $shooting = explode('/', $this->request->getPost('payment-shooting-date'));
      if ($files['payment-attachment']->getName() != '') {
        $files['payment-attachment']->move(ROOTPATH.'files/payment/applicant');
        $data['attachment'] = ['attachment_file' => $files['payment-attachment']->getName()];
        $data = [
          'user_id' => $this->login_user->id,
          'payment_name' => htmlentities($this->request->getPost('payment-name')),
          'payment_project_name' => htmlentities($this->request->getPost('payment-project-name')),
          'payment_shooting_date' => $shooting[2].'-'.$shooting[1].'-'.$shooting[0],
          'payment_attachment' => $data['attachment'] ?? NULL,
          'payment_notes' => htmlentities($this->request->getPost('payment-notes')) ?? NULL,
          'payment_bill' => htmlentities($this->request->getPost('payment-bill')),
          'payment_due_date' => $due[2].'-'.$due[1].'-'.$due[0],
          'bank_id' => htmlentities($this->request->getPost('payment-transfer-to')),
        ];
        $this->Payment_model->insert_payment($data);
        return redirect()->to(base_url('index.php/payment'));
      } else {
        $data = [
          'user_id' => $this->login_user->id,
          'payment_name' => htmlentities($this->request->getPost('payment-name')),
          'payment_project_name' => htmlentities($this->request->getPost('payment-project-name')),
          'payment_shooting_date' => $shooting[2].'-'.$shooting[1].'-'.$shooting[0],
          'payment_notes' => htmlentities($this->request->getPost('payment-notes')) ?? NULL,
          'payment_bill' => htmlentities($this->request->getPost('payment-bill')),
          'payment_due_date' => $due[2].'-'.$due[1].'-'.$due[0],
          'bank_id' => htmlentities($this->request->getPost('payment-transfer-to')),
        ];
        $this->Payment_model->insert_payment($data);
        return redirect()->to(base_url('index.php/payment'));
      }
    } else {
      $data = [
        'user_id' => $this->login_user->id,
        'payment_name' => htmlentities($this->request->getPost('payment-name')),
        'payment_project_name' => htmlentities($this->request->getPost('payment-project-name')),
        'payment_shooting_date' => $shooting[2].'-'.$shooting[1].'-'.$shooting[0],
        'payment_notes' => htmlentities($this->request->getPost('payment-notes')),
        'payment_bill' => htmlentities($this->request->getPost('payment-bill')),
        'payment_due_date' => $due[2].'-'.$due[1].'-'.$due[0],
        'bank_id' => htmlentities($this->request->getPost('payment-transfer-to')),
      ];
      $this->Payment_model->insert_payment($data);
    }
  }

  function update_status(){
    $files = $this->request->getFiles('attachment');
    $check_status = $this->Payment_model->get_status(['payment_id' => $this->request->getPost('paymentid')])->getRowArray();
    if($check_status) {
      $data['status'] = [
          'payment_id' => $this->request->getPost('paymentid'),
          'status_update_by' => $this->login_user->id,
          'status' => $this->request->getPost('payment-status'),
          'message' => htmlentities($this->request->getPost('payment-message')),
      ];
      $this->Payment_model->update_status($data['status'], $check_status['id_status']);

      if ($files['attachment']->getName() != '') {
        if($this->Payment_model->get_attachment(['status_id' => $check_status['id_status']])->getRowArray()){
          $files['attachment']->move(ROOTPATH.'files/payment');
          $data['attachment'] = [
            'attachment_file' => $files['attachment']->getName()
          ];
          $this->Payment_model->update_attachment($data['attachment'], $check_status['id_status']);
        } else {
          $files['attachment']->move(ROOTPATH.'files/payment');
          $data['attachment'] = [
            'status_id' => $check_status['id_status'],
            'attachment_file' => $files['attachment']->getName()
          ];
          $this->Payment_model->insert_attachment($data['attachment']);
        }
      }
    } else {
      $data['status'] = [
          'payment_id' => $this->request->getPost('paymentid'),
          'status_update_by' => $this->login_user->id,
          'status' => $this->request->getPost('payment-status'),
          'message' => htmlentities($this->request->getPost('payment-message')),
          'transfered_at' => date('Y:m:d')
      ];
      $this->Payment_model->insert_status($data['status']);

      if ($files['attachment']->getName() != '') {
        $files['attachment']->move(ROOTPATH.'files/payment');
        $data['attachment'] = [
          'status_id' => $this->Payment_model->insertID(),
          'attachment_file' => $files['attachment']->getName()
        ];
        $this->Payment_model->insert_attachment($data['attachment']);
      }
    }
    return redirect()->to(base_url('index.php/payment'));
  }


  // Bank
  function bank($params = NULL){
    if($params == 'create') {
      if($this->request->getPost()){
        $data = [
          'bank_name' => htmlentities(strtoupper($this->request->getPost('bank-name'))),
          'bank_number' => htmlentities($this->request->getPost('bank-number')),
          'bank_receiver' => htmlentities(strtoupper($this->request->getPost('bank-receiver'))),
          'added_by' => $this->login_user->id,
        ];
        $this->Payment_model->insert_bank($data);
        return redirect()->to(base_url('index.php/payment'));
      } else {
          echo 'Oops...';
      }
    } else if($params == 'update') {
      echo 'Update';
    } else if($params == 'delete') {
      echo 'Delete';
    } else {
      return redirect()->to(base_url('index.php/payment'));
    }
  }


  // Ajax Read
  function get_payment_ajax(){
    if($this->login_user->is_admin || $this->login_user->user_type == "staff" ){
      echo json_encode($this->Payment_model->get_payment()->getWhere(['id_payment' => $_POST['id_payment']])->getResultArray()[0]);
    } else {
      echo 'Oops...';
    }
  }

  function delete_payment_ajax(){
    if($this->login_user->is_admin){
      echo json_encode($this->Payment_model->remove_payment(['id_payment' => $_POST['id_payment']])[0]);
    } else {
      echo 'Oops...';
    }
  }

  function get_bank_ajax(){
    if($this->login_user->is_admin || $this->login_user->user_type == "staff" ){
      $result = $this->Payment_model->get_bank()->where('added_by', $this->login_user->id)->get()->getResultArray();
      echo json_encode($result);
    } else {
      echo 'Oops...';
    }
  }

  function get_quotation_ajax(){
    if($this->login_user->is_admin || $this->login_user->user_type == "staff" ){
      echo json_encode($this->Payment_model->get_quotation_single()->where('quotation_id', $_POST['id_quotation'])->get()->getResultArray());
    } else {
      echo 'Oops...';
    }
  }

  function get_group_ajax(){
    if($this->login_user->is_admin || $this->login_user->user_type == 'staff') {
      $result = $this->Payment_model->get_group()->getResultArray();
      echo json_encode($result);
    } else {
      echo 'Oops...';
    }
  }

  
  // quotation
  function add_to_quotation(){
    if($this->request->getPost('quotation-name')) {
      $quotation_name = ['quotation_name' => htmlentities(strtoupper($this->request->getPost('quotation-name')))];
      $quotation = $this->Payment_model;
      $quotation->insert_quotation($quotation_name);
      $idQuotation = $quotation->insertID();
      for ($i=0; $i < count($this->request->getPost('id_payment')); $i++) { 
        $quotation_group = [
          'quotation_id' => $idQuotation,
          'payment_id' => $this->request->getPost('id_payment')[$i]
        ];

        $this->Payment_model->insert_quotation_group($quotation_group);
        $this->Payment_model->is_group_quotation($this->request->getPost('id_payment')[$i]);
      }
      return redirect()->to(base_url('index.php/payment'));
    } else {
      echo 'Oops...';
    }
  }
}