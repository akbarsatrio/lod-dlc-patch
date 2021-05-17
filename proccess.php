<?php

if(isset($_POST['submit'])){
  $_SESSION['hostname'] = $_POST['hostname'];
  $_SESSION['db_name'] = $_POST['db-name'];
  $_SESSION['db_username'] = $_POST['db-username'];
  $_SESSION['db_password'] = $_POST['db-password'];
  $_SESSION['web_path'] = $_POST['web-path'].'/';
  pushTableMySQL();
} else {
  header('Location: index.php');
}

function pushTableMySQL(){
  $mysql = @new mysqli($_SESSION['hostname'], $_SESSION['db_username'], $_SESSION['db_password'], $_SESSION['db_name']);
  if (mysqli_connect_errno()) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => $mysql->connect_error]);
    exit();
  } else {
    $sql = file_get_contents("depedency/database/database.sql");
    $mysql->multi_query($sql);
    do {} while (mysqli_more_results($mysql) && mysqli_next_result($mysql));
    $mysql->close();
    movePatchFiles();
  }
}

function movePatchFiles(){
  $folder = ['Controllers', 'Models', 'Libraries', 'Views'];
  $file = [['Payment.php', 'App_Controller.php'], 'Payment_model.php', 'Left_menu.php', 'payment'];
  $source = 'depedency/app/';
  $destination = $_SESSION['web_path'].'app/';
  for ($i=0; $i < count($folder); $i++) {
    if(!is_dir($destination.$folder[$i])){
      mkdir($destination.$folder[$i], 0755, true);
    }
    if ($i == 0){
      for ($j=0; $j < count($file[$i]); $j++) { 
        rename($source.$folder[$i].'/'.$file[$i][$j], $destination.$folder[$i].'/'.$file[$i][$j]);
      }
    } else {
      rename($source.$folder[$i].'/'.$file[$i], $destination.$folder[$i].'/'.$file[$i]);
    }
  }
  createUploadFolder();
}

function createUploadFolder() {
  if(!is_dir($_SESSION['web_path'].'files/payment')){
    mkdir($_SESSION['web_path'].'files/payment/applicant', 0755, true);
  }
  session_destroy();
  header('Content-Type: application/json');
  echo json_encode(["success" => true, "message" => 'Instalasi Sukses']);
}
