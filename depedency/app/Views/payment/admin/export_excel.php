<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
if(isset($saveAs['min']) && isset($saveAs['max']) && isset($saveAs['status'])) {
  header("Content-Disposition: attachment; filename=lodger_recap_export-".$saveAs['min']."-".$saveAs['max']."-".$saveAs['status'].".xlsx");
} else {
  header("Content-Disposition: attachment; filename=lodger_recap_export-".$PaymentExport[0]['payment_name'].".xlsx");
}
header('Cache-Control: max-age=0');
?>
<table border="1">
  <thead>
    <tr>
      <th>No.</th>
      <th>Payment Name</th>
      <th>Project Name</th>
      <th>Bill</th>
      <th>Due Date</th>
      <th>Shooting Date</th>
      <th>Notes from Applicant</th>
      <th>Attachment from Applicant</th>
      <th>Attachment from You</th>
      <th>Message from You</th>
      <th>Transfer to</th>
      <th>Status</th>
      <th>Paid at</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($PaymentExport as $key => $value):  ?>
    <tr>
      <td><?= $key+1 ?></td>
      <td><?= $value['payment_name'] ?? '-' ?></td>
      <td><?= $value['payment_project_name'] ?? '-' ?></td>
      <td><?= 'IDR '.number_format($value['payment_bill']).',-' ?></td>
      <td><?= $value['payment_due_date'] ?? '-' ?></td>
      <td><?= $value['payment_shooting_date'] ?? '-' ?></td>
      <td><?= $value['payment_notes'] ?? '-' ?></td>
      <td><?= $value['payment_attachment'] ? base_url('files/payment/applicant/'.$value['payment_attachment']) : '-' ?></td>
      <td><?= $value['attachment_file'] ? base_url('files/payment/'.$value['attachment_file']) : '-' ?></td>
      <td><?= $value['message'] ?? '-' ?></td>
      <td><?= $value['bank_name'].' - '.$value['bank_number'].' - '.$value['bank_receiver'] ?></td>
      <td><?php
        if($value['status'] == '1'){
            echo '<span class="text-warning"><strong>Pending</strong></span>';
        } else if($value['status'] == '2') {
            echo '<span class="text-success"><strong>Paid</strong></span>';
        }  else if($value['status'] == '3') {
            echo '<span class="text-danger"><strong>Invalid</strong></span>';
        } else {
          echo '<span class="text-warning"><strong>Pending</strong></span>';
        }
      ?></td>
      <td><?= date("d-m-Y", strtotime($value['transfered_at'])) ?? '-' ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>