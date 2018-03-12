<?php

require_once '../../configuration.php';

  if(DEBUG){

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

  }

if(isset($_POST['request'])){





  if($_POST['request']=='user-add'){

    $_user = _user(_decrypt($_SESSION['SESSION_USER']));


    $data = "INSERT INTO users (
      fname,lname,username,password,status,lang,role,image) VALUES (?,?,?,?,?,?,?,?)";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_POST['fname'],
        $_POST['lname'],
        $_POST['username'],
        md5($_POST['password']),
        '0',
        '3',
        $_POST['role'],
        'none'
 
      )
    );
    if($res->rowCount()==1) {

   
          echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
        }

    }


  if($_POST['request']=='user-edit'){

      $_user = _user(_decrypt($_SESSION['SESSION_USER']));


      $this_id = $_POST['request_id'];
      $data = "UPDATE users SET
        username = ?,
        password = ?,
        role = ?,
        fname = ?,
        lname = ?

        WHERE user_id = ?";

      $res = $db->prepare($data);
      $res->execute(
        array(
          $_POST['username'],
          md5($_POST['password']),
          $_POST['role'],
          $_POST['fname'],
          $_POST['lname'],
          $this_id
        )
      );
      if($res->rowCount()==1) {

   
          echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
        }

    }




  if($_POST['request']=='remove-users'){
    $this_id = $_POST['request_id'];
      $data = "DELETE FROM users WHERE user_id = ?";
      $delete = $db->prepare($data);
      $delete->execute(array($this_id));
      if($delete){
        echo 1;
      }

      $data2 = "DELETE FROM presence WHERE user_id = ?";
      $delete = $db->prepare($data2);
      $delete->execute(array($this_id));
      if($delete){
        echo 1;
      }
    
  }




}


 ?>
