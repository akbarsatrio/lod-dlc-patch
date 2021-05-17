<div id="page-content" class="page-wrapper clearfix">
    <div class="card clearfix">
        <ul id="client-tabs" data-bs-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
            <li><a id="clients-button" role="presentation" href="javascript:;" data-bs-target="#all">All</a></li>
            <li><a id="clients-button" role="presentation" href="javascript:;" data-bs-target="#pending">Pending</a></li>
            <li><a id="clients-button" role="presentation" href="javascript:;" data-bs-target="#paid">Paid</a></li>
            <div class="tab-title clearfix no-border">
                <div class="title-button-group">
                    <button class="btn btn-default addBank" data-bs-toggle="modal" data-bs-target="#modalAdd"><i data-feather="credit-card" class="icon-16 me-2"></i>Add Bank</button>
                    <button class="btn btn-default addPayment" data-bs-toggle="modal" data-bs-target="#modalAdd"><i data-feather="plus-circle" class="icon-16 me-2"></i>Add Data</button>
                </div>
            </div>
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
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($paymentList_All as $key => $p_item): ?>
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
                                <td>
                                    <a href="#" class="btn btn-primary detailPayment" data-idpayment="<?= $p_item['id_payment'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetail">
                                        <i data-feather="eye" class="icon-16"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="pending">
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
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($paymentList_Pending as $key => $p_item): ?>
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
                                <td>
                                    <a href="#" class="btn btn-primary detailPayment" data-idpayment="<?= $p_item['id_payment'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetail">
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
                                <th>No.</th>
                                <th>Payment Name</th>
                                <th>Bill</th>
                                <th>Due Date</th>
                                <th>Tranfer to</th>
                                <th>Status</th>
                                <th>Paid at</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($paymentList_Paid as $key => $p_item): ?>
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
                                <td><?= $p_item['transfered_at'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary detailPayment" data-idpayment="<?= $p_item['id_payment'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetail">
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

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" data-bs-backdrop="static" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalAddLabel">Add Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php echo form_open(get_uri("payment/create"), array("id" => "addForm", "class" => "general-form", "role" => "form", 'enctype' => 'multipart/form-data')); ?>
            <div class="modal-body" id="modalAddBody">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save and close</button>
            </div>
            <?php form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" data-bs-backdrop="static" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalDetailLabel">Detail Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="paymentname">Payment Name:</label>
                            <input type="text" class="form-control" id="payment-name-detail" readonly>
                        </div>                
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="paymentprojectname">Project Name:</label>
                            <input type="text" class="form-control" id="payment-project-name" readonly>
                        </div>                
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-due">Due Date:</label>
                            <input type="text" id="payment-due-date-detail" value="" autocomplete="off" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bill">Bill:</label>
                            <input type="text" class="form-control" id="payment-bill-detail" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label for="payment-transfer-to">Transfer to:</label>
                        <input type="text" class="form-control" id="payment-transfer-to-detail" value="" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label for="payment-bank">Bank:</label>
                        <input type="text" class="form-control" id="payment-bank-detail" value="" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label for="payment-receiver">Receiver name:</label>
                        <input type="text" class="form-control" id="payment-receiver-detail" value="" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-created-date-detail">Created date:</label>
                            <input type="text" class="form-control" name="payment-created-date-detail" id="payment-created-date-detail" value="" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-shooting-date-detail">Shooting date:</label>
                            <input type="text" class="form-control" name="payment-shooting-date-detail" id="payment-shooting-date-detail" value="" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-notes-detail">Your notes:</label>
                            <textarea id="payment-notes-detail" class="form-control h-100" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-message-detail">Message from admin:</label>
                            <textarea id="payment-message-detail" class="form-control h-100" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-my-attachment-detail">Attachment from you: <a href="#" class="btn btn-primary badge mybtnDownload" download>Download</a></label>
                            <img src="" alt="" class="img-fluid" id="payment-my-attachment-detail">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-attachment-detail">Attachment from admin: <a href="#" class="btn btn-primary badge btnDownload" download>Download</a></label>
                            <img src="" alt="" class="img-fluid" id="payment-attachment-detail">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.due-date').datepicker({
    todayBtn: "linked",
    language: "en  ",
    autoclose: true,
    todayHighlight: true,
    format: 'dd/mm/yyyy' 
});
var formatter = new Intl.NumberFormat('en-US', {style: 'currency', currency: 'IDR',});
$(function(){
    $('.addBank').on('click', function() {
        $('#modalAddBody').html(`
        <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Add Bank Account</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">List Bank Account</button>
        </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="form-group mt-3">
                    <label for="bank-name">Bank Name:</label>
                    <input type="text" class="form-control" name="bank-name">
                </div>
                <div class="form-group">
                    <label for="bank-number">Bank Account:</label>
                    <input type="text" class="form-control" name="bank-number">
                </div>
                <div class="form-group">
                    <label for="bank-receiver">Receiver Name:</label>
                    <input type="text" name="bank-receiver" value="" autocomplete="off" class="form-control">
                </div>
                <small class="text-danger">Bank tidak bisa dihapus dan diedit saat akun bank ditambahkan, pastikan diisi dengan benar</small>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Bank Name</th>
                            <th>Bank Number</th>
                            <th>Receiver Name</th>
                        </tr>
                    </thead>
                    <tbody id="add-bank-list">
                        
                    </tbody>
                </table>
            </div>
        </div>
        `);
        $('#addForm').attr('action', '<?= get_uri("payment/bank/create") ?>');
        let xhttp = new XMLHttpRequest();
        let formData = new FormData();
        formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let dataResult = JSON.parse(this.responseText);
                for (let index = 0; index < dataResult.length; index++) {
                    $('#add-bank-list').append(`<tr><td>${dataResult[index].bank_name}</td><td>${dataResult[index].bank_number}</td><td>${dataResult[index].bank_receiver}</td><tr>`); 
                }
            }
        };
        xhttp.open("POST", "<?= get_uri("payment/get_bank_ajax") ?>", true);
        xhttp.send(formData);
    })

    $('.addPayment').on('click', function() {
        $('#modalAddBody').html(`
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment-name">Payment Name:</label>
                    <input type="text" class="form-control" name="payment-name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="project-name">Project Name:</label>
                    <input type="text" class="form-control" name="payment-project-name">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment-bill">Payment Value:</label>
                    <input type="text" class="form-control" name="payment-bill">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment-due">Due Date:</label>
                    <input type="text" name="payment-due-date" value="" autocomplete="off" class="form-control due-date" placeholder="DD-MM-YYYY">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment-shooting-date">Shooting Date:</label>
                    <input type="text" name="payment-shooting-date" id="payment-shooting-date" class="form-control due-date" placeholder="DD-MM-YYYY">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment-transfer-to">Transfer to:</label>
                    <select name="payment-transfer-to" id="payment-transfer-to" class="form-select">
                        <option value="#">Pilih Bank</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment-attachment">Attachment:</label>
                    <input type="file" class="form-control h-auto" name="payment-attachment">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment-notes">Notes:</label>
                    <textarea class="form-control" name="payment-notes"></textarea>
                </div>
            </div>
        </div>`);
        $('.due-date').datepicker({
            todayBtn: "linked",
            language: "en  ",
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy' 
        });
        $('#addForm').attr('action', '<?= get_uri("payment/create") ?>')
        let xhttp = new XMLHttpRequest();
        let formData = new FormData();
        formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let dataResult = JSON.parse(this.responseText);
                for (let index = 0; index < dataResult.length; index++) {
                    $('#payment-transfer-to').append(`<option value="${dataResult[index].id_bank}">${dataResult[index].bank_name} - ${dataResult[index].bank_number} a/n ${dataResult[index].bank_receiver}</option>`); 
                }
            }
        };
        xhttp.open("POST", "<?= get_uri("payment/get_bank_ajax") ?>", true);
        xhttp.send(formData);
    });

    $('.detailPayment').on('click', function() {
        const data_id = $(this).data("idpayment");
        let xhttp = new XMLHttpRequest();
        let formData = new FormData();
        formData.append('<?= csrf_token(); ?>', '<?= csrf_hash(); ?>');
        formData.append('id_payment', data_id);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let dataResult = JSON.parse(this.responseText);
                $('#payment-name-detail').val(dataResult.payment_name);
                $('#payment-project-name').val(dataResult.payment_project_name);
                $('#payment-bill-detail').val(formatter.format(dataResult.payment_bill));
                $('#payment-due-date-detail').val(dateFormat(dataResult.payment_due_date));
                $('#payment-transfer-to-detail').val(dataResult.bank_number);
                $('#payment-bank-detail').val(dataResult.bank_name);
                $('#payment-created-date-detail').val(dateFormat(dataResult.created_at));
                $('#payment-shooting-date-detail').val(dateFormat(dataResult.payment_shooting_date));
                $('#payment-receiver-detail').val(dataResult.bank_receiver);
                $('#payment-notes-detail').val(dataResult.payment_notes);
                $('#payment-message-detail').val(dataResult.message);
                
                $('#payment-attachment-detail').attr('src', '<?= base_url('files/payment').'/' ?>'+dataResult.attachment_file);
                $('#payment-attachment-detail').css({'max-height': '300px', 'display': 'block', 'margin-top': '1rem'});

                $('#payment-my-attachment-detail').attr('src', '<?= base_url('files/payment/applicant').'/' ?>'+dataResult.payment_attachment);
                $('#payment-my-attachment-detail').css({'max-height': '300px', 'display': 'block', 'margin-top': '1rem'});
                if(dataResult.attachment_file == null){
                    $('.btnDownload').addClass('d-none');
                } else {
                    $('.btnDownload').attr("href", '<?= base_url('files/payment').'/' ?>'+dataResult.attachment_file);
                    $('.btnDownload').removeClass('d-none');
                }

                if(dataResult.payment_attachment == null){
                    $('.mybtnDownload').addClass('d-none');
                } else {
                    $('.mybtnDownload').attr("href", '<?= base_url('files/payment/applicant').'/' ?>'+dataResult.payment_attachment);
                    $('.mybtnDownload').removeClass('d-none');
                }
            }
        };
        xhttp.open("POST", "<?= get_uri("payment/get_payment_ajax") ?>", true);
        xhttp.send(formData);
    });

    function dateFormat(args){
        let dateObj = new Date(args);
        let date = ("0" + (dateObj.getDate())).slice(-2);
        let month = ("0" + (dateObj.getMonth()+1)).slice(-2);
        let year = dateObj.getFullYear();
        let res = `${date}-${month}-${year}`;
        return res;
    }

    $('.dataTable').DataTable();
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