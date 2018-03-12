<?php

require_once '../../configuration.php';

  if(DEBUG){

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

  }

if(isset($_POST['request'])){


  if($_POST['request']=='lang-add'){

    if(mkdir($root."/locale/".$_POST['code'], 0755)){

      if(mkdir($root."/locale/".$_POST['code']."/LC_MESSAGES", 0755)){

        $data = "INSERT INTO languages (
          lang_name,lang_code,lang_direction) VALUES (?,?,?)";

        $res = $db->prepare($data);
        $res->execute(
          array(
            $_POST['name'],
            $_POST['code'],
            $_POST['direction']
          )
        );
        if($res->rowCount()==1) {
          echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
        }

      }

    }

  }


  if($_POST['request']=='country-edit'){

    $this_id = $_POST['request_id'];
    $data = "UPDATE countries SET
      name = ?
      WHERE country_id = ?";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_POST['name'],
        $this_id
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Izmjene su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='hourlyrate_status-add'){

    $data = "INSERT INTO hourlyrate_status (
      name) VALUES (?)";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_POST['name']
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Informacije su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='hourlyrate_status-edit'){

    $this_id = $_POST['request_id'];
    $data = "UPDATE hourlyrate_status SET
      name = ?
      WHERE id = ?";

    $res = $db->prepare($data);
    $res->execute(
      array(
        $_POST['name'],
        $this_id
      )
    );
    if($res->rowCount()==1) {
      echo '<div class="alert alert-success text-center">'._('Izmjene su uspješno sapšene!').'</div>';
    }

  }


  if($_POST['request']=='remove-lang'){
    $this_id = $_POST['request_id'];
    $get = $db->query("SELECT * FROM languages WHERE lang_id='$this_id'");
    if($get->rowCount()>0){
      $row = $get->fetch();
      if(rmdir_recursive($root.'/locale/'.$row['lang_code'])){
        $data = "DELETE FROM languages WHERE lang_id = ?";
        $delete = $db->prepare($data);
        $delete->execute(array($this_id));
        if($delete){
          echo 1;
        }
      }
    }
  }


  if($_POST['request']=='remove-country'){
    $this_id = $_POST['request_id'];
    $data = "DELETE FROM countries WHERE country_id = ?";
    $delete = $db->prepare($data);
    $delete->execute(array($this_id));
    if($delete){
      echo 1;
    }
  }


  if($_POST['request']=='remove-hourlyrate_status'){
    $this_id = explode('-',$_POST['request_id']);
    $this_id = $this_id[1];
    $data = "DELETE FROM hourlyrate_status WHERE id = ?";
    $delete = $db->prepare($data);
    $delete->execute(array($this_id));
    if($delete){
      echo 1;
    }
  }


}


 ?>
