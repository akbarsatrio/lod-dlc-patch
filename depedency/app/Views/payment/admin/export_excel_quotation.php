<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=lodger_quotation_export-".$QuotationName[0]['quotation_name'].".xlsx");
header('Cache-Control: max-age=0');
?>
<table border="1">
  <thead>
    <tr>
      <td colspan="6">
        <p style="margin: 0;">Lodger Quotation</p>
        <h2 style="margin: 0;"><?= $QuotationName[0]['quotation_name'] ?></h2>
        <p></p>
      </td>
    </tr>
    <tr>
      <th>No.</th>
      <th>Payment Name</th>
      <th>Project Name</th>
      <th>Shooting Date</th>
      <th>Paid at</th>
      <th>Amount / Bill</th>
    </tr>
  </thead>
  <tbody>
  <?php $total = 0; foreach($QuotationExport as $key => $value):  $total += $value['payment_bill']?>
    <tr>
      <td><?= $key+1 ?></td>
      <td><?= $value['payment_name'] ?? '-' ?></td>
      <td><?= $value['payment_project_name'] ?? '-' ?></td>
      <td align="right"><?= $value['payment_shooting_date'] ?? '-' ?></td>
      <td align="right"><?= date("d-m-Y", strtotime($value['transfered_at'])) ?? '-' ?></td>
      <td align="right"><?= 'IDR '.number_format($value['payment_bill']).',-' ?></td>
    </tr>
  <?php endforeach; ?>
    <tr>
      <td colspan="5" align="right">Total</td>
      <td><?= 'IDR '.number_format($total).',-' ?></td>
    </tr>
  </tbody>
</table>