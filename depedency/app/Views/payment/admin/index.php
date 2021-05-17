<div id="page-content" class="page-wrapper clearfix">
  <div id="accumulation">
    <div class="row me-0">
      <div class="col-md-4 col-6 mb-3 pe-0">
        <div class="accumulation-outer bg-success p-3 rounded">
          <label class="m-0">PAID</label>
          <?php $pp = 0; foreach ($countPayment_Paid as $value) {
            $pp += $value['payment_bill'];
          } ?>
          <h2 class="m-0"><strong><?= 'IDR '.number_format($pp).',-' ?></strong></h2>
        </div>
      </div>
      <div class="col-md-4 col-6 mb-3 pe-0">
        <div class="accumulation-outer bg-warning p-3 rounded">
          <label class="m-0">PENDING</label>
          <?php $pp = 0; foreach ($countPayment_Pending as $value) {
            $pp += $value['payment_bill'];
          } ?>
          <h2 class="m-0"><strong><?= 'IDR '.number_format($pp).',-' ?></strong></h2>
        </div>
      </div>
      <div class="col-md-4 col-6 mb-3 pe-0">
        <div class="accumulation-outer bg-danger p-3 rounded">
          <label class="m-0">INVALID</label>
          <?php $pp = 0; foreach ($countPayment_Invalid as $value) {
            $pp += $value['payment_bill'];
          } ?>
          <h2 class="m-0"><strong><?= 'IDR '.number_format($pp).',-' ?></strong></h2>
        </div>
      </div>
    </div>
  </div>
  <div class="card clearfix">
    <ul id="client-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
        <li><a id="clients-button" role="presentation" href="javascript:;" data-bs-target="#all">All</a></li>
        <li><a id="clients-button" href="<?php echo_uri("payments/topay/"); ?>" data-bs-target="#to-pay">To Pay</a></li>
        <li><a role="presentation" href="<?php echo_uri("payments/paid/"); ?>" data-bs-target="#paid">Paid</a></li>
        <li><a role="presentation" href="<?php echo_uri("payments/quotation/"); ?>" data-bs-target="#quotation">Quotation</a></li>
        <div class="tab-title clearfix no-border">
          <div class="title-button-group">
            <a href="#" id="exportButton" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#exportModal" style="background:none; cursor: pointer;"><i data-feather="upload" class="icon-16 me-2"></i> Export excel</a>
          </div>
        </div>
        <li><a role="presentation" href="<?php echo_uri("payments/trash/"); ?>" data-bs-target="#trash"><i data-feather="trash" class="icon-16 me-2"></i>Trash</a></li>
    </ul>
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade" id="all">
        <div class="table-responsive">
          <table class="client-table display dataTable" cellspacing="0" width="100%">            
            <thead>
              <tr>
                  <th>No.</th>
                  <th>Payment Name</th>
                  <th>Bill</th>
                  <th>Due Date</th>
                  <th>Tranfer to</th>
                  <th>Status</th>
                  <th></th>
              </tr>
              </thead>
              <tbody>
              <?php foreach($paymentList_All as $key => $p_item): ?>
                <tr>
                  <td><?= $key+1 ?></td>
                  <td><?= $p_item['payment_name'] ?></td>
                  <td><?= 'IDR '.number_format($p_item['payment_bill']).',-' ?></td>
                  <td><?= ($p_item['status'] == "1" OR $p_item['status'] == NULL) ? (strtotime($p_item['payment_due_date']) > strtotime(date("Y-m-d")) ? date("d-m-Y", strtotime($p_item['payment_due_date'])) : '<div class="text-danger"><strong>Overdue</strong><br>'.date("d-m-Y", strtotime($p_item['payment_due_date'])).'</div>') : date("d-m-Y", strtotime($p_item['payment_due_date'])) ?></td>
                  <td><?= $p_item['bank_name'].' - '.$p_item['bank_number']. ' a/n '. $p_item['bank_receiver'] ?></td>
                  <td><?php
                    if($p_item['status'] == '1'){
                        echo '<span class="text-warning"><strong>Pending</strong></span>';
                    } else if($p_item['status'] == '2') {
                        echo '<span class="text-success"><strong>Paid</strong></span>';
                    }  else if($p_item['status'] == '3') {
                        echo '<span class="text-danger"><strong>Invalid</strong></span>';
                    } else {
                      echo '<span class="text-warning"><strong>Pending</strong></span>';
                    }
                  ?></td>
                  <td>
                    <a href="#" class="btn btn-primary detailPayment" data-idpayment="<?= $p_item['id_payment'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <i data-feather="eye" class="icon-16"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="to-pay">
        <div class="table-responsive">
          <table class="client-table display dataTable" cellspacing="0" width="100%">            
            <thead>
              <tr>
                <th>No.</th>
                <th>Payment Name</th>
                <th>Bill</th>
                <th>Due Date</th>
                <th>Tranfer to</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($paymentList_Pending as $key => $p_item): ?>
              <tr>
                <td><?= $key+1 ?></td>
                <td><?= $p_item['payment_name'] ?></td>
                <td><?= 'IDR '.number_format($p_item['payment_bill']).',-' ?></td>
                <td><?= strtotime($p_item['payment_due_date']) > strtotime(date("Y-m-d")) ? date("d-m-Y", strtotime($p_item['payment_due_date'])) : '<div class="text-danger"><strong>Overdue</strong><br>'.date("d-m-Y", strtotime($p_item['payment_due_date'])).'</div>'?></td>
                <td><?= $p_item['bank_name'].' - '.$p_item['bank_number']. ' a/n '. $p_item['bank_receiver'] ?></td>
                <td><?php
                  if($p_item['status'] == '1'){
                      echo '<span class="text-warning"><strong>Pending</strong></span>';
                  } else if($p_item['status'] == '2') {
                      echo '<span class="text-success"><strong>Paid</strong></span>';
                  }  else if($p_item['status'] == '3') {
                      echo '<span class="text-danger"><strong>Invalid</strong></span>';
                  } else {
                    echo '<span class="text-warning"><strong>Pending</strong></span>';
                  }
                ?></td>
                <td>
                  <a href="#" class="btn btn-primary detailPayment" data-idpayment="<?= $p_item['id_payment'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i data-feather="eye" class="icon-16"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="paid">
        <div class="table-responsive">
          <table class="client-table display dataTable" cellspacing="0" width="100%">            
            <thead>
              <tr>
                <th>
                  <a href="#" class="btn btn-primary" id="addToQuotation" data-bs-toggle="modal" data-bs-target="#addToQuotationModal" style="background: #6690F4; border-color:#6690F4;"><i data-feather="plus" class="icon-16"></i></a>
                </th>
                <th>No.</th>
                <th>Payment Name</th>
                <th>Bill</th>
                <th>Due Date</th>
                <th>Tranfer to</th>
                <th>Status</th>
                <th>Paid at</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($paymentList_Paid as $key => $p_item): ?>
              <tr>
                <td>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" multiple value="<?= $p_item['id_payment'] ?>" name="addToQuotation" data-id-payment="<?= $p_item['id_payment'] ?>">
                </div>
                </td>
                <td><?= $key+1 ?></td>
                <td><?= $p_item['payment_name'] ?></td>
                <td><?= 'IDR '.number_format($p_item['payment_bill']).',-' ?></td>
                <td><?= date("d-m-Y", strtotime($p_item['payment_due_date'])) ?></td>
                <td><?= $p_item['bank_name'].' - '.$p_item['bank_number']. ' a/n '. $p_item['bank_receiver'] ?></td>
                <td><?php
                  if($p_item['status'] == '1'){
                      echo '<span class="text-warning"><strong>Pending</strong></span>';
                  } else if($p_item['status'] == '2') {
                      echo '<span class="text-success"><strong>Paid</strong></span>';
                  }  else if($p_item['status'] == '3') {
                      echo '<span class="text-danger"><strong>Invalid</strong></span>';
                  } else {
                    echo '<span class="text-warning"><strong>Pending</strong></span>';
                  }
                ?></td>
                <td>
                  <?= $p_item['transfered_at'] ?>
                </td>
                <td>
                  <div class="d-flex">
                    <a href="#" class="btn btn-primary detailPayment" data-idpayment="<?= $p_item['id_payment'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <i data-feather="eye" class="icon-16"></i>
                    </a>
                    <?= form_open(get_uri('payment/export_excel')) ?>
                      <input type="hidden" value="<?= $p_item['id_payment'] ?>" name="id-payment">
                      <button type="submit" class="btn btn-outline-secondary ms-1"><i data-feather="download" class="icon-16"></i></button>
                    <?= form_close() ?>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="quotation">
        <div class="table-responsive">
          <table class="client-table display dataTable" cellspacing="0" width="100%">            
            <thead>
              <tr>
                <th>No.</th>
                <th>Quotation Name</th>
                <th>Total Payment List</th>
                <th>Created at</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($quotationList as $key => $q_item): ?>
              <tr>
                <td><?= $key+1 ?></td>
                <td><?= $q_item['quotation_name'] ?></td>                
                <td><?= 'IDR '.number_format($q_item['payment_bill']).',-' ?></td>
                <td><?= date("d-m-Y", strtotime($q_item['created_at'])) ?></td>
                <td>
                  <div class="d-flex">
                    <a href="#" class="btn btn-primary detailQuotation" data-idquotation="<?= $q_item['id_quotation'] ?>" data-bs-toggle="modal" data-bs-target="#quotationModal">
                      <i data-feather="eye" class="icon-16"></i>
                    </a>
                    <?= form_open(get_uri('payment/export_excel_quotation')) ?>
                      <input type="hidden" value="<?= $q_item['id_quotation'] ?>" name="id-quotation">
                      <button type="submit" class="btn btn-outline-secondary ms-1"><i data-feather="download" class="icon-16"></i></button>
                    <?= form_close() ?>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane fade" id="trash">
        <div class="table-responsive">
          <table class="client-table display dataTable" cellspacing="0" width="100%">            
            <thead>
              <tr>
                <th>No.</th>
                <th>Payment Name</th>
                <th>Bill</th>
                <th>Due Date</th>
                <th>Tranfer to</th>
                <th>Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($paymentList_Trash as $key => $p_item): ?>
              <tr>
                <td><?= $key+1 ?></td>
                <td><?= $p_item['payment_name'] ?></td>
                <td><?= 'IDR '.number_format($p_item['payment_bill']).',-' ?></td>
                <td><?= date("d-m-Y", strtotime($p_item['payment_due_date'])) ?></td>
                <td><?= $p_item['bank_name'].' - '.$p_item['bank_number']. ' a/n '. $p_item['bank_receiver'] ?></td>
                <td><?php
                  if($p_item['status'] == '1'){
                      echo '<span class="text-warning"><strong>Pending</strong></span>';
                  } else if($p_item['status'] == '2') {
                      echo '<span class="text-success"><strong>Paid</strong></span>';
                  }  else if($p_item['status'] == '3') {
                      echo '<span class="text-danger"><strong>Invalid</strong></span>';
                  } else {
                    echo '<span class="text-warning"><strong>Pending</strong></span>';
                  }
                ?></td>
                <td class="d-flex">
                  <a href="#" class="btn btn-primary detailPayment" data-idpayment="<?= $p_item['id_payment'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i data-feather="eye" class="icon-16"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" aria-labelledby="paymentModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModal">Add Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo form_open(get_uri("#"), array("class" => "general-form", "role" => "form", 'enctype' => 'multipart/form-data')); ?>
        <input type="hidden" id="paymentid" value="" name="paymentid">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="payment-name">Payment Name:</label>
              <input type="text" class="form-control" name="payment-name" id="payment-name" value="" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="payment-name">Project Name:</label>
              <input type="text" class="form-control" name="payment-name" id="payment-project-name" value="" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="payment-bill">Bill:</label>
                <input type="text" class="form-control" name="payment-bill" id="payment-bill" value="" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="payment-due">Due Date:</label>
              <input type="text" name="payment-due-date" value="" autocomplete="off" class="form-control" placeholder="YYYY-MM-DD" id="payment-due-date" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="payment-transfer-to">Transfer to:</label>
              <input type="text" class="form-control" name="payment-transfer-to" id="payment-transfer-to" value="" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="payment-bank">Bank:</label>
              <input type="text" class="form-control" name="payment-bank" id="payment-bank" value="" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="payment-receiver">Receiver name:</label>
              <input type="text" class="form-control" name="payment-receiver" id="payment-receiver" value="" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="payment-created-date">Created date:</label>
                <input type="text" class="form-control" name="payment-created-date" id="payment-created-date" value="" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="payment-shooting-date">Shooting date:</label>
                <input type="text" class="form-control" name="payment-shooting-date" id="payment-shooting-date" value="" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label>Attachment from applicant: <a href="#" class="btn btn-primary badge btnDownload" download>Download</a></label>
                <div id="show-attachment-applicant"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label for="payment-notes">Notes:</label>
                <textarea id="payment-notes" readonly class="form-control"></textarea>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="attachment">Attachment: <a href="#" class="btn btn-primary badge mybtnDownload" download>Download</a></label>
                <div id="show-attachment"></div>
                <input type="file" name="attachment" value="" autocomplete="off" class="form-control h-auto" placeholder="YYYY-MM-DD" id="attachment">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="payment-status">Status:</label>
              <select name="payment-status" id="payment-status" class="form-select">
                  
              </select>
            </div>
            <div class="form-group">
              <label for="message">Message:</label>
              <textarea name="payment-message" id="message" rows="4" class="form-control h-100"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-start p-3">
        <a href="#" class="btn btn-danger" data-idPaymentForDelete="" id="deletePayment">Delete</a>
        <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save and close</button>
        <?php form_close() ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addToQuotationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addToQuotationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addToQuotationModalLabel">Add to Quotation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="addToQuotationModalInput">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="quotationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="quotationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="quotationModalLabel">Detail Quotation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="table-responsive">
          <table class="client-table display" id="quotationDataTable" cellspacing="0" width="100%">
            <thead>
              <th>No.</th>
              <th>Payment Name</th>
              <th>Bill</th>
            </thead>
            <tbody id="quotationModalBody">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exportModal" data-bs-backdrop="static" aria-labelledby="paymentModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">Add Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="exportModalBody">
        
    </div>
  </div>
</div>
<script>
var formatter = new Intl.NumberFormat('en-US', {style: 'currency', currency: 'IDR',});
$(function(){
  $('.detailPayment').on('click', function() {
    const data_id = $(this).data("idpayment");
    $('#paymentModal').html('Detail');
    $('.modal-footer button[type=submit]').html('Update and close');
    $('.modal-body form').attr('action', '<?= get_uri("payment/update_status") ?>');
    let xhttp = new XMLHttpRequest();
    let formData = new FormData();
    formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
    formData.append('id_payment', data_id);
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        let dataResult = JSON.parse(this.responseText);
        console.log(dataResult);
        let currentStatus = null;
        $('#deletePayment').attr("data-idPaymentForDelete", dataResult.id_payment);
        $('#payment-name').val(dataResult.payment_name);
        $('#payment-project-name').val(dataResult.payment_project_name);
        $('#payment-created-date').val(dateFormat(dataResult.created_at));
        $('#payment-shooting-date').val(dateFormat(dataResult.payment_shooting_date));
        $('#payment-transfer-to').val(dataResult.bank_number);
        $('#payment-bank').val(dataResult.bank_name);
        $('#payment-receiver').val(dataResult.bank_receiver);
        $('#payment-notes').val(dataResult.payment_notes);
        $('#payment-bill').val(formatter.format(dataResult.payment_bill));
        $('#payment-due-date').val(dateFormat(dataResult.payment_due_date));
        $('#paymentid').val(dataResult.id_payment);
        $('#message').val(dataResult.message);
        $('#event-form').append(`<input type="hidden" value="${dataResult.id_payment}" name="paymentid">`);
        console.log(dataResult.status);
        if(dataResult.status == '1' || dataResult.status === null){
          currentStatus = `
          <option value="1">Pending</option>
          <option value="2">Paid</option>
          <option value="3">Invalid</option>`
        } else if(dataResult.status == '2'){
          currentStatus = `
          <option value="2">Paid</option>
          <option value="1">Pending</option>
          <option value="3">Invalid</option>`
        } else {
          currentStatus = `
          <option value="3">Invalid</option>
          <option value="2">Paid</option>
          <option value="1">Pending</option>`;
        }
        $('#payment-status').html(currentStatus);
        if(dataResult.attachment_file != null){
          $('#show-attachment').html(`<img src="<?= base_url('files/payment').'/' ?>${dataResult.attachment_file}" class="img-fluid mb-3"/>`);
          $('#show-attachment img').css({'max-height': '300px', 'display': 'block', 'margin-top': '1rem'});
          $('.mybtnDownload').attr("href", '<?= base_url('files/payment').'/' ?>'+dataResult.attachment_file);
          $('.mybtnDownload').removeClass('d-none');
        } else {
          $('.mybtnDownload').addClass('d-none');
          $('#show-attachment').html('');
        }

        if(dataResult.payment_attachment != null){
          $('#show-attachment-applicant').html(`<img src="<?= base_url('files/payment/applicant').'/' ?>${dataResult.payment_attachment}" class="img-fluid mb-3"/>`);
          $('#show-attachment-applicant img').css({'max-height': '300px', 'display': 'block', 'margin-top': '1rem'});
          $('.btnDownload').attr("href", '<?= base_url('files/payment/applicant').'/' ?>'+dataResult.payment_attachment);
          $('.btnDownload').removeClass('d-none');
        } else {
          $('.btnDownload').addClass('d-none');
          $('#show-attachment-applicant').html('');
        }
      }
    };
    xhttp.open("POST", "<?= get_uri("payment/get_payment_ajax") ?>", true);
    xhttp.send(formData);
  });

  $('.detailQuotation').on('click', function() {
    const data_id = $(this).data("idquotation");    
    let xhttp = new XMLHttpRequest();
    let formData = new FormData();
    formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
    formData.append('id_quotation', data_id);
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        let dataResult = JSON.parse(this.responseText);
        data = [];
        for (let index = 0; index < dataResult.length; index++) {
          data.push(`
          <tr>
            <td>${index+1}</td>
            <td>${dataResult[index].payment_name}</td>
            <td>${formatter.format(dataResult[index].payment_bill)}</td>
          </tr>`)
        }
        $('#quotationModalBody').html(data);
      }
    };
    xhttp.open("POST", "<?= get_uri("payment/get_quotation_ajax") ?>", true);
    xhttp.send(formData);
  });


  $('#deletePayment').on('click', function() {
    const data_id = $(this)[0].attributes['data-idpaymentfordelete'].value;
    let xhttp = new XMLHttpRequest();
    let formData = new FormData();
    formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
    formData.append('id_payment', data_id);
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        location.reload();
      }
    };
    xhttp.open("POST", "<?= get_uri("payment/delete_payment_ajax") ?>", true);
    xhttp.send(formData);
  });

  $('#exportButton').on('click', function(){
    $('#exportModalLabel').html('Export to Excel');
    $('#exportModalBody').html(`<?= form_open(get_uri("payment/export_excel"), array("class" => "general-form", "role" => "form", 'enctype' => 'multipart/form-data')); ?>
      <div class="row">
        <div class="col-6">
          <div class="form-group">
              <label for="export-by-date-min">From:</label>
              <input type="text" class="form-control due-date" name="export-by-date-min" value="">
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
              <label for="export-by-date-max">To:</label>
              <input type="text" class="form-control due-date" name="export-by-date-max" value="">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="export-by-condition">Export by:</label>
        <select name="export-by-condition" class="form-select">
          <option value="">All</option>
          <option value="1">Pending</option>
          <option value="2">Paid</option>
          <option value="3">Invalid</option>
        </select>
      </div>
      <div class="modal-footer justify-content-start p-3">
        <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Export to excel</button>
      </div>
    <?= form_close() ?>`);
    setDatePicker(".due-date");
  })

  var arr = [];
	setInterval(()=>{
		if(arr.length == 0) {
			$('#addToQuotation').addClass('disabled');
		} else {
			$('#addToQuotation').removeClass('disabled');
		}
	}, 0)
	$('input[name="addToQuotation"]').on('change', function() {
		var inp = [];
		var data_id = $(this).data('id-payment');
		if($(this).prop("checked") == true) {
			arr.push(data_id);
			for (let i = 0; i < arr.length; i++) {
				inp.push(`<input type="hidden" name="id_payment[]" value="${arr[i]}">`)
        $('#addToQuotationModalInput').html(`<?= form_open(get_uri("payment/add_to_quotation"), array("id" => 'removeComma', "class" => "general-form", "role" => "form", 'enctype' => 'multipart/form-data')); ?><div class="d-none">${inp}</div><div class="form-group"><label>Quotaion Name:</label><input type="text" name="quotation-name" id="quotation-name" class="form-control"></div><div class="form-check mb-3"><label for="quotation-name-random">Generate Automatically</label><input class="form-check-input" type="checkbox" name="quotation-name-random" id="quotation-name-random"></div><button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save and close</button><?= form_close() ?>`);
        $('input[name="quotation-name-random"]').on('change', function() {
          if($(this).prop('checked') == true){
            $('#quotation-name').val('QUOTATION#'+Math.floor(Math.random() * 99999)+'-<?= date('dmY') ?>');
            $('#quotation-name').attr('readonly', 'true')
          } else {
            $('#quotation-name').removeAttr('readonly')
          }
        });
			}
		} else {
			removeA(arr, data_id);
			for (let i = 0; i < arr.length; i++) {
				inp.push(`<input type="hidden" name="id_payment[]" value="${arr[i]}">`)
        $('#addToQuotationModalInput').html(`<?= form_open(get_uri("payment/add_to_quotation"), array("id" => 'removeComma', "class" => "general-form", "role" => "form", 'enctype' => 'multipart/form-data')); ?><div class="d-none">${inp}</div><div class="form-group"><label>Quotaion Name:</label><input type="text" name="quotation-name" id="quotation-name" class="form-control"></div><div class="form-check mb-3"><label for="quotation-name-random">Generate Automatically</label><input class="form-check-input" type="checkbox" name="quotation-name-random" id="quotation-name-random"></div><button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save and close</button><?= form_close() ?>`);
        $('input[name="quotation-name-random"]').on('change', function() {
          if($(this).prop('checked') == true){
            $('#quotation-name').val('QUOTATION#'+Math.floor(Math.random() * 99999)+'-<?= date('dmY') ?>');
            $('#quotation-name').attr('readonly', 'true')
          } else {
            $('#quotation-name').removeAttr('readonly')
          }
        });
			}
		}
	});

  function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
  }

  function dateFormat(args){
    let dateObj = new Date(args);
    let date = ("0" + (dateObj.getDate())).slice(-2);
    let month = ("0" + (dateObj.getMonth()+1)).slice(-2);
    let year = dateObj.getFullYear();
    let res = `${date}-${month}-${year}`;
    return res;
  }

  $('.dataTable').DataTable();
  $('#quotationDataTable').dataTable( {
    "ordering": false,
    "paging":   false,
    "bFilter": false
  });
});
</script>
<style>
.dataTables_wrapper.dt-bootstrap4.no-footer .row{
  padding: 0;
  align-items: center;
}

.dataTables_filter {
  margin: 0;
  padding: 1rem;
}

.dataTables_filter label {
  margin: 0;
}

.dataTables_length label {
  margin: 0;
}

.dataTables_length {
  padding: 1rem;
}

.dataTables_info{
  padding: 1rem;
}

.dataTables_paginate{
  padding: 1rem;
}
</style>