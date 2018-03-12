<?php

require_once '../../configuration.php';

  if(DEBUG){

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

  }

if(isset($_POST['request'])){


  if($_POST['request']=='tasks-add'){
    date_default_timezone_set('Europe/Sarajevo');

    $_user = _user(_decrypt($_SESSION['SESSION_USER']));

     $df   = explode('/', $_POST['date']);
     $fromD = $df[2].'-'.$df[1].'-'.$df[0];


    $data = "INSERT INTO presence (
      user_id,date_created,presence,date_presence,comment) VALUES (?,?,?,?,?)";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_POST['user'],
        date('Y-m-d H:i:s'),
        $_POST['presence'],
        date('Y-m-d', strtotime($fromD)),
        $_POST['comment']
      )
    );
    if($res->rowCount()==1) {

   
          echo '<div class="alert alert-success text-center">'._('Informacije su uspješno spašene!').'</div>';
        }

    }





}

?>
